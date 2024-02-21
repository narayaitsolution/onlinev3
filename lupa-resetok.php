<?php
require('system/dbconn.php');
require('system/phpmailer/sendmail.php');

$pass1 = mysqli_real_escape_string($dbsurat, $_POST['pass1']);
$pass2 = mysqli_real_escape_string($dbsurat, $_POST['pass2']);
$kunci = mysqli_real_escape_string($dbsurat, $_POST['kunci']);
$jawaban = mysqli_real_escape_string($dbsurat, $_POST['jawaban']);
$token = $_POST['token'];
$token2 = md5(uniqid());
$passmd5 = md5($pass1);
$status = 1;

if ($kunci == $jawaban) {
    if ($pass1 == $pass2) {
        //cek token
        $stmt = $dbsurat->prepare('SELECT * FROM pengguna WHERE token=? AND status=?');
        $stmt->bind_param('ss', $token, $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $jhasil = $result->num_rows;
        if ($jhasil > 0) {
            $dhasil = $result->fetch_assoc();
            $nama = $dhasil['nama'];
            $nip = $dhasil['nip'];
            $email = $dhasil['email'];

            //update password & token
            $stmt = $dbsurat->prepare('UPDATE pengguna SET pass=?, token=? WHERE nip=?');
            $stmt->bind_param('sss', $passmd5, $token2, $nip);
            $stmt->execute();
            $result = $stmt->get_result();

            //kirim email
            $subject = "Reset Password SAINTEK e-Office BERHASIL";
            $pesan = "Yth. " . $nama . "<br/>
                    <br/>
                    Assalamualaikum wr. wb.
                    <br />
                    <br />
                    Proses reset password anda pada sistem SAINTEK e-Office telah <b>BERHASIL</b>.
                    <br/>
                    Silahkan klik tombol berikut ini masuk kedalam sistem SAINTEK e-Office.
                    <br />
                    <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #03DF00;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>        
                    <br/>
                    atau silahkan copy & paste link berikut ini pada browser anda apabila tombol diatas tidak berfungsi https://saintek.uin-malang.ac.id/online/<br/>
                    <br/>
                    <br/>
                    Apabila anda tidak merasa melakukan permintaan reset password, segera ubah password anda di sistem SAINTEK e-Office.<br/>
                    <br/>        
                    Wassalamualaikum wr. wb.
                    <br/>
                    <br/>
                    <b>SAINTEK e-Office</b>";
            sendmail($email, $nama, $subject, $pesan);

            header("location:index.php?pesan=resetok");
        } else {
            header("location:index.php?pesan=notaktif");
        }
    } else {
        header("location:lupa-reset.php?pesan=pass&token=$token");
    }
} else {
    header("location:lupa-reset.php?pesan=kunci&token=$token");
};

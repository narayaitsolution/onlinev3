<?php
require('system/dbconn.php');
require('system/phpmailer/sendmail.php');

$email = mysqli_real_escape_string($dbsurat, $_POST['email']);
$kunci = mysqli_real_escape_string($dbsurat, $_POST['kunci']);
$jawaban = mysqli_real_escape_string($dbsurat, $_POST['jawaban']);
$token = md5(uniqid());

if ($kunci == $jawaban) {
    $stmt = $dbsurat->prepare('SELECT * FROM pengguna WHERE email=?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $jhasil = $result->num_rows;
    if ($jhasil > 0) {
        $stmt = $dbsurat->prepare("UPDATE pengguna SET token = '$token' WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        //ambil data token
        $sql = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE email='$email'");
        $dsql = mysqli_fetch_array($sql);
        $nama = $dsql['nama'];
        $token = $dsql['token'];

        //kirim email
        $subject = "Reset Password SAINTEK e-Office";
        $pesan = "Yth. " . $nama . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Kami telah menerima permintaan reset password anda pada sistem SAINTEK e-Office.
        <br/>
        Silahkan klik tombol berikut ini untuk me-reset password anda.
		<br />
        <a href='https://saintek.uin-malang.ac.id/online/lupa-reset.php?token=$token' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>Reset Password</a><br/>        
		<br/>
        atau silahkan copy & paste link berikut ini pada browser anda apabila tombol diatas tidak berfungsi https://saintek.uin-malang.ac.id/online/lupa-reset.php?token=$token<br/>
        <br/>
        <br/>
        Apabila anda tidak merasa melakukan permintaan reset password, segera ubah password anda di sistem SAINTEK e-Office.<br/>
        <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #03DF00;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>        
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
        sendmail($email, $nama, $subject, $pesan);
        header("location:index.php?pesan=reset");
    } else {

        header('location:lupa.php?pesan=notregistered');
    }
} else {
    header('location:lupa.php?pesan=antibot');
}

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
    $newpass = rand(10000, 99999);
    $newmd5pass = md5($newpass);
    if ($jhasil > 0) {
        $stmt = $dbsurat->prepare("UPDATE pengguna SET pass=?,token=? WHERE email=?");
        $stmt->bind_param("sss", $newmd5pass, $token, $email);
        $stmt->execute();

        //ambil data token
        $sql = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE email='$email'");
        $dsql = mysqli_fetch_array($sql);
        $nama = $dsql['nama'];
        $user = $dsql['user'];
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
        Berikut ini adalah informasi User ID & Password anda di SAINTEK e-Office
		<br />
        <h1><b>User ID = " . $user . "</b></h1>
		<br/>
        <h1><b>Password = " . $newpass . "</b></h1>
		<br/>
        <br/>
        <b style='color:red;'>Jangan beritahukan informasi diatas kepada siapapun!!.</b><br/>
        <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #03DF00;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>        
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
        sendmail($email, $nama, $subject, $pesan);
        header("location:index.php?pesan=resetok");
    } else {
        header('location:lupa.php?pesan=notregistered');
    }
} else {
    header('location:lupa.php?pesan=antibot');
}

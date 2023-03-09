<?php
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');
session_start();
$nip = $_SESSION['nip'];
if ($_SESSION['nip'] != "198312132019031004") {
    header("../deauth.php");
} else {
    $token = $_GET['token'];
    $aktif = 1;
    $stmt = $dbsurat->prepare('UPDATE pengguna SET aktif=? WHERE token=?');
    $stmt->bind_param('is', $aktif, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE token='$token'");
    $duser = mysqli_fetch_array($quser);
    $namamhs = $duser['nama'];
    $emailmhs = $duser['email'];

    //kirim email ke user
    $subject = "Pendaftaran Akun SAINTEK e-Office";
    $pesan = "Yth. " . $namamhs . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		SELAMAT!! akun anda di SAINTEK e-Office telah aktif.
        <br/>
        Silahkan klik tombol dibawah ini untuk masuk ke SAINTEK e-Office<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
		<br />
        Jangan lupa untuk <b>mengunggah bukti vaksin terakhir anda pada bagian profile pengguna</b>.
        <br/>
        Silahkan membalas email ini apabila ada pertanyaan terkait proses pendaftaran ini
        <br/>        
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";

    sendmail($emailmhs, $namamhs, $subject, $pesan);
}
header("location:index.php?pesan=daftarok");

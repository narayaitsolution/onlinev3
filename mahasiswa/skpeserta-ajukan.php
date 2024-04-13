<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");

$nim = $_SESSION['nip'];
$token = $_GET['token'];

//updatestatussurat
$qupdatestatus = mysqli_query($dbsurat, "UPDATE sk SET statussurat=0 WHERE token='$token' AND nim='$nim'");

//kirim email ke wadek3
//cari email wadek3 dari NIP
$sql2 = mysqli_query($dbsurat, "SELECT * FROM sk WHERE token='$token'");
$dsql2 = mysqli_fetch_array($sql2);
$nipwadek3 = $dsql2['verifikator1'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipwadek3'");
$dsql3 = mysqli_fetch_array($sql3);
$namawadek3 = $dsql3['nama'];
$emailwadek3 = $dsql3['email'];

//kirim email
$subject = "Pengajuan SK Peserta";
$pesan = "Yth. " . $namawadek3 . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan SK Peserta di sistem SAINTEK e-Office.<br/>
        Silahkan klik tombol dibawah ini untuk melakukan verifikasi surat di website SAINTEK e-Office<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailwadek3, $namawadek3, $subject, $pesan);

header("location:index.php");

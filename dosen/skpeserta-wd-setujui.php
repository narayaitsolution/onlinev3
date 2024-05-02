<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');

$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE sk
					SET tglverifikasi1 = '$tgl', 
					verifikasi1 = '1'
					WHERE token = '$token' AND verifikator1='$nip'");

//kirim email ke bagumum
//cari email wadek3 dari NIP
/*
$sql2 = mysqli_query($dbsurat, "SELECT * FROM sk WHERE token='$token'");
$dsql2 = mysqli_fetch_array($sql2);
$nipbagumum = $dsql2['verifikator2'];
$jenissk = $dsql2['jenissk'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipbagumum'");
$dsql3 = mysqli_fetch_array($sql3);
$namabagumum = $dsql3['nama'];
$emailbagumum = $dsql3['email'];
*/
$namabagumum = 'Weni Susilowati, S.AB';
$emailbagumum = 'cikwen@uin-malang.ac.id';

//kirim email
$subject = "Pengajuan SK " . $jenissk . ".";
$pesan = "Yth. " . $namabagumum . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan SK " . $jenissk . " di sistem SAINTEK e-Office.<br/>
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
sendmail($emailbagumum, $namabagumum, $subject, $pesan);

header("location:index.php");

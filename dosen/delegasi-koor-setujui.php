<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');

$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE delegasi
					SET tglvalidasi2 = '$tgl', 
					validasi2 = '1'
					WHERE token = '$token' AND validator2='$nip'");

//kirim email ke wadek3
//cari email wadek3 dari NIP
$sql2 = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE token='$token'");
$dsql2 = mysqli_fetch_array($sql2);
$nama = $dsql2['nama'];
$nipwd3 = $dsql2['validator3'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipwd3'");
$dsql3 = mysqli_fetch_array($sql3);
$namawd3 = $dsql3['nama'];
$emailwd3 = $dsql3['email'];

//kirim email
$subject = "Pengajuan Delegasi";
$pesan = "Yth. " . $namawd3 . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan Delegasi atas nama " . $nama . " di sistem SAINTEK e-Office.<br/>
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
sendmail($emailwd3, $namawd3, $subject, $pesan);

header("location:index.php");

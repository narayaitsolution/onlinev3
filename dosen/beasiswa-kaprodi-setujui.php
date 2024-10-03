<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');

$nip = $_SESSION['nip'];
$token = $_POST['token'];

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE beasiswa
					SET tglvalidasi1 = '$tgl', 
					validasi1 = '1'
					WHERE token = '$token' AND validator1='$nip'");

//kirim email ke wadek3
//cari email wadek3 dari NIP
$sql2 = mysqli_query($dbsurat, "SELECT * FROM beasiswa WHERE token='$token'");
$dsql2 = mysqli_fetch_array($sql2);
$namamhs = $dsql2['nama'];
$nipwadek3 = $dsql2['validator3'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipwadek3'");
$dsql3 = mysqli_fetch_array($sql3);
$namawadek3 = $dsql3['nama'];
$emailwadek3 = $dsql3['email'];

//kirim email
$subject = "Pengajuan Surat Rekomendasi Beasiswa";
$pesan = "Yth. " . $namawadek3 . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat Rekomendasi Beasiswa atas nama " . $namamhs . " di sistem SAINTEK e-Office.<br/>
        Silahkan klik tombol dibawah ini untuk melakukan verifikasi surat di website SAINTEK e-Office<br/>
        <br/>
        <a href='https://eoffice.saintek.uin-malang.ac.id/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailwadek3, $namawadek3, $subject, $pesan);

header("location:index.php?hasil=ok&pesan=Persetujuan Surat Rekomendasi Beasiswa berhasil");

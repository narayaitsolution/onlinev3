<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$keterangan = mysqli_real_escape_string($dbsurat, $_POST['keterangan']);

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE izin
					SET tglvalidasi1 = '$tgl', 
					validasi1 = '2',
                    keterangan='$keterangan',
                    statussurat=2
					WHERE token = '$token' AND validator1='$nip'");

//kirim email;
//cari nip pengaju
$sql2 = mysqli_query($dbsurat, "SELECT * FROM izin WHERE token='$token'");
$dsql2 = mysqli_fetch_array($sql2);
$nippengaju = $dsql2['nip'];
//cari email pengaju
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nippengaju'");
$dsql3 = mysqli_fetch_array($sql3);
$emailpengaju = $dsql3['email'];
$namapengaju = $dsql3['nama'];


$subject = "Pengajuan Izin";
$pesan = "Yth. " . $namapengaju . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan Izin anda di tolak oleh atasan langsung anda dengan alasan <b>" . $keterangan . "</b>.<br/>
        Silahkan klik tombol dibawah ini untuk melakukan pengajuan ulang.<br/>
        <br/>
        <a href='https://eoffice.saintek.uin-malang.ac.id/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailpengaju, $namapengaju, $subject, $pesan);

header("location:index.php");

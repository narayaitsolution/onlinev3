<?php
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE wfh
					SET tglverifikasiprodi = '$tgl', 
					verifikasiprodi = '1'
					WHERE token = '$token'");

//cari nama pembuat surat
$sql1 = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE token='$token'");
$dsql1 = mysqli_fetch_array($sql1);
$namadosen = $dsql1['nama'];

//cari email WD-2
//cari NIP WD-2 dulu
$sql2 = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan='wadek2'");
$dsql2 = mysqli_fetch_array($sql2);
$nip = $dsql2['nip'];
//cari email WD-2 dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nip'");
$dsql3 = mysqli_fetch_array($sql3);
$namawd2 = $dsql3['nama'];
$emailwd2 = $dsql3['email'];

//kirim email
$subject = "Pengajuan Ijin WFH";
$pesan = "Yth. " . $namawd2 . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat Ijin <i>Work From Home</i> atas nama " . $namadosen . " di sistem SAINTEK e-Office.<br/>
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
sendmail($emailwd2, $namawd2, $subject, $pesan);
header("location:index.php");

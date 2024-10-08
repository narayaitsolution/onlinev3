<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');

$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//update status validasi koor mhs
$sql = mysqli_query($dbsurat, "UPDATE delegasi
					SET keteranganlaporan = '$tgl', 
					statuslaporan = '1'
					WHERE token = '$token' AND validator2='$nip'");

//kirim email ke wadek3
//cari email wadek3 dari NIP
$sql2 = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE token='$token'");
$dsql2 = mysqli_fetch_array($sql2);
$nim = $dsql2['nim'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
$dsql3 = mysqli_fetch_array($sql3);
$nama = $dsql3['nama'];
$email = $dsql3['email'];

//kirim email
$subject = "Laporan Delegasi";
$pesan = "Yth. " . $nama . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Laporan Delegasi anda telah disetujui oleh Koordinator Mahasiswa & Alumni Fakultas.<br/>
        <br/>
        <a href='https://eoffice.saintek.uin-malang.ac.id/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($email, $nama, $subject, $pesan);

header("location:index.php?hasil=ok&pesan=Laporan delegasi berhasil disetujui");

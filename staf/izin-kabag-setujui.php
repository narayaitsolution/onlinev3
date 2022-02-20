<?php
session_start();

require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$jmlizin = mysqli_real_escape_string($dbsurat, $_POST['jmlizin']);
$nipbawahan = mysqli_real_escape_string($dbsurat, $_POST['nipbawahan']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);

//update status validasi dosen
$sql = mysqli_query($dbsurat, "UPDATE izin
					SET tglvalidasi2 = '$tgl', 
					validasi2 = '1',
                    statussurat=1
					WHERE token = '$token' and validator2='$nip'");

//update sisa izin
$qsisa = mysqli_query($dbsurat, "UPDATE izinsisa SET sisa = sisa-'$jmlizin' WHERE nip='$nipbawahan'");

//kirim email ke wadek1
//cari email wadek dari NIP
$sql2 = mysqli_query($dbsurat, "SELECT * FROM izin WHERE token='$token'");
$dsql2 = mysqli_fetch_array($sql2);
$nama = $dsql2['nama'];
$nipbawahan = $dsql2['nip'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipbawahan'");
$dsql3 = mysqli_fetch_array($sql3);
$namawadek2 = $dsql3['nama'];
$emailwadek2 = $dsql3['email'];

//kirim email
$surat = 'Izin';
$subject = "Pengajuan Surat " . $surat;
$pesan = "Yth. " . $namawadek2 . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan <b>Surat Izin</b> anda telah disetujui.<br/>
        Silahkan masuk ke sistem SAINTEK e-Office untuk mencetak surat izin anda.<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><r/>
        <br/>
        atau klik URL berikut ini <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailwadek2, $namawadek2, $subject, $pesan);

header("location:index.php");

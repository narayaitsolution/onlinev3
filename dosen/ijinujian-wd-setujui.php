<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');
$nip = $_SESSION['nip'];

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$nim = mysqli_real_escape_string($dbsurat, $_POST['nim']);

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$bulan = date('m');
$tahun = date('Y');
//cari urutan surat di tahun ini untuk no surat
$qurutan = mysqli_query($dbsurat, "SELECT * FROM ijinujian WHERE year(tanggal)=$tahun");
$urutan = mysqli_num_rows($qurutan);

$nosurat = "B-" . $urutan . ".O/FST.01/TL.00/" . $bulan . "/" . $tahun . "";

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE ijinujian
					SET tglvalidasi3 = '$tgl', 
					validasi3 = '1',
					keterangan = '$nosurat',
					statussurat=1
					WHERE token = '$token' AND validator3='$nip'");

//cari NIP pembuat surat dulu
$sql1 = mysqli_query($dbsurat, "SELECT * FROM ijinujian WHERE token='$token'");
$dsql1 = mysqli_fetch_array($sql1);
$nim = $dsql1['nim'];

//cari email pembuat surat dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
$dsql3 = mysqli_fetch_array($sql3);
$namamhs = $dsql3['nama'];
$emailmhs = $dsql3['email'];

//kirim email
$surat = 'Ijin Ujian Skripsi Offline';
$subject = "Pengajuan Surat " . $surat;
$pesan = "Yth. " . $namamhs . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan Surat " . $surat . " anda telah disetujui.<br/>
        Silahkan klik tombol dibawah ini mencetak Surat tersebut<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/mahasiswa/ijinpenelitian-cetak.php?nodata=$nodata' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>Cetak Surat</a><br/>
        <br/>
        atau silahkan mencetak melalui website SAINTEK e-Office di <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailmhs, $namamhs, $subject, $pesan);

header("location:index.php");

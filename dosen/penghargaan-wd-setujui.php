<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

$nip = $_SESSION['nip'];

$bulan = date('m');
$tahun = date('Y');
//cari urutan surat di tahun ini untuk no surat
$qurutan = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE year(tanggal)=$tahun");
$urutan = mysqli_num_rows($qurutan);

$nosurat = "B-" . $urutan . ".O/FST.3/KM.01.2/" . $bulan . "/" . $tahun . "";
//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE penghargaan
					SET tglvalidasi3 = '$tgl', 
					validasi3 = '1',
					keterangan = 'Sudah disetujui',
					statussurat = 1
					WHERE token = '$token'");

header("location:index.php");

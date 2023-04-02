<?php
session_start();
require('../system/dbconn.php');
//require('../system/myfunc.php');
//require('../system/PhpSpreadsheet');
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['jabatan'] != "kasubag-akademik") {
    header("location:../deauth.php");
}
$no = 1;
$tahun = date('Y');
date_default_timezone_set('Asia/Jakarta');
$tglhariini = date('Y-m-d');
$tahunlalu = date('Y-m-d', strtotime('-1 year'));

$prodi = $_POST['prodi'];
$tglawal = $_POST['tglawal'];
$tglakhir = $_POST['tglakhir'];

// Set the file name and headers
$filename = 'progress-skripsi-mahasiswa.csv';
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open the output stream
$output = fopen('php://output', 'w');
// Write the column headers to the output stream
fputcsv($output, array('Prodi', 'NIM', 'Pembimbing1', 'Pembimbing2', 'Penguji1', 'Penguji2', 'Tgl Ujian'));

$qskripsi = mysqli_query($dbsurat, "SELECT prodi,nim,pembimbing1,pembimbing2,penguji1,penguji2,tglujian FROM skripsi WHERE tglujian BETWEEN '$tglawal' AND '$tglakhir' ORDER BY nim");
while ($dskripsi = mysqli_fetch_array($qskripsi)) {
    fputcsv($output, $dskripsi);
}
fclose($output);

<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/PhpSpreadsheet');
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

echo $prodi;
echo $tglawal;
echo $tglakhir;

// Create a new spreadsheet object
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
// Select the active worksheet
$worksheet = $spreadsheet->getActiveSheet();

$qskripsi = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE tanggal BETWEEN '$tglawal' AND '$tglakhir'");

<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
$tahun = date('Y');
$no = 1;

$no = $_GET['no'];

$qskpi = mysqli_query($dbsurat, "DELETE FROM skpi_cpl WHERE no='$no'");

header("location:skpi-isi.php?hasil=ok&pesan=Berhasil menghapus data");

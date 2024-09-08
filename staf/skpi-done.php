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

$nim = $_POST['nim'];

$qskpi = mysqli_query($dbsurat, "UPDATE skpi_prestasipenghargaan SET keterangan='done' WHERE nim='$nim'");
$qskpi = mysqli_query($dbsurat, "UPDATE skpi SET keterangan='done' WHERE nim='$nim'");

header("location:index.php?hasil=ok&pesan=Verifikasi SKPI berhasil");

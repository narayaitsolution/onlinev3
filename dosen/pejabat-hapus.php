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
if ($nip != "198312132019031004") {
    header("location:../deauth.php");
}
$nodata = $_GET['no'];

$qhapus = mysqli_query($dbsurat, "DELETE FROM pejabat WHERE no='$nodata'");
if ($qhapus) {
    header("location:pejabat-tampil.php?pesan=success");
} else {
    header("location:pejabat-tampil.php?pesan=gagal");
}

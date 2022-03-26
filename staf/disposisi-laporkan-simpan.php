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
$jab = array("dekan", "wadek1", "wadek2", "wadek3", "kaprodi", "kabag-tu", "kasubag-akademik", "kasubag-pak");

if (!in_array($jabatan, $jab)) {
    header("location:../deauth.php");
}

$tanggal = date('Y-m-d H:i:s');
$kode = mysqli_real_escape_string($dbsurat, "$_POST[kode]");
$qdisposisi = mysqli_query($dbsurat, "UPDATE laporkan SET status=3, tglfollowup='$tanggal' WHERE kode='$kode'");

header("location:index.php");

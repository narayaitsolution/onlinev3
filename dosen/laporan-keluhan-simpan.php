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
$jab = array("dekan", "wadek1", "wadek2", "wadek3");

if (!in_array($jabatan, $jab)) {
    header("location:../deauth.php");
}


$token = mysqli_real_escape_string($dbsurat, "$_POST[token]");
$perintah = $_POST['perintah'];
$petugas = $_POST['petugas'];
$qdisposisi = mysqli_query($dbsurat, "UPDATE laporkan SET status=1, petugas='$petugas', keterangan='$perintah' WHERE kode='$token'");

header("location:index.php");

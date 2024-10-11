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
$prodipejabat = $_POST['prodi'];
$namapejabat = $_POST['dosen'];
$nippejabat = $_POST['nip'];
$kdjabatan = $_POST['kdjabatan'];

$qdosen = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nama='$namapejabat'");
$ddosen = mysqli_fetch_array($qdosen);
$idpejabat = $ddosen['user'];

$qsimpan = mysqli_query($dbsurat, "INSERT INTO pejabat(prodi,kdjabatan,iddosen,nip,nama,jabatan)
                                    VALUES ('$prodipejabat','$kdjabatan','$idpejabat','$nippejabat','$namapejabat','$kdjabatan')");
if ($qsimpan) {
    header("location:pejabat-tampil.php?pesan=success");
} else {
    header("location:pejabat-tampil.php?pesan=gagal");
}

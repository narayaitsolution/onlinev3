<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];

// Pastikan hanya admin yang bisa mengakses halaman ini
if ($nip !== '198312132019031004') {
    header("location:../deauth.php");
    exit();
}

require('../system/dbconn.php');
require('../system/myfunc.php');

// Cek apakah ada data yang dikirimkan
if (isset($_POST['hapus']) && isset($_POST['tokenuser'])) {
    $tokenuser = mysqli_real_escape_string($dbsurat, $_POST['tokenuser']);

    // Hapus user dari database
    $query = "DELETE FROM pengguna WHERE token = ?";
    $stmt = mysqli_prepare($dbsurat, $query);
    mysqli_stmt_bind_param($stmt, "s", $tokenuser);
    mysqli_stmt_execute($stmt);
    header("location: loginas.php?hasil=ok&pesan=sukses hapus pengguna");
    exit();
} else {
    header("location: loginas.php?hasil=notok&pesan=gagal hapus pengguna!!");
}

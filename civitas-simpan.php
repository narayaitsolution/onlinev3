<?php
session_start();
require_once('system/dbconn.php');
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');
$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$token = $_SESSION['token'];
$suhu = mysqli_real_escape_string($dbsurat, $_POST['suhu']);
if ($hakakses == 'mahasiswa') {
    $keperluan = $_POST['keperluan'];
} else {
    $keperluan = 'WFO';
}
if ($suhu >= 37.3) {
    header("location:civitas-masuk.php?pesan=tinggi");
} elseif ($suhu < 35) {
    header("location:civitas-masuk.php?pesan=rendah");
} else {
    $stmt = $dbsurat->prepare("INSERT INTO masukfakultas (tanggal, token, nim, nama, prodi, hakakses,suhu, keperluan, jammasuk)
                                VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $tanggal, $token, $nim, $nama, $prodi, $hakakses, $suhu, $keperluan, $tanggal);
    $stmt->execute();

    header("location:civitas-tampil.php");
}

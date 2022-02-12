<?php
session_start();
require_once('system/dbconn.php');
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');
$suhu = mysqli_real_escape_string($dbsurat, $_POST['suhu']);
$nama = mysqli_real_escape_string($dbsurat, $_POST['nama']);
$instansi = mysqli_real_escape_string($dbsurat, $_POST['instansi']);
$tujuan = mysqli_real_escape_string($dbsurat, $_POST['tujuan']);
$keperluan = mysqli_real_escape_string($dbsurat, $_POST['keperluan']);
$nohp = mysqli_real_escape_string($dbsurat, $_POST['nohp']);
$email = mysqli_real_escape_string($dbsurat, $_POST['email']);
$hakakses = 'tamu';

if ($suhu >= 37.3) {
    header("location:tamu-masuk.php?pesan=tinggi");
} elseif ($suhu < 35) {
    header("location:tamu-masuk.php?pesan=rendah");
} else {
    $stmt = $dbsurat->prepare("INSERT INTO masukfakultas (tanggal, nama, instansiasal, prodi, hakakses,suhu, keperluan, nohp,email,jammasuk)
                                VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssss", $tanggal, $nama, $instansi, $prodi, $hakakses, $suhu, $keperluan, $nohp, $email, $tanggal);
    $stmt->execute();
    $namaurl = urlencode($nama);
    header("location:tamu-tampil.php?nama=$namaurl");
}

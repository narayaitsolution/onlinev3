<?php
session_start();
require_once('system/dbconn.php');
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');
$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$stmt = $dbsurat->prepare("UPDATE masukfakultas SET jamkeluar=? WHERE nim=?");
$stmt->bind_param("ss", $tanggal, $nim);
$stmt->execute();
header("location:civitas-goodbye.php");

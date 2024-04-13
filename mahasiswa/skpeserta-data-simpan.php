<?php
session_start();
require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$nimanggota = $_POST['nimanggota'];
$namaanggota = $_POST['namaanggota'];

$stmt = $dbsurat->prepare("INSERT INTO skpeserta (token,nim, nama) VALUES (?,?,?)");
$stmt->bind_param("sss", $token, $nimanggota, $namaanggota);
$stmt->execute();

$ket = "ok";

header("location:skpeserta-data-isi.php?token=$token&ket=$ket");

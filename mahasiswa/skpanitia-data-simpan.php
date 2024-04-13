<?php
session_start();
require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$nimanggota = $_POST['nimanggota'];
$namaanggota = $_POST['namaanggota'];
$siepanitia = $_POST['siepanitia'];

$stmt = $dbsurat->prepare("INSERT INTO skpanitia (token,nim, nama, siepanitia) 
        VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $token, $nimanggota, $namaanggota, $siepanitia);
$stmt->execute();

$ket = "ok";

header("location:skpanitia-data-isi.php?token=$token&ket=$ket");

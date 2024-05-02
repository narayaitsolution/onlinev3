<?php
session_start();
require_once('../system/dbconn.php');

$nodata = $_POST['nodata'];
$token = $_POST['token'];
$qhapus = mysqli_query($dbsurat, "DELETE FROM skpeserta WHERE no='$nodata' AND token='$token'");

header("location:skpeserta-data-isi.php?token=$token&hasil=ok&pesan=Hapus peserta berhasil");

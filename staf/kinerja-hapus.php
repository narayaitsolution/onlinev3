<?php
session_start();
require('../system/dbconn.php');
$nip = $_SESSION['nip'];

$token = mysqli_real_escape_string($dbsurat, "$_GET[token]");
$qkinerja = mysqli_query($dbsurat, "SELECT * FROM kinerja WHERE token='$token'");
$dkinerja = mysqli_fetch_array($qkinerja);
$bukti = $dkinerja['bukti'];
unlink($bukti);

$qhapus = mysqli_query($dbsurat, "DELETE FROM kinerja WHERE token='$token'");

header("location:kinerja-tampil.php");

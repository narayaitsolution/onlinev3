<?php
session_start();
require('../system/dbconn.php');
$nip = $_SESSION['nip'];

$token = mysqli_real_escape_string($dbsurat, "$_GET[token]");

$qcuti = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE token='$token'");
$dcuti = mysqli_fetch_array($qcuti);
$lampiran = $dcuti['lampiran'];
unlink($lampiran);

$qhapus = mysqli_query($dbsurat, "DELETE FROM cuti WHERE token='$token' and nip='$nip'");

header("location:index.php");

<?php
session_start();

require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$nim = $_SESSION['nip'];

$qlampiran = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE token='$token' AND nim='$nim'");
$dlampiran = mysqli_fetch_array($qlampiran);
$nodata = $dlampiran['no'];
$bukti = $dlampiran['bukti'];
$dokumentasi = $dlampiran['dokumentasi'];
$skkm = $dlampiran['skkm'];
unlink($bukti);
unlink($dokumentasi);
unlink($skkm);

$query3 = mysqli_query($dbsurat, "DELETE FROM penghargaan WHERE token = '$token' AND nim='$nim'");
$query4 = mysqli_query($dbsurat, "DELETE FROM penghargaananggota WHERE nodata='$nodata' AND nimketua='$nim'");
header("location:index.php");

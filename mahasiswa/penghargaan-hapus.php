<?php
session_start();

require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$nim = $_SESSION['nip'];

$qlampiran = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE token='$token' AND nim='$nim'");
$dlampiran = mysqli_fetch_array($qlampiran);
$bukti = $dlampiran['bukti'];
unlink($bukti);

$query3 = mysqli_query($dbsurat, "DELETE FROM penghargaan WHERE token = '$token' AND nim='$nim'");

header("location:index.php");

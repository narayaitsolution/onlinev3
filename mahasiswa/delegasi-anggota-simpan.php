<?php
session_start();

require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$nim = $_SESSION['nip'];

$qdelegasi = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE token='$token' AND nim='$nim'");
$ddelegasi = mysqli_fetch_array($qdelegasi);
$nodata = $ddelegasi['no'];

$query3 = mysqli_query($dbsurat, "UPDATE delegasi SET statussurat='0' WHERE token = '$token' AND nim='$nim'");
$query4 = mysqli_query($dbsurat, "UPDATE delegasianggota SET statussurat='0' WHERE nodata='$nodata' AND nimketua='$nim'");
header("location:index.php");

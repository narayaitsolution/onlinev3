<?php
session_start();

require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$nim = $_SESSION['nip'];

$qpenghargaan = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE token='$token' AND nim='$nim'");
$dpenghargaan = mysqli_fetch_array($qpenghargaan);
$nodata = $dpenghargaan['no'];

$query3 = mysqli_query($dbsurat, "UPDATE penghargaan SET statussurat='0' WHERE token = '$token' AND nim='$nim'");
$query4 = mysqli_query($dbsurat, "UPDATE penghargaananggota SET statussurat='0' WHERE nodata='$nodata' AND nimketua='$nim'");
header("location:index.php");

<?php

require_once('../system/dbconn.php');
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);

$query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE token='$token'");
$data = mysqli_fetch_array($query);
$namalab = $data['namalab'];
$lamp1 = $data['lamp1'];
$lamp4 = $data['lamp4'];
$lamp5 = $data['lamp5'];
$lamp7 = $data['lamp7'];
$lamp8 = $data['lamp8'];
unlink($lamp1);
unlink($lamp4);
unlink($lamp5);
unlink($lamp7);
unlink($lamp8);

$sql3 = mysqli_query($dbsurat, "UPDATE laboratorium	SET kapasitas = kapasitas + 1 WHERE namalab = '$namalab'");

$sql = mysqli_query($dbsurat, "DELETE FROM ijinlab WHERE token='$token'");

header("location:index.php");

<?php
session_start();
require_once('../system/dbconn.php');

$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$qhapus = mysqli_query($dbsurat, "DELETE FROM skpeserta WHERE no='$nodata' AND token='$token'");

header("location:skpeserta-data-isi.php?token=$token");

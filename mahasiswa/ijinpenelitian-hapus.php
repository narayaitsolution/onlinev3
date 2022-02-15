<?php
session_start();
require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$nim = $_SESSION['nip'];

//hapus data
$sql2 = mysqli_query($dbsurat, "DELETE FROM ijinpenelitian WHERE token='$token' and nim='$nim'");

mysqli_close($dbsurat);
header("location:index.php");

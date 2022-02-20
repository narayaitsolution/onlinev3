<?php
session_start();
require('../system/dbconn.php');
$nip = $_SESSION['nip'];

$token = mysqli_real_escape_string($dbsurat, "$_GET[token]");

$qhapus = mysqli_query($dbsurat, "DELETE FROM izin WHERE token='$token' and nip='$nip'");

header("location:index.php");

<?php
session_start();
$nim = $_SESSION['nip'];
require('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);

//hapus
$sql2 = mysqli_query($dbsurat, "DELETE FROM peminjamanalat WHERE token='$token' AND nim='$nim'");

header("location:index.php");

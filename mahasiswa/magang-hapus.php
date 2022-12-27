<?php
session_start();
require('../system/dbconn.php');

//$nodata = mysqli_real_escape_string($dbsurat, $_GET['nodata']);
$token = $_GET['token'];
$nim = $_SESSION['nip'];

//delete file pakta integritas
$query4 = mysqli_query($dbsurat, "SELECT * FROM magang WHERE token = '$token'");
$data = mysqli_fetch_array($query4);
$nodata = $data['no'];
$namafile = $data['lampiran'];
unlink($namafile);

//delete record
$query2 = mysqli_query($dbsurat, "DELETE FROM maganganggota WHERE nodata = '$nodata'");
$query3 = mysqli_query($dbsurat, "DELETE FROM magang WHERE no = '$nodata'");

header("location:index.php");

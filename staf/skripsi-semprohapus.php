<?php
session_start();
require('../system/dbconn.php');
$nip = $_SESSION['nip'];

$nodata = $_GET['nodata'];

$qhapus = mysqli_query($dbsurat, "DELETE FROM sempro WHERE no='$nodata' and operator='$nip'");

header("location:skripsi-isi.php");

<?php
session_start();
require('../system/dbconn.php');
$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$nim = mysqli_real_escape_string($dbsurat, $_POST['nim']);

$sql = "UPDATE skpi_prestasipenghargaan 
					SET verifikasi1=1
					WHERE nim='$nim' AND no='$nodata'";
if (mysqli_query($dbsurat, $sql)) {
    header("location:skpi-dosen-tampil.php?nim=$nim");
} else {
    echo "error " . $mysqli_error($dbsurat);
    header("location:index.php");
}

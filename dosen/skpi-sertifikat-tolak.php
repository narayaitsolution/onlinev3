<?php
session_start();
require_once('../system/dbconn.php');
$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$nim = mysqli_real_escape_string($dbsurat, $_POST['nim']);

$qsertifikat = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE no='$nodata' and nim='$nim'");


$sql = "DELETE FROM skpi_prestasipenghargaan 
					WHERE nim='$nim' AND no='$nodata'";
if (mysqli_query($dbsurat, $sql)) {
    header("location:skpi-tampil.php?nim=$nim");
} else {
    header("location:index.php?pesan=gagal");
}

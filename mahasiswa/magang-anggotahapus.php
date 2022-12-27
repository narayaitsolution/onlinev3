<?php
session_start();
require_once('../system/dbconn.php');

$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$nimanggota = mysqli_real_escape_string($dbsurat, $_GET['nimanggota']);
$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$id = mysqli_real_escape_string($dbsurat, $_POST['id']);
$qhapus = mysqli_query($dbsurat, "DELETE FROM maganganggota WHERE id='$id'");

header("location:magang-isianggota.php?nodata=$nodata&ket=$ket");

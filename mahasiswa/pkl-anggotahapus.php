<?php
session_start();
require_once('../system/dbconn.php');

$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$nimanggota = mysqli_real_escape_string($dbsurat, $_GET['nimanggota']);
$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$id = mysqli_real_escape_string($dbsurat, $_POST['id']);
$qhapus = mysqli_query($dbsurat, "DELETE FROM pklanggota WHERE id='$id'");

header("location:pkl-isianggota.php?nodata=$nodata&hasil=ok&pesan=Hapus anggota berhasil");

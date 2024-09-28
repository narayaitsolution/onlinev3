<?php
session_start();
require('../system/dbconn.php');
$nodata = mysqli_real_escape_string($dbsurat, $_GET['nodata']);
$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);

$qskpi = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE no='$nodata' and nim='$nim'");
$dskpi = mysqli_fetch_array($qskpi);
$bukti = $dskpi['bukti'];

unlink($bukti);

$sql = mysqli_query($dbsurat, "DELETE FROM skpi_prestasipenghargaan WHERE no='$nodata' AND nim='$nim'");
header("location:skpi-isi.php?hasil=ok&pesan=Hapus sertifikat berhasil");

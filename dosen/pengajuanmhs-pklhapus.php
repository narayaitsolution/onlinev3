<?php
session_start();
require('../system/dbconn.php');

//$nodata = mysqli_real_escape_string($dbsurat, $_GET['nodata']);
$nodata = $_GET['nodata'];

//delete file pakta integritas
$query4 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE no = '$nodata'");
$data = mysqli_fetch_array($query4);
$nodata = $data['no'];
$namafile = $data['lampiran'];
unlink($namafile);

//delete file bukti vaksin
/*
$query4 = mysqli_query($dbsurat, "SELECT * FROM pklanggota WHERE nodata = '$nodata'");
while ($data = mysqli_fetch_array($query4)) {
    $buktivaksin = $data['buktivaksin'];
    unlink($buktivaksin);
}
*/

//delete record
$query2 = mysqli_query($dbsurat, "DELETE FROM pklanggota WHERE no = '$nodata'");
$query3 = mysqli_query($dbsurat, "DELETE FROM pkl WHERE no = '$nodata'");

header("location:pengajuanmhs-tampil.php");

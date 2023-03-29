<?php
session_start();
require('../system/dbconn.php');

//$nodata = mysqli_real_escape_string($dbsurat, $_GET['nodata']);
$nodata = $_GET['nodata'];
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//delete file pakta integritas
$query4 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE no = '$nodata'");
$data = mysqli_fetch_array($query4);
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
//$query2 = mysqli_query($dbsurat, "DELETE FROM pklanggota WHERE nodata = '$nodata'");
$query3 = mysqli_query($dbsurat, "UPDATE pkl SET validasi1=3,validasi2=3,validasi3=3,statussurat=3,keterangan='permintaan pembatalan oleh mahasiswa pada tanggal $tgl' WHERE no = '$nodata'");
$query3 = mysqli_query($dbsurat, "UPDATE pklanggota SET statussurat=3 WHERE nodata = '$nodata'");

header("location:pengajuanmhs-tampil.php");

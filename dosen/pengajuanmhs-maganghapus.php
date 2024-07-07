<?php
session_start();
require('../system/dbconn.php');

$nodata = $_GET['nodata'];
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//delete file pakta integritas
$query4 = mysqli_query($dbsurat, "SELECT * FROM magang WHERE no = '$nodata'");
$data = mysqli_fetch_array($query4);
$namafile = $data['lampiran'];
unlink($namafile);

$query3 = mysqli_query($dbsurat, "UPDATE magang SET validasi1=3,validasi2=3,validasi3=3,statussurat=3,keterangan='permintaan pembatalan oleh mahasiswa pada tanggal $tgl' WHERE no = '$nodata'");
$query3 = mysqli_query($dbsurat, "UPDATE magang SET statussurat=3 WHERE nodata = '$nodata'");

header("location:pengajuanmhs-tampil.php?hasil=ok&pesan=Pembatalan Surat Izin PKL berhasil");

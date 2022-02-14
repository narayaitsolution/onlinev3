<?php
require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

$namalab = mysqli_real_escape_string($dbsurat, $_POST['namalab']);
$keterangan = mysqli_real_escape_string($dbsurat, $_POST['keterangan']);

//update status validasi dosen pembimbing
$sql = mysqli_query($dbsurat, "UPDATE ijinlab
					SET tglvalidasi2 = '$tgl', 
					validasi2 = '2',
                    keterangan='$keterangan',
                    statuspengajuan=2
					WHERE token = '$token'");

header("location:index.php");

<?php
session_start();
require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$keterangan = $_POST['keterangan'];

$sql = mysqli_query($dbsurat, "UPDATE beasiswa
					SET tglvalidasi2 = '$tgl', keterangan='$keterangan',
					validasi2 = '2',statussurat='2'
					WHERE token = '$token' AND validator2='$nip'");

header("location:index.php?hasil=ok&pesan=Penolakan Surat Rekomendasi Beasiswa berhasil");

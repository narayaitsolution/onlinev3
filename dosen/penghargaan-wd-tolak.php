<?php
session_start();
require_once('../system/dbconn.php');
$nip = $_SESSION['nip'];

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

$keterangan = mysqli_real_escape_string($dbsurat, $_POST['keterangan']);

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE penghargaan
					SET tglvalidasi3 = '$tgl', 
					validasi3 = '2',
                    keterangan='$keterangan',
                    statussurat=2
					WHERE token = '$token'");

header("location:index.php");

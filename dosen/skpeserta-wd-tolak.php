<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');

$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$keterangan = mysqli_real_escape_string($dbsurat, $_POST['keterangan']);

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE sk
					SET tglverifikasi1 = '$tgl', 
					verifikasi1 = '2',
                    keterangan = '$keterangan'
					WHERE token = '$token' AND verifikator1='$nip'");

header("location:index.php");

<?php
session_start();
require('../system/dbconn.php');

$nip = $_SESSION['nip'];
$nim = mysqli_real_escape_string($dbsurat, $_POST['nim']);
$nosurat = mysqli_real_escape_string($dbsurat, $_POST['nosurat']);
$keterangan = mysqli_real_escape_string($dbsurat, $_POST['keterangan']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

if (empty($keterangan)) {
    header("location:skpi-tampil.php?nim=$nim&respon=kosong");
} else {
    $sql = mysqli_query($dbsurat, "UPDATE skpi_prestasipenghargaan
						SET verifikasi2 = '2', 
								tglverifikasi2 = '$tgl',
								keterangan = '$keterangan'
						WHERE no = '$nosurat' AND nim = '$nim'");
    header("location:index.php");
}

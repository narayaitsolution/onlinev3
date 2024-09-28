<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");

$nim = $_SESSION['nip'];
$token = $_GET['token'];

//hapus pengajuan SK
$qhapusnarsum = mysqli_query($dbsurat, "DELETE FROM skpanitia WHERE token='$token'");
$qhapussk = mysqli_query($dbsurat, "DELETE FROM sk WHERE token='$token'");
header("location:index.php?hasil=ok&pesan=Pengajuan SK berhasil dihapus");

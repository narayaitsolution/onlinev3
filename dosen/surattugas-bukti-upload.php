<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$nip = $_SESSION['nip'];
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$kode = uniqid();
$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['bukti']['tmp_name'];
$laporan = $target_dir . $kode . '.pdf';
move_uploaded_file($fileTmpPath, $laporan);
$info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $laporan);
$filesize = filesize($laporan);
if ($info == 'application/pdf' && $filesize < 5242880) {
    $sql = mysqli_query($dbsurat, "UPDATE surattugas SET bukti='$laporan',statussurat=3 WHERE token='$token' and nip='$nip'");
    header("location:index.php");
} else {
    header("location:index.php?pesan=gagal");
}

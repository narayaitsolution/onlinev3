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

$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['bukti']['tmp_name'];
$bukti_low = imgresize($fileTmpPath);
$dest_path = $target_dir . $nip . '-buktistst-' . $nodata . '.jpg';


if (move_uploaded_file($bukti_low, $dest_path)) {
    $sql = mysqli_query($dbsurat, "UPDATE surattugas SET bukti='$dest_path',statussurat=3 WHERE token='$token' and nip='$nip'");
    header("location:index.php");
} else {
    header("location:index.php?pesan=gagal");
}

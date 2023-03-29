<?php
session_start();

require("../system/dbconn.php");
require("../system/myfunc.php");
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$nama = mysqli_real_escape_string($dbsurat, $_SESSION['nama']);
$prodi = mysqli_real_escape_string($dbsurat, $_SESSION['prodi']);
$hakakses = mysqli_real_escape_string($dbsurat, $_SESSION['hakakses']);
$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$kodeacak = random_str(12);

$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
//$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

$lampiran_low = imgresize($fileTmpPath);
$allowedfileExtensions = array('jpg', 'jpeg');
if (in_array($fileExtension, $allowedfileExtensions)) {
    $dest_path = $target_dir . $kodeacak . 'jpg';
    move_uploaded_file($lampiran_low, $dest_path);
    $fileSize = filesize($dest_path);
    $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dest_path);
    if (($info == 'image/jpg' || $info == 'image/jpeg') && $filesize < 1048576) {
        $stmt = $dbsurat->prepare("UPDATE pkl SET lampiran=? WHERE no=?");
        $stmt->bind_param("si", $dest_path, $nodata);
        $stmt->execute();
        header("location:pkl-isilampiran.php?nodata=$nodata&pesan=success");
    } else {
        header("location:pkl-isilampiran.php?nodata=$nodata&pesan=gagal");
    };
} else {
    header("location:pkl-isilampiran.php?nodata=$nodata&pesan=gagal");
};

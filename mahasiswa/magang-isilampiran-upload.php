<?php
session_start();

require("../system/dbconn.php");
require("../system/myfunc.php");

$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$nama = mysqli_real_escape_string($dbsurat, $_SESSION['nama']);
$prodi = mysqli_real_escape_string($dbsurat, $_SESSION['prodi']);
$hakakses = mysqli_real_escape_string($dbsurat, $_SESSION['hakakses']);

$target_dir = "../lampiran/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$kode = uniqid();
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

// get details of the uploaded file
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

$lampiran_low = imgresize($fileTmpPath);

$dest_path = $target_dir . $kode . '.' . $fileExtension;
if (move_uploaded_file($lampiran_low, $dest_path)) {
    //update data lampiran
    $stmt = $dbsurat->prepare("UPDATE magang SET lampiran=? WHERE no=?");
    $stmt->bind_param("si", $dest_path, $nodata);
    $stmt->execute();
    header("location:magang-isilampiran.php?nodata=$nodata&pesan=success");
} else {
    header("location:magang-isilampiran.php?nodata=$nodata&pesan=gagal");
};

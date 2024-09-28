<?php
session_start();

require("../system/dbconn.php");

// Use filter_input for better input sanitization
$nim = filter_input(INPUT_SESSION, 'nip', FILTER_SANITIZE_STRING);
$nama = filter_input(INPUT_SESSION, 'nama', FILTER_SANITIZE_STRING);
$prodi = filter_input(INPUT_SESSION, 'prodi', FILTER_SANITIZE_STRING);
$hakakses = filter_input(INPUT_SESSION, 'hakakses', FILTER_SANITIZE_STRING);

$target_dir = "../lampiran/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// Validate and sanitize input
$nodata = filter_input(INPUT_POST, 'nodata', FILTER_SANITIZE_NUMBER_INT);
$nimanggota = filter_input(INPUT_POST, 'nimanggota', FILTER_SANITIZE_STRING);

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

// get details of the uploaded file
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

// Improve file type checking
$allowedMimeTypes = ['image/jpeg', 'image/jpg'];
$finfo = new finfo(FILEINFO_MIME_TYPE);
$uploadedFileType = $finfo->file($_FILES['fileToUpload']['tmp_name']);

if (in_array($uploadedFileType, $allowedMimeTypes) && in_array($fileExtension, $allowedfileExtensions)) {
    if ($fileSize <= 1048576) {
        $new_file_name = uniqid() . '.' . $file_extension;
        $dest_path = $target_dir . $new_file_name;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Use prepared statement for better security
            $stmt = $dbsurat->prepare("UPDATE pklanggota SET buktivaksin=? WHERE nodata=? AND nimanggota=?");
            $stmt->bind_param("sis", $dest_path, $nodata, $nimanggota);
            
            if ($stmt->execute()) {
                header("location:pkl-isilampiran.php?nodata=" . urlencode($nodata) . "&hasil=ok&pesan=Upload lampiran berhasil");
                exit();
            } else {
                header("location:pkl-isilampiran.php?nodata=" . urlencode($nodata) . "&hasil=notok&pesan=Upload lampiran gagal");

                exit();
            }
        } else {
            header("location:pkl-isilampiran.php?nodata=" . urlencode($nodata) . "&hasil=notok&pesan=Upload lampiran gagal");
            exit();
        }
    } else {
        header("location:pkl-isilampiran.php?nodata=" . urlencode($nodata) . "&hasil=notok&pesan=Ukuran file maksimal 1 MB");
        exit();
    }
} else {
    header("location:pkl-isilampiran.php?nodata=" . urlencode($nodata) . "&hasil=notok&pesan=Format file harus JPG/JPEG");
    exit();
}
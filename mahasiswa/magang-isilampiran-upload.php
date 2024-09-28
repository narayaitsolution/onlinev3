<?php
session_start();

require("../system/dbconn.php");
require("../system/myfunc.php");

// Validate user session and access rights
if (!isset($_SESSION['nip']) || $_SESSION['hakakses'] !== 'mahasiswa') {
    die("Unauthorized access");
}

$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];

// Validate and sanitize input
$nodata = filter_input(INPUT_POST, 'nodata', FILTER_VALIDATE_INT);
if (!$nodata) {
    die("Invalid input");
}

// File upload configuration
$target_dir = "../lampiran/";
$allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];
$max_file_size = 1 * 1024 * 1024; // 1 MB

// Process file upload
if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
    $file_tmp_path = $_FILES['fileToUpload']['tmp_name'];
    $file_name = basename($_FILES['fileToUpload']['name']);
    $file_size = $_FILES['fileToUpload']['size'];
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validate file type and size
    if (!in_array($file_extension, $allowed_extensions)) {
        header("Location: magang-isilampiran.php?nodata=$nodata&hasil=notok&pesan=File harus format JPG/JPEG");
        exit;
    }
    if ($file_size > $max_file_size) {
        header("Location: magang-isilampiran.php?nodata=$nodata&hasil=notok&pesan=Ukuran file terlalu besar, maksimal 1 MB");
        exit;
    }

    // Generate a unique filename
    $new_file_name = uniqid() . '.' . $file_extension;
    $dest_path = $target_dir . $new_file_name;

    // Resize image if it's not a PDF
    if ($file_extension !== 'pdf') {
        $resized_image = imgresize($file_tmp_path);
        $upload_success = move_uploaded_file($resized_image, $dest_path);
    } else {
        $upload_success = move_uploaded_file($file_tmp_path, $dest_path);
    }

    if ($upload_success) {
        // Update database
        $stmt = $dbsurat->prepare("UPDATE magang SET lampiran=? WHERE no=?");
        $stmt->bind_param("si", $dest_path, $nodata);
        if ($stmt->execute()) {
            header("Location: magang-isilampiran.php?nodata=$nodata&hasil=ok&pesan=Upload lampiran berhasil");
            exit;
        } else {
            header("Location: magang-isilampiran.php?nodata=$nodata&hasil=notok&pesan=Input data gagal!!");
        exit;
        }
    } else {
        header("Location: magang-isilampiran.php?nodata=$nodata&hasil=notok&pesan=Upload file gagal!!");
        exit;
    }
} else {
    header("Location: magang-isilampiran.php?nodata=$nodata&hasil=notok&pesan=Tidak ada file yang diupload!!");
        exit;
}

<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');

// Validate session and user input
if (!isset($_SESSION['nama']) || !isset($_SESSION['nip']) || !isset($_SESSION['prodi'])) {
    die("Unauthorized access");
}

$nama = mysqli_real_escape_string($dbsurat, $_SESSION['nama']);
$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$prodi = mysqli_real_escape_string($dbsurat, $_SESSION['prodi']);
$aktivitas = filter_input(INPUT_POST, 'aktivitas', FILTER_SANITIZE_STRING);
$indonesia = filter_input(INPUT_POST, 'indonesia', FILTER_SANITIZE_STRING);
$english = filter_input(INPUT_POST, 'english', FILTER_SANITIZE_STRING);

$target_dir = "../lampiran/";
$allowed_extensions = ['jpg', 'jpeg'];
$max_file_size = 1048576; // 1MB

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

function secure_upload($file, $kodeacak) {
    global $target_dir, $allowed_extensions, $max_file_size;

    $file_tmp_path = $file['tmp_name'];
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Check file extension
    if (!in_array($file_ext, $allowed_extensions)) {
        return ['status' => false, 'message' => 'Format file harus JPG/JPEG'];
    }

    // Check file size
    if ($file_size > $max_file_size) {
        return ['status' => false, 'message' => 'Ukuran file maksimal 1MB'];
    }

    $new_file_name = $kodeacak . '.jpg';
    $destination = $target_dir . $new_file_name;

    // Verify MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_mime = finfo_file($finfo, $file_tmp_path);
    finfo_close($finfo);

    if ($file_mime !== 'image/jpeg' && $file_mime !== 'image/jpg') {
        return ['status' => false, 'message' => 'Format file harus JPG/JPEG'];
    }

    if (move_uploaded_file($file_tmp_path, $destination)) {
        return ['status' => true, 'path' => $destination];
    } else {
        return ['status' => false, 'message' => 'File upload gagal!!'];
    }
}

// Upload file
$kodeacak = random_str(12);
$upload_result = secure_upload($_FILES['fileToUpload'], $kodeacak);

if (!$upload_result['status']) {
    header("Location: skpi-isi.php?hasil=notok&pesan=" . urlencode($upload_result['message']));
    exit();
}

$dest_path = $upload_result['path'];

// Insert data into database
$stmt = $dbsurat->prepare("INSERT INTO skpi_prestasipenghargaan (tanggal, nim, nama, prodi, aktivitas, indonesia, english, bukti) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $tanggal, $nim, $nama, $prodi, $aktivitas, $indonesia, $english, $dest_path);

if ($stmt->execute()) {
    header("Location: skpi-isi.php?hasil=ok&pesan=Berhasil menyimpan data");
} else {
    unlink($dest_path); // Delete the uploaded file if database insert fails
    header("Location: skpi-isi.php?hasil=notok&pesan=Gagal menyimpan data");
}

$stmt->close();
$dbsurat->close();

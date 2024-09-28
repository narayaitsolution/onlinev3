<?php
session_start();
require('../system/dbconn.php');

// Validate and sanitize input
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
if (!$token) {
    die("Invalid token");
}

// Use prepared statement to delete existing records
$stmt = $dbsurat->prepare("DELETE FROM skpeserta WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->close();

// File upload handling
$allowed_extensions = ['csv', 'txt'];
$max_file_size = 1 * 1024 * 1024; // 1MB

if (!isset($_FILES['filepeserta']) || $_FILES['filepeserta']['error'] !== UPLOAD_ERR_OK) {
    header("location:skpeserta-data-isi.php?token=$token&hasil=notok&pesan=File upload gagal");
    exit;
}

$file = $_FILES['filepeserta'];

// Check file size
if ($file['size'] > $max_file_size) {
    header("location:skpeserta-data-isi.php?token=$token&hasil=notok&pesan=Ukuran file terlalu besar");
    exit;
}

// Check file extension
$file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($file_extension, $allowed_extensions)) {
    header("location:skpeserta-data-isi.php?token=$token&hasil=notok&pesan=Invalid file type");
    exit;
}

// Additional MIME type check
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$allowed_mime_types = [
    'text/csv',
    'text/plain',
    'application/csv',
    'application/x-csv',
    'text/x-csv',
    'application/vnd.ms-excel',
    'text/comma-separated-values'
];

if (!in_array($mime_type, $allowed_mime_types)) {
    header("location:skpeserta-data-isi.php?token=$token&hasil=notok&pesan=Gunakan template yang tersedia");
    exit;
}

// Process CSV file
$row = 1;
$success_count = 0;
if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
    $stmt = $dbsurat->prepare("INSERT INTO skpeserta (token, nim, nama) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $token, $nimpeserta, $namapeserta);

    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if ($row == 1) {
            $row++;
            continue; // Skip header row
        }
        if (count($data) != 2) {
            continue; // Skip invalid rows
        }
        $nimpeserta = trim(filter_var($data[0], FILTER_SANITIZE_STRING));
        $namapeserta = trim(filter_var($data[1], FILTER_SANITIZE_STRING));
        
        if (!empty($nimpeserta) && !empty($namapeserta)) {
            if ($stmt->execute()) {
                $success_count++;
            }
        }
        $row++;
    }
    $stmt->close();
    fclose($handle);

    if ($success_count > 0) {
        header("location:skpeserta-data-isi.php?token=$token&hasil=ok&pesan=File peserta berhasil di upload. $success_count data ditambahkan.");
    } else {
        header("location:skpeserta-data-isi.php?token=$token&hasil=notok&pesan=Tidak ada data valid yang dapat ditambahkan.");
    }
} else {
    header("location:skpeserta-data-isi.php?token=$token&hasil=notok&pesan=Gagal membuka file CSV");
}

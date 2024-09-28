<?php
session_start();
require('../system/dbconn.php');

// Verify user authentication
if (!isset($_SESSION['nim'])) {
    header("Location: ../deauth.php");
    exit();
}

// Validate and sanitize input
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
if (!$token) {
    header("location:skpanitia-data-isi.php?token=$token&hasil=notok&pesan=TOKEN invalid!!");
    exit;
}

// Use prepared statement for DELETE query
$stmt = $dbsurat->prepare("DELETE FROM skpanitia WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->close();

// File upload handling
if (isset($_FILES['filepanitia']) && $_FILES['filepanitia']['error'] == UPLOAD_ERR_OK) {
    $filepanitia = $_FILES['filepanitia']['tmp_name'];
    $filepanitiasize = $_FILES['filepanitia']['size'];
    $filepanitiatype = $_FILES['filepanitia']['type'];

    // Validate file type and size
    $allowedTypes = ['text/csv', 'application/vnd.ms-excel'];
    $maxFileSize = 1 * 1024 * 1024; // 1 MB

    if (in_array($filepanitiatype, $allowedTypes) && $filepanitiasize > 0 && $filepanitiasize <= $maxFileSize) {
        // Process CSV file
        $fileupload = fopen($filepanitia, 'r');
        while (($getData = fgetcsv($fileupload, 10000, ';')) !== FALSE) {
            if (count($getData) != 3) {
                continue; // Skip invalid rows
            }
            $nimpanitia = filter_var($getData[0], FILTER_SANITIZE_STRING);
            $namapanitia = filter_var($getData[1], FILTER_SANITIZE_STRING);
            $siepanitia = filter_var($getData[2], FILTER_SANITIZE_STRING);

            $stmt = $dbsurat->prepare("INSERT INTO skpanitia (token, nim, nama, siepanitia) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $token, $nimpanitia, $namapanitia, $siepanitia);
            $stmt->execute();
            $stmt->close();
        }
        fclose($fileupload);
        header("Location: skpanitia-data-isi.php?token=" . urlencode($token) . "&hasil=ok&pesan=" . urlencode("Upload File berhasil"));
        exit();
    } else {
        header("Location: skpanitia-data-isi.php?token=" . urlencode($token) . "&hasil=notok&pesan=" . urlencode("File harus sesuai template"));
        exit();
    }
} else {
    header("Location: skpanitia-data-isi.php?token=" . urlencode($token) . "&hasil=notok&pesan=" . urlencode("Upload file gagal!!"));
    exit();
}
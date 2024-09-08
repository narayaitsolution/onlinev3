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
$kodeacak = random_str(12);

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

// get details of the uploaded file
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
//$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));
$sertifikat_low = imgresize($fileTmpPath);
$allowedfileExtensions = array('jpg', 'jpeg');

if (in_array($fileExtension, $allowedfileExtensions)) {
    $dest_path = $target_dir . $kodeacak . '.jpg';
    if (move_uploaded_file($sertifikat_low, $dest_path)) {
        $fileSize = filesize($dest_path);
        $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dest_path);
        if (($info == 'image/jpeg') && $fileSize < 1048576) {
            $stmt = $dbsurat->prepare("INSERT INTO skpi_prestasipenghargaan (tanggal, nim, nama, prodi, aktivitas, indonesia, english, bukti) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $tanggal, $nim, $nama, $prodi, $aktivitas, $indonesia, $english, $dest_path);
            if ($stmt->execute()) {
                header("Location: skpi-isi.php?hasil=ok&pesan=Berhasil menyimpan data");
                exit();
            } else {
                unlink($dest_path); // Delete the uploaded file if database insert fails
                header("Location: skpi-isi.php?hasil=notok&pesan=Gagal menyimpan data");
                exit();
            }
        } else {
            unlink($dest_path); // Delete the uploaded file if it's invalid
            header("Location: skpi-isi.php?hasil=notok&pesan=format file HARUS JPG / JPEG!!");
            exit();
        }
    } else {
        header("Location: skpi-isi.php?hasil=notok&pesan=Gagal menyimpan data");
        exit();
    }
} else {
    header("Location: skpi-isi.php?hasil=notok&pesan=format file HARUS JPG / JPEG!!");
    exit();
}

<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');

$nama = mysqli_real_escape_string($dbsurat, $_SESSION['nama']);
$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$prodi = mysqli_real_escape_string($dbsurat, $_SESSION['prodi']);
$aktivitas = mysqli_real_escape_string($dbsurat, $_POST['aktivitas']);
$indonesia = mysqli_real_escape_string($dbsurat, $_POST['indonesia']);
$english = mysqli_real_escape_string($dbsurat, $_POST['english']);

$target_dir = "../lampiran/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
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
    move_uploaded_file($sertifikat_low, $dest_path);
    $fileSize = filesize($dest_path);
    $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dest_path);
    if (($info == 'image/jpg' || $info == 'image/jpeg') && $filesize < 1048576) {
        $stmt = $dbsurat->prepare("INSERT INTO skpi_prestasipenghargaan (tanggal, nim, nama, prodi, aktivitas, indonesia, english,bukti)
        VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss", $tanggal, $nim, $nama, $prodi, $aktivitas, $indonesia, $english, $dest_path);
        $stmt->execute();
        header("location:skpi-isi.php?nodata=$nodata&pesan=success");
    } else {
        header("location:skpi-isi.php?nodata=$nodata&pesan=gagal");
    };
} else {
    header("location:skpi-isi.php?nodata=$nodata&pesan=Format file salah!!");
}

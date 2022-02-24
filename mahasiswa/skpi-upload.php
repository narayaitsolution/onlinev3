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

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

// get details of the uploaded file
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));
$sertifikat_low = imgresize($fileTmpPath);

$dest_path = $target_dir . $nim . '-lampiranskpi-' . $fileName;
echo $dest_path;
if (move_uploaded_file($sertifikat_low, $dest_path)) {
    //update data lampiran
    $stmt = $dbsurat->prepare("INSERT INTO skpi_prestasipenghargaan (tanggal, nim, nama, prodi, aktivitas, indonesia, english,bukti)
                                        VALUES(?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss", $tanggal, $nim, $nama, $prodi, $aktivitas, $indonesia, $english, $dest_path);
    $stmt->execute();
    header("location:skpi-isi.php?nodata=$nodata&pesan=success");
} else {
    header("location:skpi-isi.php?nodata=$nodata&pesan=gagal");
};

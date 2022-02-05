<?php
session_start();

require("../system/dbconn.php");

$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$nama = mysqli_real_escape_string($dbsurat, $_SESSION['nama']);
$prodi = mysqli_real_escape_string($dbsurat, $_SESSION['prodi']);
$hakakses = mysqli_real_escape_string($dbsurat, $_SESSION['hakakses']);

$target_dir = "../lampiran/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

// get details of the uploaded file
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

$allowedfileExtensions = array('jpg', 'jpeg');
echo $fileName;

if (in_array($fileExtension, $allowedfileExtensions)) {
    if ($fileSize <= 1048576) {
        $dest_path = $target_dir . $nim . '-lampiranpkl-' . $nodata . '.' . $fileExtension;
        echo $dest_path;
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            //update data lampiran
            $stmt = $dbsurat->prepare("UPDATE pkl SET lampiran=? WHERE no=?");
            $stmt->bind_param("si", $dest_path, $nodata);
            $stmt->execute();
            header("location:pkl-isilampiran.php?nodata=$nodata&pesan=success");
        } else {
            header("location:pkl-isilampiran.php?nodata=$nodata&pesan=gagal");
        };
    } else {
        header("location:pkl-isilampiran.php?nodata=$nodata&pesan=filesize");
    };
} else {
    header("location:pkl-isilampiran.php?nodata=$nodata&pesan=extention");
};

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
$nimanggota = mysqli_real_escape_string($dbsurat, $_POST['nimanggota']);

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

if (in_array($fileExtension, $allowedfileExtensions)) {
    if ($fileSize <= 1048576) {
        $dest_path = $target_dir . $nimanggota . '-buktivaksin-' . $nodata . '.' . $fileExtension;
        echo $dest_path;
        echo $nimanggota;
        echo $nodata;
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            //update data lampiran
            $stmt = $dbsurat->prepare("UPDATE pklanggota SET buktivaksin=? WHERE nodata=? AND nimanggota=?");
            $stmt->bind_param("sis", $dest_path, $nodata, $nimanggota);
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

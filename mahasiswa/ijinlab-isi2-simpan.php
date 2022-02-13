<?php
session_start();
require("../system/dbconn.php");
require("../system/myfunc.php");
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$token = $_POST['token'];
$nim = $_SESSION['nip'];
$lampiranke = $_POST['lampiranke'];

$target_dir = "../lampiran/";
//$filescreening = basename($_FILES["filescreening"]["name"]);
$filescreening = $_FILES['filescreening']['tmp_name'];
$filescreening_low = imgresize($filescreening);
if ($lampiranke == '1') {
    $filescreening_upload = $target_dir . $nim . '-filescreening.jpg';
    if (move_uploaded_file($filescreening_low, $filescreening_upload)) {
        $qupdate = mysqli_query($dbsurat, "UPDATE ijinlab SET lamp1 = '$filescreening_upload' WHERE token ='$token'");
        header("location:ijinlab-isi2.php?pesan=success&token=$token");
    } else {
        header("location:ijinlab-isi2.php?pesan=gagal&token=$token");
    }
} elseif ($lampiranke == '4') {
    $filescreening_upload = $target_dir . $nim . '-karantinamandiri.jpg';
    if (move_uploaded_file($filescreening_low, $filescreening_upload)) {
        $qupdate = mysqli_query($dbsurat, "UPDATE ijinlab SET lamp4 = '$filescreening_upload' WHERE token ='$token'");
        header("location:ijinlab-isi2.php?pesan=success&token=$token");
    } else {
        header("location:ijinlab-isi2.php?pesan=gagal&token=$token");
    }
} elseif ($lampiranke == '5') {
    $filescreening_upload = $target_dir . $nim . '-prokes.jpg';
    if (move_uploaded_file($filescreening_low, $filescreening_upload)) {
        $qupdate = mysqli_query($dbsurat, "UPDATE ijinlab SET lamp5 = '$filescreening_upload' WHERE token ='$token'");
        header("location:ijinlab-isi2.php?pesan=success&token=$token");
    } else {
        header("location:ijinlab-isi2.php?pesan=gagal&token=$token");
    }
} elseif ($lampiranke == '7') {
    $filescreening_upload = $target_dir . $nim . '-karantinamalang.jpg';
    if (move_uploaded_file($filescreening_low, $filescreening_upload)) {
        $qupdate = mysqli_query($dbsurat, "UPDATE ijinlab SET lamp7 = '$filescreening_upload' WHERE token ='$token'");
        header("location:ijinlab-isi2.php?pesan=success&token=$token");
    } else {
        header("location:ijinlab-isi2.php?pesan=gagal&token=$token");
    }
} elseif ($lampiranke == '8') {
    $filescreening_upload = $target_dir . $nim . '-persetujuanortu.jpg';
    if (move_uploaded_file($filescreening_low, $filescreening_upload)) {
        $qupdate = mysqli_query($dbsurat, "UPDATE ijinlab SET lamp8 = '$filescreening_upload' WHERE token ='$token'");
        header("location:ijinlab-isi2.php?pesan=success&token=$token");
    } else {
        header("location:ijinlab-isi2.php?pesan=gagal&token=$token");
    }
}

// get details of the uploaded file
//$fileName = $_FILES['fileToUpload']['name'];
//$fileSize = $_FILES['fileToUpload']['size'];
//$fileType = $_FILES['fileToUpload']['type'];
//$fileNameCmps = explode(".", $fileName);
//$fileExtension = strtolower(end($fileNameCmps));

/*
if (in_array($fileExtension, $allowedfileExtensions)) {
    if ($fileSize <= 1048576) {
        $dest_path = $target_dir . $nim . '-ijinlab-' . $nodata . '-' . $lampiran . '.' . $fileExtension;
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            //update data lampiran
            if ($lampiran == 'lamp1') {
                $stmt = $dbsurat->prepare("UPDATE ijinlab SET lamp1=? WHERE no=?");
            } elseif ($lampiran == 'lamp4') {
                $stmt = $dbsurat->prepare("UPDATE ijinlab SET lamp4=? WHERE no=?");
            } elseif ($lampiran == 'lamp5') {
                $stmt = $dbsurat->prepare("UPDATE ijinlab SET lamp5=? WHERE no=?");
            } elseif ($lampiran == 'lamp6') {
                $stmt = $dbsurat->prepare("UPDATE ijinlab SET lamp6=? WHERE no=?");
            } elseif ($lampiran == 'lamp7') {
                $stmt = $dbsurat->prepare("UPDATE ijinlab SET lamp7=? WHERE no=?");
            } elseif ($lampiran == 'lamp8') {
                $stmt = $dbsurat->prepare("UPDATE ijinlab SET lamp8=? WHERE no=?");
            };
            $stmt->bind_param("si", $dest_path, $nodata);
            $stmt->execute();
            header("location:ijinlab-isi2.php?nodata=$nodata&pesan=success");
        } else {
            header("location:ijinlab-isi2.php?nodata=$nodata&pesan=gagal");
        };
    } else {
        header("location:ijinlab-isi2.php?nodata=$nodata&pesan=filesize");
    };
} else {
    header("location:ijinlab-isi2.php?nodata=$nodata&pesan=extention");
};
*/
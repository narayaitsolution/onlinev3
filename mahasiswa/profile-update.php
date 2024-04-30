<?php
session_start();
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "mahasiswa") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');
$no = 1;
$tahun = date('Y');

$nama = $_POST['nama'];
$nip = $_POST['nip'];
$nohp = $_POST['nohp'];
$email = $_POST['email'];
$prodi = $_POST['prodi'];
//$userid = $_POST['userid'];
//$pass = $_POST['pass'];
//$passmd5 = md5(strtolower($pass));
$kodeacak = random_str(12);

$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

if (!empty($fileName)) {
    $buktivaksin_low = imgresize($fileTmpPath);
    $allowedfileExtensions = array('jpg', 'jpeg');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $dest_path = $target_dir . $kodeacak . '.jpg';
        move_uploaded_file($buktivaksin_low, $dest_path);
        $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dest_path);
        if (($info == 'image/jpg' || $info == 'image/jpeg') && $fileSize < 1048576) {
            $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nohp=?,email=?,prodi=?,buktivaksin=? 
                                        WHERE nip=?");
            $stmt->bind_param("ssssss", $nama, $nohp, $email, $prodi, $dest_path, $nip);
            $stmt->execute();
            header("location:profile-tampil.php?nip=$nip&pesan=success");
        } else {
            header("location:profile-tampil.php?nip=$nip&pesan=gagal");
        };
    } else {
        header("location:profile-tampil.php?nip=$nip&pesan=extention");
    };
} else {
    $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nohp=?,email=?,prodi=? 
                                        WHERE nip=?");
    $stmt->bind_param("sssss", $nama, $nohp, $email, $prodi, $nip);
    $stmt->execute();
    header("location:profile-tampil.php?nip=$nip&pesan=success");
}

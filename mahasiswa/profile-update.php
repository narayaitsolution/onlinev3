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
$nip = mysqli_real_escape_string($dbsurat, $_POST['nip']);
$nohp = mysqli_real_escape_string($dbsurat, $_POST['nohp']);
$email = mysqli_real_escape_string($dbsurat, $_POST['email']);
$prodi = mysqli_real_escape_string($dbsurat, $_POST['prodi']);
$userid = mysqli_real_escape_string($dbsurat, $_POST['userid']);
$pass = $_POST['pass'];
$passmd5 = md5(strtolower($pass));
$kodeacak = random_str(12);

$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
//$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

if (!empty($fileName)) {
    $buktivaksin_low = imgresize($fileTmpPath);
    $allowedfileExtensions = array('jpg', 'jpeg');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $dest_path = $target_dir . $kodeacak . '.jpg';
        move_uploaded_file($buktivaksin_low, $dest_path);
        $fileSize = filesize($dest_path);
        $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dest_path);
        if (($info == 'image/jpg' || $info == 'image/jpeg') && $filesize < 1048576) {
            $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nohp=?,email=?,prodi=?,user=?,pass=?,buktivaksin=? 
                                        WHERE nip=?");
            $stmt->bind_param("ssssssss", $nama, $nohp, $email, $prodi, $userid, $passmd5, $dest_path, $nip);
            $stmt->execute();
            header("location:profile-tampil.php?nip=$nip&pesan=success");
        } else {
            header("location:profile-tampil.php?nip=$nip&pesan=gagal");
        };
    } else {
        header("location:profile-tampil.php?nip=$nip&pesan=extention");
    };
} else {
    $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nohp=?,email=?,prodi=?,user=?,pass=? 
                                        WHERE nip=?");
    $stmt->bind_param("sssssss", $nama, $nohp, $email, $prodi, $userid, $passmd5, $nip);
    $stmt->execute();
    header("location:profile-tampil.php?nip=$nip&pesan=success");
}

<?php
session_start();
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "dosen") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');
$no = 1;
$tahun = date('Y');

$nama = mysqli_real_escape_string($dbsurat, $_POST['nama']);
$nip = mysqli_real_escape_string($dbsurat, $_POST['nip']);
$nohp = mysqli_real_escape_string($dbsurat, $_POST['nohp']);
$email = mysqli_real_escape_string($dbsurat, $_POST['email']);
$prodi = mysqli_real_escape_string($dbsurat, $_POST['prodi']);
$userid = mysqli_real_escape_string($dbsurat, $_POST['userid']);
$pass = mysqli_real_escape_string($dbsurat, $_POST['pass']);
$passmd5 = md5($pass);

$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

$allowedfileExtensions = array('jpg', 'jpeg');

if (in_array($fileExtension, $allowedfileExtensions)) {
    if ($fileSize <= 1048576) {
        $dest_path = $target_dir . $nip . '-buktivaksin.jpg';
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nip=?,nohp=?,email=?,prodi=?,user=?,pass=?,buktivaksin=? 
                                        WHERE nip=?");
            $stmt->bind_param("sssssssss", $nama, $nip, $nohp, $email, $prodi, $userid, $passmd5, $dest_path, $nip);
            $stmt->execute();
            header("location:profile-tampil.php?nip=$nip&pesan=success");
        } else {
            header("location:profile-tampil.php?nip=$nip&pesan=gagal");
        };
    } else {
        header("location:profile-tampil.php?nip=$nip&pesan=filesize");
    };
} else {
    header("location:profile-tampil.php?nip=$nip&pesan=extention");
};

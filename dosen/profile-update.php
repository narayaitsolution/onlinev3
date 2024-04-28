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

$nama = $_POST['nama'];
$nip = $_POST['nip'];
$nohp = $_POST['nohp'];
$email = $_POST['email'];
$prodi = $_POST['prodi'];
$userid = $_POST['userid'];
$pass = $_POST['pass'];
$pangkat = $_POST['pangkat'];
$golongan = $_POST['golongan'];
$jafung = $_POST['jafung'];
$passmd5 = md5(strtolower($pass));

$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
$fileName = $_FILES['fileToUpload']['name'];
$fileSize = $_FILES['fileToUpload']['size'];
$fileType = $_FILES['fileToUpload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

if (!empty($fileName)) {
    $allowedfileExtensions = array('jpg', 'jpeg');
    $buktivaksin_low = imgresize($fileTmpPath);
    if (in_array($fileExtension, $allowedfileExtensions)) {
        if ($fileSize <= 1048576) {
            $dest_path = $target_dir . $nip . '-buktivaksin.jpg';
            if (move_uploaded_file($buktivaksin_low, $dest_path)) {
                $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nip=?,golongan=?,pangkat=?,jafung=?,nohp=?,email=?,prodi=?,user=?,pass=?,buktivaksin=? 
                                        WHERE nip=?");
                $stmt->bind_param("ssssssssssss", $nama, $nip, $golongan, $pangkat, $jafung, $nohp, $email, $prodi, $userid, $passmd5, $dest_path, $nip);
                $stmt->execute();
                header("location:profile-tampil.php?nip=$nip&hasil=ok&pesan=Perubahan data berhasil");
            } else {
                header("location:profile-tampil.php?nip=$nip&hasil=notok&pesan=Perubahan data gagal");
            };
        } else {
            header("location:profile-tampil.php?nip=$nip&hasil=notok&pesan=Ukuran file terlalu besar");
        };
    } else {
        header("location:profile-tampil.php?nip=$nip&hasil=notok&pesan=File harus format JPG");
    };
} else {
    $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nip=?,golongan=?,pangkat=?,jafung=?,nohp=?,email=?,prodi=?,user=?,pass=? 
                                        WHERE nip=?");
    $stmt->bind_param("sssssssssss", $nama, $nip, $golongan, $pangkat, $jafung, $nohp, $email, $prodi, $userid, $passmd5, $nip);
    $stmt->execute();
    header("location:profile-tampil.php?nip=$nip&hasil=ok&pesan=Perubahan data berhasil");
}

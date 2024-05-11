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

$token = $_POST['token'];
$hakakses = $_POST['hakakses'];
$nama = $_POST['nama'];
$nip = $_POST['nip'];
$nohp = $_POST['nohp'];
$email = $_POST['email'];
$prodi = $_POST['prodi'];
$pangkat = $_POST['pangkat'];
$golongan = $_POST['golongan'];
$jafung = $_POST['jafung'];
$aktif = $_POST['aktif'];

if ($hakakses == 'dosen' || $hakakses == 'tendik') {
    $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nip=?,golongan=?,pangkat=?,jafung=?,nohp=?,email=?,prodi=?,hakakses=?,aktif=?
                                            WHERE token=?");
    $stmt->bind_param("sssssssssss", $nama, $nip, $golongan, $pangkat, $jafung, $nohp, $email, $prodi, $hakakses, $aktif, $token);
    $stmt->execute();
} else {
    $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nip=?,nohp=?,email=?,prodi=?,hakakses=?,aktif=?
                                            WHERE token=?");
    $stmt->bind_param("ssssssss", $nama, $nip, $nohp, $email, $prodi, $hakakses, $aktif, $token);
    $stmt->execute();
}
header("location:index.php?nip=$nip&hasil=ok&pesan=Perubahan data berhasil");

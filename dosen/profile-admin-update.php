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

$tokenuser = $_POST['tokenuser'];
$hakaksesuser = $_POST['hakaksesuser'];
$namauser = $_POST['namauser'];
$nipuser = $_POST['nipuser'];
$nohpuser = $_POST['nohpuser'];
$emailuser = $_POST['emailuser'];
$prodiuser = $_POST['prodiuser'];
$pangkatuser = $_POST['pangkatuser'];
$golonganuser = $_POST['golonganuser'];
$jafunguser = $_POST['jafunguser'];
$aktifuser = $_POST['aktifuser'];

if ($hakaksesuser == 'dosen' || $hakaksesuser == 'tendik') {
    $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nip=?,golongan=?,pangkat=?,jafung=?,nohp=?,email=?,prodi=?,hakakses=?,aktif=?
                                            WHERE token=?");
    $stmt->bind_param("sssssssssss", $namauser, $nipuser, $golonganuser, $pangkatuser, $jafunguser, $nohpuser, $emailuser, $prodiuser, $hakaksesuser, $aktifuser, $tokenuser);
    $stmt->execute();
} else {
    $stmt = $dbsurat->prepare("UPDATE pengguna SET nama=?,nip=?,nohp=?,email=?,prodi=?,hakakses=?,aktif=?
                                            WHERE token=?");
    $stmt->bind_param("ssssssss", $namauser, $nipuser, $nohpuser, $emailuser, $prodiuser, $hakaksesuser, $aktifuser, $tokenuser);
    $stmt->execute();
}
header("location:index.php?nip=$nipuser&hasil=ok&pesan=Perubahan data berhasil");

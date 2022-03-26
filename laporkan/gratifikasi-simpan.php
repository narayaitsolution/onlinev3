<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$penerima = $_POST['penerima'];
$alamat = $_POST['alamat'];
$jabatan = $_POST['jabatan'];
$tempat = $_POST['tempat'];
$waktu = $_POST['waktu'];
$uraian = $_POST['uraian'];
$nilai = $_POST['nilai'];
$bukti = $_FILES['bukti']['tmp_name'];
$kode = random_str(8);
$status = 0;


if ($antibot == $kunci) {
    if (isset($bukti)) {
        $target_dir = "../lampiran/";
        $bukti_low = imgresize($bukti);
        $dest_path = $target_dir . $kode . '.jpg';
    } else {
        $dest_path = '';
    }
    move_uploaded_file($bukti_low, $dest_path);
    $stmt = $dbsurat->prepare("INSERT INTO gratifikasi (tanggal,penerima,alamat,jabatan,tempat,waktu,uraian,nilai,bukti,status,kode)
    VALUES(?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssis", $tanggal, $penerima, $alamat, $jabatan, $tempat, $waktu, $uraian, $nilai, $dest_path, $status, $kode);
    $stmt->execute();

    header("location:laporkan-selesai.php?kode=$kode");
} else {
    header("location:laporkan-isi.php?pesan=hitungsalah");
}

<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$keluhan = $_POST['keluhan'];
$unitkerja = $_POST['unitkerja'];
$judul = mysqli_real_escape_string($dbsurat, "$_POST[judul]");
$laporan = mysqli_real_escape_string($dbsurat, "$_POST[laporan]");
$antibot = $_POST['antibot'];
$kunci = $_POST['kunci'];
$bukti = $_FILES['bukti']['tmp_name'];
$kode = random_str(5);

if (isset($bukti)) {
    $target_dir = "../lampiran/";
    $bukti_low = imgresize($bukti);
    $dest_path = $target_dir . $kode . '.jpg';
} else {
    $dest_path = '';
}

if ($antibot == $kunci) {
    move_uploaded_file($bukti_low, $dest_path);
    $qinsert = mysqli_query($dbsurat, "INSERT INTO laporkan (tanggal,keluhan,unitterkait,judul,laporan,bukti,kode)
                                        VALUES('$tanggal','$keluhan','$unitkerja','$judul','$laporan','$dest_path','$kode')");
    header("location:laporkan-selesai.php?kode=$kode");
} else {
    header("location:laporkan-isi.php?pesan=hitungsalah");
}

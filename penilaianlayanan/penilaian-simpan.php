<?php
require('../system/dbconn.php');
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$kunci = $_POST['kunci'];
$verifikasi = $_POST['verifikasi'];
if ($kunci == $verifikasi) {
    $pelayanan = $_POST['pelayanan'];
    $kecepatan = $_POST['kecepatan'];
    $kejelasan = $_POST['kejelasan'];

    $qpenilaian = mysqli_query($dbsurat, "INSERT INTO penilaianlayanan (tanggal,pelayanan,kecepatan,kejelasan)
                                    VALUES ('$tanggal','$pelayanan','$kecepatan','$kejelasan')");
    header("location:penilaian-selesai.php");
} else {
    header("location:index.php?pesan=hitungsalah");
}

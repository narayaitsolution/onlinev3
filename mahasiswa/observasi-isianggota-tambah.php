<?php
session_start();
require_once('../system/dbconn.php');

$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$nimanggota = mysqli_real_escape_string($dbsurat, $_POST['nimanggota']);
$token =  mysqli_real_escape_string($dbsurat, $_POST['token']);

$carianggota = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nimanggota'");
$hasil = mysqli_num_rows($carianggota);
if ($hasil > 0) {
    $data = mysqli_fetch_array($carianggota);
    $nimanggota2 = $data['nip'];
    $namaanggota2 = $data['nama'];
    $notelepon = $data['nohp'];
    $buktivaksin = $data['buktivaksin'];
    $sql = "INSERT INTO observasianggota (token,nimketua, nimanggota, nama, telepon, buktivaksin) 
			values('$token','$nim','$nimanggota2','$namaanggota2','$notelepon','$buktivaksin')";
    if (mysqli_query($dbsurat, $sql)) {
        $ket = "ok";
    } else {
        $ket = "notok";
    }
} else {
    $ket = "notfound";
}
header("location:observasi-isianggota.php?token=$token&ket=$ket");
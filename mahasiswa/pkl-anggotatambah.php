<?php
session_start();
require_once('../system/dbconn.php');

$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$nimanggota = mysqli_real_escape_string($dbsurat, $_POST['nimanggota']);
$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);

$carianggota = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nimanggota'");
$hasil = mysqli_num_rows($carianggota);
if ($hasil > 0) {
    $data = mysqli_fetch_array($carianggota);
    $nimanggota2 = $data['nip'];
    $namaanggota2 = $data['nama'];
    $notelepon = $data['nohp'];
    $buktivaksin = $data['buktivaksin'];
    if ($buktivaksin == null) {
        $ket = "novaksin";
    } else {
        $sql = "INSERT INTO pklanggota (nodata,nimketua, nimanggota, nama, telepon, buktivaksin) 
                values('$nodata','$nim','$nimanggota2','$namaanggota2','$notelepon','$buktivaksin')";
        if (mysqli_query($dbsurat, $sql)) {
            $ket = "ok";
        } else {
            $ket = "notok";
        }
    }
} else {
    $ket = "notfound";
}
header("location:pkl-isianggota.php?nodata=$nodata&ket=$ket");

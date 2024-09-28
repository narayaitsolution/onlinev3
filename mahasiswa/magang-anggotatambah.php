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
        $stmt = $dbsurat->prepare("INSERT INTO maganganggota (nodata,nimketua, nimanggota, nama, telepon, buktivaksin) 
        VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $nodata, $nim, $nimanggota2, $namaanggota2, $notelepon, $buktivaksin);
        $stmt->execute();
    }
    header("location:magang-isianggota.php?nodata=$nodata&hasil=ok&pesan=Penambahan Anggota Berhasil");
} else {
    header("location:magang-isianggota.php?nodata=$nodata&hasil=notok&pesan=Anggota tidak ditemukan / belum terdaftar");
}


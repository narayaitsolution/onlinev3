<?php
session_start();
$nim = $_SESSION['nip'];
require('../system/dbconn.php');

$nodata = mysqli_real_escape_string($dbsurat, $_GET['nodata']);

$qskpi = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE no='$nodata' AND nim='$nim'");
while ($dskpi = mysqli_fetch_array($qskpi)) {
    $bukti = $dskpi['bukti'];
    if (!empty($bukti)) {
        unlink($bukti);
    }
}

//hapus
$sql2 = mysqli_query($dbsurat, "DELETE FROM  skpi_prestasipenghargaan WHERE no='$nodata' AND nim='$nim'");

header("location:index.php?hasil=ok&pesan=Penghapusan SKPI berhasil");

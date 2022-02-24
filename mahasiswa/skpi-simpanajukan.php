<?php
session_start();
require('../system/dbconn.php');

$nama = $_SESSION['nama'];
$nim = $_SESSION['nip'];
$prodi = $_SESSION['prodi'];
$dosen = $_POST['dosen'];

//cari nip dosen
$stmt = $dbsurat->prepare("SELECT * FROM pengguna WHERE nama=?");
$stmt->bind_param("s", $dosen);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipdosen = $dhasil['nip'];


//cari nip kajur
$kdjabatan = 'kaprodi';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
$stmt->bind_param("ss", $prodi, $kdjabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkaprodi = $dhasil['nip'];

//cari nip wd-1
$jabatan = 'wadek1';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $jabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipwd = $dhasil['nip'];

$qcari = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE nim='$nim'");
$cekdata = mysqli_num_rows($qcari);
if ($cekdata > 0) {
    $qsimpan = mysqli_query($dbsurat, "UPDATE skpi_prestasipenghargaan SET 
																			verifikator1='$nipdosen',
																			verifikator2='$nipkaprodi',
																			verifikator3='$nipwd'
																			WHERE nim='$nim'");

    if ($qsimpan) {
        header("location:index.php");
    } else {
        echo "error " . mysqli_error($dbsurat);
    }
} else {
    $qsimpan = mysqli_query($dbsurat, "INSERT INTO skpi_prestasipenghargaan (nim, nama, prodi,verifikator1,verifikator2,verifikator3) VALUES ('$nim','$nama','$prodi','$nipdosen','$nipkaprodi','$nipwd')");
    if ($qsimpan) {
        header("location:index.php");
    } else {
        echo "error " . mysqli_error($dbsurat);
    }
}

<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$nama =  mysqli_real_escape_string($dbsurat, $_SESSION['nama']);
$nim = $_SESSION['nip'];
$prodi = $_SESSION['prodi'];
//$ttl = mysqli_real_escape_string($dbsurat, $_POST['ttl']);
$alamatasal = mysqli_real_escape_string($dbsurat, $_POST['alamatasal']);
$alamatmalang = mysqli_real_escape_string($dbsurat, $_POST['alamatmalang']);
//$nohp = mysqli_real_escape_string($dbsurat, $_POST['nohp']);
$nohportu = mysqli_real_escape_string($dbsurat, $_POST['nohportu']);
$riwayatpenyakit = mysqli_real_escape_string($dbsurat, $_POST['riwayatpenyakit']);
$posisi = $_POST['posisi'];
$namalab = $_POST['namalab'];
$dosen = $_POST['dosen'];
$tglmulai = $_POST['tglmulai'];
$tglselesai = $_POST['tglselesai'];
$token = md5(uniqid());

//hitung jumlah hari
$jmlhari = (strtotime($tglselesai) - strtotime($tglmulai)) / 60 / 60 / 24;
if ($jmlhari > 30) {
    $tglselesai = date('Y-m-d', strtotime($tglmulai . " +1 month"));
}

//masukin data
$stmt = $dbsurat->prepare("INSERT INTO ijinlab (tanggal, nim, nama, alamatasal, alamatmalang, nohportu, riwayatpenyakit, posisi, prodi, namalab, dosen,tglmulai,tglselesai, token) 
                                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssssssss", $tanggal, $nim, $nama, $alamatasal, $alamatmalang, $nohportu, $riwayatpenyakit, $posisi, $prodi, $namalab, $dosen, $tglmulai, $tglselesai, $token);
$stmt->execute();

header("location:ijinlab-isi2.php?token=$token");

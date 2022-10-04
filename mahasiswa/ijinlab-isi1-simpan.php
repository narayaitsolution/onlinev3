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

//nama dosen
$namadosen = namadosen($dbsurat, $dosen);

//cari kalab
$qkalab = mysqli_query($dbsurat, "SELECT * FROM laboratorium WHERE namalab = '$namalab'");
$dkalab = mysqli_fetch_array($qkalab);
$kalab = $dkalab['kalab'];

//cari kaprodi
$qkaprodi = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE prodi='$prodi' AND kdjabatan='kaprodi'");
$dkaprodi = mysqli_fetch_array($qkaprodi);
$kaprodi = $dkaprodi['nip'];

//cari WD-1
$qwd1 = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE prodi='SAINTEK' AND kdjabatan='wadek1'");
$dwd1 = mysqli_fetch_array($qwd1);
$wd1 = $dwd1['nip'];

//hitung jumlah hari
$jmlhari = (strtotime($tglselesai) - strtotime($tglmulai)) / 60 / 60 / 24;
if ($jmlhari > 180) {
    $tglselesai = date('Y-m-d', strtotime($tglmulai . " +6 month"));
}

//masukin data
$stmt = $dbsurat->prepare("INSERT INTO ijinlab (tanggal, nim, nama, alamatasal, alamatmalang, nohportu, riwayatpenyakit, posisi, prodi, namalab, dosen,tglmulai,tglselesai, validator0, validator1, validator2, validator3, token) 
                                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssssssssssss", $tanggal, $nim, $nama, $alamatasal, $alamatmalang, $nohportu, $riwayatpenyakit, $posisi, $prodi, $namalab, $dosen, $tglmulai, $tglselesai, $dosen, $kalab, $kaprodi, $wd1, $token);
$stmt->execute();

header("location:index.php");

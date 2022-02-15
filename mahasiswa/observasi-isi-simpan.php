<?php
session_start();
require_once('../system/dbconn.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');
$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$nama = mysqli_real_escape_string($dbsurat, $_SESSION['nama']);
$prodi = mysqli_real_escape_string($dbsurat, $_SESSION['prodi']);
$matakuliah = mysqli_real_escape_string($dbsurat, $_POST['matakuliah']);
$dosen = mysqli_real_escape_string($dbsurat, $_POST['dosen']);
$instansi = mysqli_real_escape_string($dbsurat, $_POST['instansi']);
$alamat = mysqli_real_escape_string($dbsurat, $_POST['alamat']);
$tglmulai = $_POST['tglmulai'];
$token = md5(uniqid());

//masukin data
$stmt = $dbsurat->prepare("INSERT INTO observasi (tanggal, nim, nama, prodi, matakuliah, dosen, instansi, alamat, tglpelaksanaan, token) 
                            VALUES (?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssss", $tanggal, $nim, $nama, $prodi, $matakuliah, $dosen, $instansi, $alamat, $tglmulai, $token);
$stmt->execute();
/*
$qpkl = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE nim='$nim' and statussurat=-1");
$dpkl = mysqli_fetch_array($qpkl);
$nodata = $dpkl['no'];
*/
header("location:observasi-isianggota.php?token=$token");

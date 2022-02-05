<?php
session_start();
require_once('../system/dbconn.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');
$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$nama = mysqli_real_escape_string($dbsurat, $_SESSION['nama']);
$prodi = mysqli_real_escape_string($dbsurat, $_SESSION['prodi']);
$instansi = mysqli_real_escape_string($dbsurat, $_POST['instansi']);
$tempatpkl = mysqli_real_escape_string($dbsurat, $_POST['tempatpkl']);
$alamat = mysqli_real_escape_string($dbsurat, $_POST['alamat']);
$tglmulai = $_POST['tglmulai'];
$tglselesai = $_POST['tglselesai'];
$jenispkl = $_POST['jenispkl'];
$pklmagang = $_POST['pklmagang'];


//masukin data
$stmt = $dbsurat->prepare("INSERT INTO pkl (tanggal, prodi, nim, nama, instansi, tempatpkl, alamat, tglmulai, tglselesai, pklmagang, jenispkl) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssssss", $tanggal, $prodi, $nim, $nama, $instansi, $tempatpkl, $alamat, $tglmulai, $tglselesai, $pklmagang, $jenispkl);
$stmt->execute();

$qpkl = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE nim='$nim' and statussurat=-1");
$dpkl = mysqli_fetch_array($qpkl);
$nodata = $dpkl['no'];

header("location:pkl-isianggota.php?nodata=$nodata");

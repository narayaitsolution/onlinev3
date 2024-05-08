<?php
session_start();
require_once('../system/dbconn.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');
$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$instansi = $_POST['instansi'];
$tempatpkl = $_POST['tempatpkl'];
$alamat = $_POST['alamat'];
$tembusan = $_POST['tembusan'];
$tglmulai = $_POST['tglmulai'];
$tglselesai = $_POST['tglselesai'];
$jenispkl = $_POST['jenispkl'];
$pklmagang = $_POST['pklmagang'];
$token = md5(microtime());

//masukin data
$stmt = $dbsurat->prepare("INSERT INTO pkl (tanggal, prodi, nim, nama, instansi, tempatpkl, alamat, tglmulai, tglselesai, pklmagang, tembusan, jenispkl,token) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssssssss", $tanggal, $prodi, $nim, $nama, $instansi, $tempatpkl, $alamat, $tglmulai, $tglselesai, $pklmagang, $tembusan, $jenispkl, $token);
$stmt->execute();

$qpkl = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE nim='$nim' and statussurat=-1");
$dpkl = mysqli_fetch_array($qpkl);
$nodata = $dpkl['no'];

header("location:pkl-isianggota.php?nodata=$nodata");

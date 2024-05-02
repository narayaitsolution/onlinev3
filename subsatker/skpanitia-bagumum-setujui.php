<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');
date_default_timezone_set("Asia/Jakarta");
$tglsekarang = date('Y-m-d H:i:s');
$tahun = date('Y');
$bulan = date('m');

$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$nosurat = mysqli_real_escape_string($dbsurat, $_POST['nosurat']);
$pembiayaan = $_POST['pembiayaan'];

//update status validasi kaprodi
$keterangan = $nosurat . '/FST/' . $bulan . '/' . $tahun;
$statussurat = 1;
$verifikasi2 = 1;

$stmt = $dbsurat->prepare("UPDATE sk 
                            SET keterangan=?, pembiayaan=?,verifikasi2=?,tglverifikasi2=?,nosurat=?,statussurat=?
                            WHERE token=?");
$stmt->bind_param("sssssss", $keterangan, $pembiayaan, $verifikasi2, $tglsekarang, $nosurat, $statussurat, $token);
$stmt->execute();

header("location:index.php?hasil=ok&pesan=Silahkan cetak sebagai PDF / unduh SK ini untuk diberi Tanda Tangan Elektronik di sistem TTE Kemenag");

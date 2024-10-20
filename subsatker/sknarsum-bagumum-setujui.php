<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');
date_default_timezone_set("Asia/Jakarta");
$tglsekarang = date('Y-m-d H:i:s');
$tahun = date('Y');
$bulan = date('m');

$nip = $_SESSION['nip'];
$token = $_POST['token'];
$nosurat = $_POST['nosurat'];
$namakegiatan = $_POST['namakegiatan'];
$ormas = $_POST['ormas'];
$tema = $_POST['tema'];
$pembiayaan = $_POST['pembiayaan'];

//update status validasi kaprodi
$keterangan = $nosurat . '/FST/' . $bulan . '/' . $tahun;
$statussurat = 1;
$verifikasi2 = 1;

$stmt = $dbsurat->prepare("UPDATE sk 
                            SET namakegiatan=?,ormas=?,tema=?,keterangan=?, pembiayaan=?,verifikasi2=?,tglverifikasi2=?,nosurat=?,statussurat=?
                            WHERE token=?");
$stmt->bind_param("ssssssssss", $namakegiatan, $ormas, $tema, $keterangan, $pembiayaan, $verifikasi2, $tglsekarang, $nosurat, $statussurat, $token);
$stmt->execute();

header("location:index.php?hasil=ok&pesan=Silahkan cetak sebagai PDF / unduh SK ini untuk diberi Tanda Tangan Elektronik di sistem TTE Kemenag");

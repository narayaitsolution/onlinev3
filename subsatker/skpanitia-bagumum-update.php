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
                            SET namakegiatan=?,ormas=?,tema=?,pembiayaan=?,nosurat=?
                            WHERE token=?");
$stmt->bind_param("ssssss", $namakegiatan, $ormas, $tema, $pembiayaan, $nosurat, $token);
$stmt->execute();

header("location:skpanitia-bagumum-tampil.php?token=$token&hasil=ok&pesan=Update data berhasil");

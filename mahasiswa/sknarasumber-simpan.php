<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tahun = date('Y');
$tanggal = date('Y-m-d H:i:s');

$prodi = $_SESSION['prodi'];
$nim = $_SESSION['nip'];
$namakegiatan = $_POST['namakegiatan'];
$ormas = $_POST['ormas'];
$tema = $_POST['tema'];

//cari nip kabag-akademik
$qbagumum = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan='bagumum'");
$dbagumum = mysqli_fetch_array($qbagumum);
$nipumum = $dbagumum['nip'];

//cari nip wd-3
$qwd3 = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan='wadek3'");
$dwd3 = mysqli_fetch_array($qwd3);
$nipwd3 = $dwd3['nip'];

//simpandata
$jenissk = 'narasumber';
$token = md5(uniqid());
$stmt = $dbsurat->prepare("INSERT INTO sk (tanggal,prodi,nim,jenissk,namakegiatan,ormas,tema,verifikator1,verifikator2,token)
                            VALUES(?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssss", $tanggal, $prodi, $nim, $jenissk, $namakegiatan, $ormas, $tema, $nipwd3, $nipumum, $token);
$stmt->execute();

header("location:sknarasumber-data-isi.php?token=$token");

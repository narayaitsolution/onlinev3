<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');
date_default_timezone_set("Asia/Jakarta");
$tglsekarang = date('Y-m-d H:i:s');
$tahun = date('Y');
$bulan = date('m');

$nama = $_POST['nama'];
$nip = $_POST['nip'];
$prodi = $_POST['prodi'];
$pangkat = $_POST['pangkat'];
$golongan = $_POST['golongan'];
$jafung = $_POST['jafung'];
$nohp = $_POST['nohp'];
$email = $_POST['email'];
$token = $_POST['token'];

$stmt = $dbsurat->prepare("UPDATE pengguna 
                            SET nama=?, nip=?,prodi=?,pangkat=?,golongan=?,jafung=?,nohp=?,email=?
                            WHERE token=?");
$stmt->bind_param("sssssssss", $nama, $nip, $prodi, $pangkat, $golongan, $jafung, $nohp, $email, $token);
$stmt->execute();


header("location:pengguna-tampil.php");

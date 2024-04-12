<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tahun = date('Y');
$tanggal = date('Y-m-d H:i:s');

$nim = $_SESSION['nip'];
$namanarsum = $_POST['namanarsum'];
$materi = $_POST['materi'];
$jadwal = date('Y-m-d H:i:s', strtotime($_POST['jadwal']));
$token = $_POST['token'];

//simpandata
$stmt = $dbsurat->prepare("INSERT INTO sknarsum (token,nama,materi,jadwal)
                            VALUES(?,?,?,?)");
$stmt->bind_param("ssss", $token, $namanarsum, $materi, $jadwal);
$stmt->execute();

header("location:narasumber-data-isi.php?token=$token");

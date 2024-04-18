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
$jadwal = date('Y-m-d', strtotime($_POST['jadwal']));
$jammulai = date('H:i', strtotime($_POST['jammulai']));
$jamselesai = date('H:i', strtotime($_POST['jamselesai']));
$token = $_POST['token'];

//simpandata
if (!empty($namanarsum) && !empty($materi) && !empty($jadwal)) {
    $stmt = $dbsurat->prepare("INSERT INTO sknarsum (token,nama,materi,jadwal,jammulai,jamselesai)
                            VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $token, $namanarsum, $materi, $jadwal, $jammulai, $jamselesai);
    $stmt->execute();
}
header("location:sknarasumber-data-isi.php?token=$token");

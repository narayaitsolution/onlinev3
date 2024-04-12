<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$namanarsum = $_POST['namanarsum'];
$token = $_POST['token'];

//hapus
$stmt = $dbsurat->prepare("DELETE FROM sknarsum WHERE nama=? AND token=?");
$stmt->bind_param("ss", $namanarsum, $token);
$stmt->execute();

header("location:narasumber-data-isi.php?token=$token");

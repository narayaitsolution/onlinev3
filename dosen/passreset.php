<?php
session_start();
require('../system/dbconn.php');

$nodata = $_POST['nodata'];
$nip = $_POST['nip'];
$newpass = md5($nip);

$stmt = $dbsurat->prepare("UPDATE pengguna SET pass=? WHERE nip=?");
$stmt->bind_param("ss", $newpass, $nip);
$stmt->execute();

header('location:loginas.php?pesan=success');

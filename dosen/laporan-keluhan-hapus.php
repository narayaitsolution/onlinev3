<?php
session_start();
require('../system/dbconn.php');
$nip = $_SESSION['nip'];

$token = mysqli_real_escape_string($dbsurat, "$_POST[token]");

$qcaridata = mysqli_query($dbsurat, "SELECT * FROM laporkan WHERE kode='$token'");
$dcaridata = mysqli_fetch_array($qcaridata);
$bukti = $dcaridata['bukti'];
unlink($bukti);

$qhapus = mysqli_query($dbsurat, "DELETE FROM laporkan WHERE kode='$token'");

header("location:index.php");

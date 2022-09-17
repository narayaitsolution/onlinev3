<?php
session_start();
require('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, "$_GET[token]");
$nip = $_SESSION['nip'];

$qst = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE token='$token'");
$dst = mysqli_fetch_array($qst);
$lampiran = $dst['lampiran'];
unlink($lampiran);

$qhapus = mysqli_query($dbsurat, "DELETE FROM surattugas WHERE token = '$token' AND nip='$nip'");

header("location:index.php");

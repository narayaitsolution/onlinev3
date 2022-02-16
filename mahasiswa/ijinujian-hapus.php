<?php
session_start();
require('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$qujian = mysqli_query($dbsurat, "SELECT * FROM ijinujian WHERE token='$token'");
$dujian = mysqli_fetch_array($qujian);
$lampiran1 = $dujian['lampiran1'];
$lampiran2 = $dujian['lampiran2'];
unlink($lampiran1);
unlink($lampiran2);

$sql2 = mysqli_query($dbsurat, "DELETE FROM ijinujian WHERE token='$token'");

header("location:index.php");

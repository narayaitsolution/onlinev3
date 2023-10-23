<?php
session_start();

require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);

$query3 = mysqli_query($dbsurat, "DELETE FROM delegasi WHERE token = '$token'");
$query4 = mysqli_query($dbsurat, "DELETE FROM delegasianggota WHERE token='$token'");

header("location:index.php");

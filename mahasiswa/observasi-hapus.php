<?php
session_start();
require('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);

$query2 = mysqli_query($dbsurat, "DELETE FROM observasianggota WHERE token = '$token'");
$query3 = mysqli_query($dbsurat, "DELETE FROM observasi WHERE token = '$token'");

header("location:index.php");

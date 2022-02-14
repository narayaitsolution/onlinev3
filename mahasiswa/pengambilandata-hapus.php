<?php
session_start();
require_once('../system/dbconn.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$nim = $_SESSION['nip'];

$sql2 = mysqli_query($dbsurat, "DELETE FROM pengambilandata WHERE token='$token'");

header("location:index.php");

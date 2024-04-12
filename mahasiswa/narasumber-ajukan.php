<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");

$nim = $_SESSION['nip'];
$token = $_POST['token'];

//updatestatussurat
$qupdatestatus = mysqli_query($dbsurat, "UPDATE sk SET statussurat=0 WHERE token='$token' AND nim='$nim'");
header("location:index.php");

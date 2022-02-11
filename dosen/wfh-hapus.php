<?php
require_once('../system/dbconn.php');
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);

$sql = "DELETE FROM wfh WHERE token='$token'";
if (mysqli_query($dbsurat, $sql)) {
    header("location:index.php");
} else {
    header("location:index.php?pesan=error");
}

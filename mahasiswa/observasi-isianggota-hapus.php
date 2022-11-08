<?php
session_start();
require_once('../system/dbconn.php');

//$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
//$nimanggota = mysqli_real_escape_string($dbsurat, $_GET['nimanggota']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
//$id = mysqli_real_escape_string($dbsurat, $_POST['id']);
$qhapus = mysqli_query($dbsurat, "DELETE FROM observasianggota WHERE token='$token'");
if ($qhapus) {
    $status = 'ok';
} else {
    $status = 'failed';
}

header("location:observasi-isianggota.php?token=$token&keterangan=$status");

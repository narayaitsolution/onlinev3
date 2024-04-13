<?php
session_start();
require('../system/dbconn.php');

$nodata = $_POST['nodata'];
$token = $_POST['token'];

//hapus
$qhapus = mysqli_query($dbsurat, "DELETE FROM sknarsum WHERE no='$nodata' AND token='$token'");

header("location:sknarasumber-data-isi.php?token=$token");

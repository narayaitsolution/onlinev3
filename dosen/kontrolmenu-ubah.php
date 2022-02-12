<?php
require_once('../system/dbconn.php');

$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$status = $_POST['status'];

//update data kapasitas lab 	
$query1 = mysqli_query($dbsurat, "UPDATE jenissurat SET status = '$status' WHERE no = '$nodata'");
header("location:kontrolmenu-tampil.php");

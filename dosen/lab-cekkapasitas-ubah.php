<?php
require_once('../system/dbconn.php');

$nodata = mysqli_real_escape_string($dbsurat, $_POST['nodata']);
$kapasitas = $_POST['kapasitas'];
$kalab = $_POST['dosen'];

//cari nip kalab
$stmt = $dbsurat->prepare("SELECT * FROM pengguna WHERE nama=?");
$stmt->bind_param("s", $kalab);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkalab = $dhasil['nip'];


//update data kapasitas lab 	
$query1 = mysqli_query($dbsurat, "UPDATE laboratorium SET kapasitas = '$kapasitas', kalab='$nipkalab' WHERE no = '$nodata'");
header("location:lab-cekkapasitas.php");

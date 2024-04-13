<?php
session_start();
require('../system/dbconn.php');

$token = $_POST['token'];
$qhapus = mysqli_query($dbsurat, "DELETE FROM skpeserta WHERE token='$token'");
//upload file
$filepeserta = $_FILES['filepeserta']['tmp_name'];
$filepesertasize = $_FILES['filepeserta']['size'];
if ($filepesertasize > 0) {
    $fileupload = fopen($filepeserta, 'r');
    while (($getData = fgetcsv($fileupload, 10000, ';')) !== FALSE) {
        $nimpeserta = $getData[0];
        $namapeserta = $getData[1];
        $stmt = $dbsurat->prepare("INSERT INTO skpeserta (token,nim,nama)
                                    VALUES(?,?,?)");
        $stmt->bind_param("sss", $token, $nimpeserta, $namapeserta);
        $stmt->execute();
    }
}

fclose($fileupload);

header("location:skpeserta-data-isi.php?token=$token");

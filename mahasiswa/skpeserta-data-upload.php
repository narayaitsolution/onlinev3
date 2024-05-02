<?php
session_start();
require('../system/dbconn.php');

$token = $_POST['token'];
echo $token;
$qhapus = mysqli_query($dbsurat, "DELETE FROM skpeserta WHERE token='$token'");
//upload file
$filepeserta = $_FILES['filepeserta']['tmp_name'];
$filepesertasize = $_FILES['filepeserta']['size'];
$filepesertatype = $_FILES['filepeserta']['type'];
if ($filepesertasize > 0 && $filepesertatype == 'text/csv') {
    $fileupload = fopen($filepeserta, 'r');
    while (($getData = fgetcsv($fileupload, 10000, ';')) !== FALSE) {
        $nimpeserta = $getData[0];
        $namapeserta = $getData[1];
        $stmt = $dbsurat->prepare("INSERT INTO skpeserta (token,nim,nama)
                                    VALUES(?,?,?)");
        $stmt->bind_param("sss", $token, $nimpeserta, $namapeserta);
        $stmt->execute();
    }
    fclose($fileupload);
    header("location:skpeserta-data-isi.php?token=$token&hasil=ok&pesan=File peserta berhasil di upload");
} else {
    header("location:skpeserta-data-isi.php?token=$token&hasil=notok&pesan=File peserta GAGAL di upload");
}

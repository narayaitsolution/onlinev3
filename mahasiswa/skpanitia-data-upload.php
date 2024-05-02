<?php
session_start();
require('../system/dbconn.php');

$token = $_POST['token'];
$qhapus = mysqli_query($dbsurat, "DELETE FROM skpanitia WHERE token='$token'");
//upload file
$filepanitia = $_FILES['filepanitia']['tmp_name'];
$filepanitiasize = $_FILES['filepanitia']['size'];
$filepanitiatype = $_FILES['filepanitia']['type'];
if ($filepanitiatype == 'text/csv' && $filepanitiasize > 0) {
    $fileupload = fopen($filepanitia, 'r');
    while (($getData = fgetcsv($fileupload, 10000, ';')) !== FALSE) {
        $nimpanitia = $getData[0];
        $namapanitia = $getData[1];
        $siepanitia = $getData[2];
        $stmt = $dbsurat->prepare("INSERT INTO skpanitia (token,nim,nama,siepanitia)
                                    VALUES(?,?,?,?)");
        $stmt->bind_param("ssss", $token, $nimpanitia, $namapanitia, $siepanitia);
        $stmt->execute();
    }
    fclose($fileupload);
    header("location:skpanitia-data-isi.php?token=$token&hasil=ok&pesan=Upload File berhasil");
} else {
    header("location:skpanitia-data-isi.php?token=$token&hasil=notok&pesan=Upload File GAGAL");
}

<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');

date_default_timezone_set("Asia/Jakarta");
$tglsurat = date('Y-m-d H:i:s');

$prodi = $_SESSION['prodi'];
$cpl = $_POST['cpl'];
$indonesia = $_POST['indonesia'];
$english = $_POST['english'];
$sifat = $_POST['sifat'];

$stmt = $dbsurat->prepare("INSERT INTO skpi_cpl (jurusan,cpl,indonesia,english,def)
                            VALUES (?,?,?,?,?)");
$stmt->bind_param("ssssi", $prodi, $cpl, $indonesia, $english, $sifat);
if ($stmt->execute()) {
    header("location:skpi-isi.php?pesan=berhasil");
} else {
    header("location:skpi-isi.php?pesan=gagal");
}

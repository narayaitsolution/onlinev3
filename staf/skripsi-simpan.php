<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$nama = $_SESSION['nama'];
$nip = $_SESSION['nip'];
$prodi = $_SESSION['prodi'];
$tahapan = $_POST['tahapan'];
$nim = $_POST['nim'];
$pembimbing1 = $_POST['pembimbing1'];
$pembimbing2 = $_POST['pembimbing2'];
$penguji1 = $_POST['penguji1'];
$penguji2 = $_POST['penguji2'];
$tglujian = $_POST['tglujian'];
$status = '1';
echo $tahapan;
if ($tahapan == 'sempro') {
    $stmt = $dbsurat->prepare("INSERT INTO sempro (tanggal, prodi, nim, pembimbing1, pembimbing2, penguji1, penguji2, tglujian, operator,status) 
                                VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssi", $tanggal, $prodi, $nim, $pembimbing1, $pembimbing2, $penguji1, $penguji2, $tglujian, $nip, $status);
    $stmt->execute();
} elseif ($tahapan == 'kompre') {
    $stmt = $dbsurat->prepare("INSERT INTO kompre (tanggal, prodi, nim, pembimbing1, pembimbing2, penguji1, penguji2, tglujian, operator,status) 
                                VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssi", $tanggal, $prodi, $nim, $pembimbing1, $pembimbing2, $penguji1, $penguji2, $tglujian, $nip, $status);
    $stmt->execute();
    //update sempro
    $stmt = $dbsurat->prepare("UPDATE sempro SET status=2 WHERE nim=?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
} elseif ($tahapan == 'semhas') {
    $stmt = $dbsurat->prepare("INSERT INTO semhas (tanggal, prodi, nim, pembimbing1, pembimbing2, penguji1, penguji2, tglujian, operator,status) 
                                VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssi", $tanggal, $prodi, $nim, $pembimbing1, $pembimbing2, $penguji1, $penguji2, $tglujian, $nip, $status);
    $stmt->execute();
    //update kompre
    $stmt = $dbsurat->prepare("UPDATE kompre SET status=2 WHERE nim=?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
} elseif ($tahapan == 'skripsi') {
    $stmt = $dbsurat->prepare("INSERT INTO skripsi (tanggal, prodi, nim, pembimbing1, pembimbing2, penguji1, penguji2, tglujian, operator,status) 
                                VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssi", $tanggal, $prodi, $nim, $pembimbing1, $pembimbing2, $penguji1, $penguji2, $tglujian, $nip, $status);
    $stmt->execute();
    //update semhas
    $stmt = $dbsurat->prepare("UPDATE semhas SET status=2 WHERE nim=?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
};

header("location:skripsi-isi.php");

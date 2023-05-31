<?php
require('../system/dbconn.php');
require('../system/myfunc.php');

//manajemen skripsi fisika
$dbfis = mysqli_connect("10.10.7.109", "manajemenskripsi", "Cg6_vg25", "fisika_manajemenskripsi");
if (mysqli_connect_errno()) {
    //echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    //echo "Connected to db manajemenskripsi fisika";
}

//skripsi perpustakaan dan ilmu informasi
$dbpii = mysqli_connect("10.10.7.109", "skripsi", "gtZx169_2", "skripsi");
if (mysqli_connect_errno()) {
    //echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    //echo "Connected to db skripsi pii";
}

//sempro PII
$qdelsempro = mysqli_query($dbsurat, "DELETE FROM sempro WHERE prodi='Perpustakaan dan Ilmu Informasi'");
$qsempropii = mysqli_query($dbpii, "SELECT * FROM sempro WHERE status > 0");
while ($dsempropii = mysqli_fetch_array($qsempropii)) {
    $tanggal = $dsempropii['tanggal'];
    $prodi = 'Perpustakaan dan Ilmu Informasi';
    $nim = $dsempropii['nim'];
    $pembimbing1 = $dsempropii['pembimbing1'];
    $penguji1 = $dsempropii['penguji1'];
    $penguji2 = $dsempropii['penguji2'];
    $tglujian = $dsempropii['tglujian'];
    $status = $dsempropii['status'];

    //masukin data sempro dari PII
    $stmt = $dbsurat->prepare("INSERT INTO sempro (tanggal,prodi,nim,pembimbing1,penguji1,penguji2,tglujian,status)
                            VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss", $tanggal, $prodi, $nim, $pembimbing1, $penguji1, $penguji2, $tglujian, $status);
    $stmt->execute();
    echo 'Insert data ' . $nim . '<br>';
}
echo 'Insert data SEMPRO done!! <br>';

//kompre PII
$qdelkompre = mysqli_query($dbsurat, "DELETE FROM kompre WHERE prodi='Perpustakaan dan Ilmu Informasi'");
$qkomprepii = mysqli_query($dbpii, "SELECT * FROM kompre WHERE status > 0");
while ($dkomprepii = mysqli_fetch_array($qkomprepii)) {
    $tanggal = $dkomprepii['tanggal'];
    $prodi = 'Perpustakaan dan Ilmu Informasi';
    $nim = $dkomprepii['nim'];
    $pembimbing1 = $dkomprepii['pembimbing1'];
    $penguji1 = $dkomprepii['pengujiteori'];
    $penguji2 = $dkomprepii['pengujiintegrasi'];
    $tglujian = $dkomprepii['tglujianintegrasi'];
    $status = $dkomprepii['status'];
    $operator = 'auto';

    //masukin data kompre dari PII
    $stmt = $dbsurat->prepare("INSERT INTO kompre (tanggal,prodi,nim,pembimbing1,penguji1,penguji2,tglujian,status,operator)
                            VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $tanggal, $prodi, $nim, $pembimbing1, $penguji1, $penguji2, $tglujian, $status, $operator);
    $stmt->execute();
    echo 'Insert data ' . $nim . '<br>';
}
echo 'Insert data KOMPRE done!! <br>';

//semhas PII
$qdelkompre = mysqli_query($dbsurat, "DELETE FROM semhas WHERE prodi='Perpustakaan dan Ilmu Informasi'");
$qkomprepii = mysqli_query($dbpii, "SELECT * FROM semhas WHERE status > 0");
while ($dkomprepii = mysqli_fetch_array($qkomprepii)) {
    $tanggal = $dkomprepii['tanggal'];
    $prodi = 'Perpustakaan dan Ilmu Informasi';
    $nim = $dkomprepii['nim'];
    $pembimbing1 = $dkomprepii['pembimbing1'];
    $penguji1 = $dkomprepii['penguji1'];
    $penguji2 = $dkomprepii['penguji2'];
    $tglujian = $dkomprepii['tglujian'];
    $status = $dkomprepii['status'];
    $operator = 'auto';

    //masukin data kompre dari PII
    $stmt = $dbsurat->prepare("INSERT INTO semhas (tanggal,prodi,nim,pembimbing1,penguji1,penguji2,tglujian,status,operator)
                            VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $tanggal, $prodi, $nim, $pembimbing1, $penguji1, $penguji2, $tglujian, $status, $operator);
    $stmt->execute();
    echo 'Insert data ' . $nim . '<br>';
}
echo 'Insert data SEMHAS done!! <br>';

//skripsi PII
$qdelkompre = mysqli_query($dbsurat, "DELETE FROM skripsi WHERE prodi='Perpustakaan dan Ilmu Informasi'");
$qkomprepii = mysqli_query($dbpii, "SELECT * FROM skripsi WHERE status > 0");
while ($dkomprepii = mysqli_fetch_array($qkomprepii)) {
    $tanggal = $dkomprepii['tanggal'];
    $prodi = 'Perpustakaan dan Ilmu Informasi';
    $nim = $dkomprepii['nim'];
    $pembimbing1 = $dkomprepii['pembimbing1'];
    $penguji1 = $dkomprepii['penguji1'];
    $penguji2 = $dkomprepii['penguji2'];
    $tglujian = $dkomprepii['tglujian'];
    $status = $dkomprepii['status'];
    $operator = 'auto';

    //masukin data kompre dari PII
    $stmt = $dbsurat->prepare("INSERT INTO skripsi (tanggal,prodi,nim,pembimbing1,penguji1,penguji2,tglujian,status,operator)
                            VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $tanggal, $prodi, $nim, $pembimbing1, $penguji1, $penguji2, $tglujian, $status, $operator);
    $stmt->execute();
    echo 'Insert data ' . $nim . '<br>';
}
echo 'Insert data SKRIPSI done!! <br>';

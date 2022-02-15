<?php
require('system/dbconn.php');

$qpengguna = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE token is null");
while ($dpengguna = mysqli_fetch_array($qpengguna)) {
    $no = $dpengguna['no'];
    $nim = $dpengguna['nim'];
    $nama = $dpengguna['nama'];
    $token = md5(uniqid());
    echo $nama . ' ' . $token . ' ';
    $qupdate = mysqli_query($dbsurat, "UPDATE ijinpenelitian SET token='$token' WHERE no='$no'");
    echo 'done <br/>';
}
echo 'DONE!!';

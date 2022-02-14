<?php
require('system/dbconn.php');

$qpengguna = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE token ='-1'");
while ($dpengguna = mysqli_fetch_array($qpengguna)) {
    $nim = $dpengguna['nim'];
    $nama = $dpengguna['nama'];
    $token = md5(uniqid());
    echo $nama . ' ' . $token . ' ';
    $qupdate = mysqli_query($dbsurat, "UPDATE ijinlab SET token='$token' WHERE nim='$nim'");
    echo 'done <br/>';
}
echo 'DONE!!';

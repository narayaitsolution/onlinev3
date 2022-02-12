<?php
require('system/dbconn.php');

$qpengguna = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE token is null");
while ($dpengguna = mysqli_fetch_array($qpengguna)) {
    $nip = $dpengguna['nip'];
    $nama = $dpengguna['nama'];
    $token = md5(uniqid());
    echo $nama . ' ' . $token . ' ';
    $qupdate = mysqli_query($dbsurat, "UPDATE pengguna SET token='$token' WHERE nip='$nip'");
    echo 'done <br/>';
}

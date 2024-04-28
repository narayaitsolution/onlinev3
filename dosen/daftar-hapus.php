<?php
require('../system/dbconn.php');
session_start();
$nip = $_SESSION['nip'];
if ($_SESSION['nip'] != "198312132019031004") {
    header("../deauth.php");
} else {
    $token = $_GET['token'];
    $aktif = 1;
    $stmt = $dbsurat->prepare('DELETE FROM pengguna WHERE token=?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
}
header("location:index.php?hasil=ok&pesan=Pendaftar berhasil dihapus");

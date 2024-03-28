<?php
header("Content-Type:application/json");
require('../system/dbconn.php');

$userid = $_GET['userid'];
$pass = $_GET['pass'];
$aktif = 1;

$stmt = $dbsurat->prepare("SELECT * FROM pengguna WHERE user=? AND pass=? AND aktif=?");
$stmt->bind_param("sss", $userid, $pass, $aktif);
$stmt->execute();
$result = $stmt->get_result();
$jhasil = $result->num_rows;
if ($jhasil > 0) {
    $dhasil = $result->fetch_assoc();
    $nama = $dhasil['nama'];
    $nip = $dhasil['nip'];
    $nohp = $dhasil['nohp'];
    $email = $dhasil['email'];
    $prodi = $dhasil['prodi'];
    $userid = $dhasil['user'];
    $hakakses = $dhasil['hakakses'];
    echo json_encode(array('nama' => $nama, 'nip' => $nip, 'nohp' => $nohp, 'email' => $email, 'prodi' => $prodi, 'userid' => $userid, 'hakakses' => $hakakses));
}

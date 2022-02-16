<?php
session_start();
require('system/dbconn.php');

$userid = mysqli_real_escape_string($dbsurat, $_POST['userid']);
$pass = mysqli_real_escape_string($dbsurat, md5(strtolower($_POST['pass'])));
$kunci = $_POST['kunci'];
$antibot = $_POST['antibot'];
$aktif = '1';

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
    $hakakses = $dhasil['hakakses'];
    $token = $dhasil['token'];


    //cari jabatan
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE nip=?");
    $stmt->bind_param("s", $nip);
    $stmt->execute();
    $result = $stmt->get_result();
    $jhasil = $result->num_rows;
    if ($jhasil > 0) {
        $dhasil = $result->fetch_array();
        $jabatan = $dhasil['kdjabatan'];
    } else {
        $jabatan = $hakakses;
    };

    $_SESSION['user'] = $username;
    $_SESSION['nama'] = $nama;
    $_SESSION['nip'] = $nip;
    $_SESSION['prodi'] = $prodi;
    $_SESSION['hakakses'] = $hakakses;
    $_SESSION['jabatan'] = $jabatan;
    $cookie_name = "usertoken";
    $cookie_value = $token;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 3), "/");

    if ($hakakses == 'dosen') {
        header('location:index2.php');
    } elseif ($hakakses == 'tendik') {
        header('location:index2.php');
    } elseif ($hakakses == 'mahasiswa') {
        header('location:index2.php');
    }
} else {
    header('location:index.php?pesan=gagal');
}

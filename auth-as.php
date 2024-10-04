<?php
session_start();
require('system/dbconn.php');

$username = mysqli_real_escape_string($dbsurat, $_POST['username']);
$password = mysqli_real_escape_string($dbsurat, $_POST['password']);
$kunci = mysqli_real_escape_string($dbsurat, $_POST['kunci']);
$antibot = mysqli_real_escape_string($dbsurat, $_POST['antibot']);
$aktif = '1';

if ($kunci == $antibot) {
    $stmt = $dbsurat->prepare("SELECT * FROM pengguna WHERE user=? AND pass=? AND aktif=?");
    $stmt->bind_param("sss", $username, $password, $aktif);
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

        if ($hakakses == 'dosen') {
            header('location:dosen/index.php');
        } elseif ($hakakses == 'tendik') {
            header('location:staf/index.php');
        } elseif ($hakakses == 'subsatker') {
            header('location:subsatker/index.php');
        } elseif ($hakakses == 'mahasiswa') {
            header('location:mahasiswa/index.php');
        } else {
            header('location:index.php?pesan=gagal');
        }
    } else {
        header('location:index.php?pesan=gagal');
    }
} else {
    header('location:index.php?pesan=antibot');
}

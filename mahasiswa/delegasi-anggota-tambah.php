<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/myfunc.php');
require_once('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$nimketua = $_POST['nimketua'];
$nimanggota = $_POST['nimanggota'];
$token = $_POST['token'];

$qpengguna = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip = '$nimanggota'");
$jpengguna = mysqli_num_rows($qpengguna);
if ($jpengguna > 0) {
  $stmt = $dbsurat->prepare("INSERT INTO delegasianggota (token, nimketua, nimanggota) 
                VALUES (?,?,?)");
  $stmt->bind_param("sss", $token, $nimketua, $nimanggota);
  $stmt->execute();
  header("location:delegasi-anggota.php?hasil=ok&pesan=Penambahan Anggota Berhasil&token=$token");
} else {
  header("location:delegasi-anggota.php?hasil=notok&pesan=Penambahan Anggota Gagal karena NIM Salah / Belum Terdaftar&token=$token");
}

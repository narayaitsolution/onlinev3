
<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/myfunc.php');
require_once('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$no = $_POST['no'];
$token = $_POST['token'];

$stmt = $dbsurat->prepare("DELETE FROM delegasianggota WHERE no=? and token=?");
$stmt->bind_param("ss", $no, $token);
$stmt->execute();

header("location:delegasi-anggota.php?hasil=ok&pesan=Hapus anggota berhasil&token=$token");

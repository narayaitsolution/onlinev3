<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/myfunc.php');
require_once('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$nimketua = $_POST['nimketua'];
$nimanggota = $_POST['nimanggota'];
$nodata = $_POST['nodata'];
$token = $_POST['token'];

$qpengguna = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip = '$nimanggota'");
$jpengguna = mysqli_num_rows($qpengguna);
if ($jpengguna > 0) {
    $stmt = $dbsurat->prepare("INSERT INTO penghargaananggota (nodata, nimketua, nimanggota) 
                VALUES (?,?,?)");
    $stmt->bind_param("sss", $nodata, $nimketua, $nimanggota);
    $stmt->execute();
    header("location:penghargaan-anggota.php?pesan=succes&&token=$token");
} else {
    header("location:penghargaan-anggota.php?pesan=gagal&&token=$token");
}

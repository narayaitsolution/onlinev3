<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');

date_default_timezone_set("Asia/Jakarta");

$tanggal = date('Y-m-d H:i:s');
$nama = $_SESSION['nama'];
$nip = $_SESSION['nip'];
$jabatan = $_SESSION['jabatan'];
$prodi = $_SESSION['prodi'];
$tglkerja = $_POST['tglkerja'];
$jeniskerja = $_POST['jeniskerja'];
$pekerjaan = $_POST['pekerjaan'];
$lamakerja = $_POST['lamakerja'];
$verifikasi = 1;
$token = md5(uniqid());

//cari atasan
$kdjabatan = 'kaprodi';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
$stmt->bind_param("ss", $prodi, $kdjabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkaprodi = $dhasil['nip'];

$kodeacak = random_str(12);
$target_dir = "../lampiran/";
$bukti = $_FILES['bukti']['tmp_name'];
$bukti_upload = $target_dir . $kodeacak . '.jpg';
move_uploaded_file($bukti, $bukti_upload);
$info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $bukti_upload);
$filesize = filesize($bukti_upload);
echo $info;
echo $filesize;
if (($info == 'image/jpg' || $info == 'image/jpeg') && $filesize < 1048576) {
    $stmt = $dbsurat->prepare("INSERT INTO kinerja (tanggal,prodi,nip,tglkerja,jeniskerja,pekerjaan,lamakerja,bukti,verifikator,verifikasi, token)
                            VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssissis", $tanggal, $prodi, $nip, $tglkerja, $jeniskerja, $pekerjaan, $lamakerja, $bukti_upload, $nipkaprodi, $verifikasi, $token);
    $stmt->execute();
    header("location:kinerja-tampil.php?pesan=Data berhasil tersimpan");
} else {
    header("location:kinerja-tampil.php?pesan=Upload bukti <b>GAGAL!!</b>");
}

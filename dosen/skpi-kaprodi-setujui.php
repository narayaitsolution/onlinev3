<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/phpmailer/sendmail.php');

$nip = $_SESSION['nip'];
$nimmhs = mysqli_real_escape_string($dbsurat, $_POST['nim']);
$namamhs = mysqli_real_escape_string($dbsurat, $_POST['nama']);
$prodi = mysqli_real_escape_string($dbsurat, $_POST['prodi']);
$kemampuankerja = isset($_POST['kemampuankerja']) ? $_POST['kemampuankerja'] : [];
$penguasaanpengetahuan = isset($_POST['penguasaanpengetahuan']) ? $_POST['penguasaanpengetahuan'] : [];
$SikapKhusus = isset($_POST['SikapKhusus']) ? $_POST['SikapKhusus'] : [];

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//cari nip kajur
$kdjabatan = 'kaprodi';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
$stmt->bind_param("ss", $prodi, $kdjabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkaprodi = $dhasil['nip'];

//cari nip wd-1
$jabatan = 'wadek1';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $jabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipwd1 = $dhasil['nip'];

//hapus dulu data sebelumnya
$stmt = $dbsurat->prepare("DELETE FROM skpi WHERE nim = ?");
$stmt->bind_param("s", $nimmhs);
$stmt->execute();

//add data baru
foreach ($kemampuankerja as $kerja) {
    insertSkpiData($dbsurat, $kerja, $nimmhs, $namamhs, $prodi, $nip, $nipkaprodi, $nipwd1, $tgl);
}

foreach ($penguasaanpengetahuan as $pengetahuan) {
    insertSkpiData($dbsurat, $pengetahuan, $nimmhs, $namamhs, $prodi, $nip, $nipkaprodi, $nipwd1, $tgl);
}

foreach ($SikapKhusus as $sikap) {
    insertSkpiData($dbsurat, $sikap, $nimmhs, $namamhs, $prodi, $nip, $nipkaprodi, $nipwd1, $tgl);
}

// Helper function to insert SKPI data
function insertSkpiData($dbsurat, $data, $nimmhs, $namamhs, $prodi, $nip, $nipkaprodi, $nipwd1, $tgl) {
    $stmt = $dbsurat->prepare("SELECT * FROM skpi_cpl WHERE indonesia = ?");
    $stmt->bind_param("s", $data);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        $cpl = $row['cpl'];
        $indonesia = $row['indonesia'];
        $english = $row['english'];
        $status = 1;
        
        $stmt = $dbsurat->prepare("INSERT INTO skpi (nim, nama, jurusan, cpl, indonesia, english, verifikasi1, verifikator1, tglverifikasi1, verifikasi2, verifikator2, tglverifikasi2, verifikasi3, verifikator3, tglverifikasi3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssssss", $nimmhs, $namamhs, $prodi, $cpl, $indonesia, $english, $status, $nip, $tgl, $status, $nipkaprodi, $tgl, $status, $nipwd1, $tgl);
        $stmt->execute();
    }
}

//setujui sertifikat
$qsimpan5 = mysqli_query($dbsurat, "UPDATE skpi_prestasipenghargaan 
								    SET verifikasi2=1,
										tglverifikasi2='$tgl',
								        verifikasi3=1,
										tglverifikasi3='$tgl'
									WHERE nim='$nimmhs'");


header("location:index.php?hasil=ok&pesan=Berhasil menyetujui pengajuan SKPI");

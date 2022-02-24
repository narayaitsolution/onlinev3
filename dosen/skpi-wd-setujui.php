<?php
session_start();
require('../system/dbconn.php');

$nip = $_SESSION['nip'];
$nimmhs = mysqli_real_escape_string($dbsurat, $_POST['nimmhs']);
$namamhs = mysqli_real_escape_string($dbsurat, $_POST['namamhs']);
$prodi = mysqli_real_escape_string($dbsurat, $_POST['prodi']);
$kemampuankerja = $_POST['kemampuankerja'];
$penguasaanpengetahuan = $_POST['penguasaanpengetahuan'];
$SikapKhusus = $_POST['SikapKhusus'];

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

//hapus data existing
$qhapus = mysqli_query($dbsurat, "DELETE FROM skpi WHERE nim='$nimmhs'");


foreach ($kemampuankerja as $kerja) {
    $qcpl = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE no='$kerja' ");
    $data = mysqli_fetch_array($qcpl);
    $cpl = $data[2];
    $indonesia = $data[3];
    $english = $data[4];
    $qsimpan = mysqli_query($dbsurat, "INSERT INTO skpi (nim,nama,jurusan,cpl,indonesia,english,verifikasi1,verifikator1,tglverifikasi1,verifikasi2,verifikator2,tglverifikasi2,verifikator3,verifikasi3,tglvreifikasi3) 
                                        VALUES ('$nimmhs','$namamhs','$prodi','$cpl','$indonesia','$english',1,'$nip','$tgl',1,'$nipkaprodi','$tgl','$nipwd1',1,'$tgl')");
}

foreach ($penguasaanpengetahuan as $pengetahuan) {
    $qcpl2 = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE no='$pengetahuan' ");
    $data2 = mysqli_fetch_array($qcpl2);
    $cpl = $data2[2];
    $indonesia = $data2[3];
    $english = $data2[4];
    $qsimpan2 = mysqli_query($dbsurat, "INSERT INTO skpi (nim,nama,jurusan,cpl,indonesia,english,verifikasi1,verifikator1,tglverifikasi1,verifikasi2,verifikator2,tglverifikasi2,verifikator3,verifikasi3,tglvreifikasi3) 
                                        VALUES ('$nimmhs','$namamhs','$prodi','$cpl','$indonesia','$english',1,'$nip','$tgl',1,'$nipkaprodi','$tgl','$nipwd1',1,'$tgl')");
}

foreach ($SikapKhusus as $khusus) {
    $qcpl3 = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE no='$khusus' ");
    $data3 = mysqli_fetch_array($qcpl3);
    $cpl = $data3[2];
    $indonesia = $data3[3];
    $english = $data3[4];
    $qsimpan3 = mysqli_query($dbsurat, "INSERT INTO skpi (nim,nama,jurusan,cpl,indonesia,english,verifikasi1,verifikator1,tglverifikasi1,verifikasi2,verifikator2,tglverifikasi2,verifikator3,verifikasi3,tglvreifikasi3) 
                                        VALUES ('$nimmhs','$namamhs','$prodi','$cpl','$indonesia','$english',1,'$nip','$tgl',1,'$nipkaprodi','$tgl','$nipwd1',1,'$tgl')");
}

//setujui sertifikat
$qsimpan5 = mysqli_query($dbsurat, "UPDATE skpi_prestasipenghargaan 
								    SET verifikasi3=1,
										tglverifikasi3='$tgl'
									WHERE nim='$nimmhs'");

header("location:index.php");

<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$nama = $_SESSION['nama'];
$nip = $_SESSION['nip'];
$prodi = $_SESSION['prodi'];
$jabatan = $_POST['jabatan'];
$pangkat = $_POST['pangkat'];
$golongan = $_POST['golongan'];
$untuk = mysqli_real_escape_string($dbsurat, $_POST['untuk']);
$tglpelaksanaan = mysqli_real_escape_string($dbsurat, $_POST['tglpelaksanaan']);
$token = md5(uniqid());
$uniqid = uniqid();

$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['lampiran']['tmp_name'];
$buktivaksin_low = imgresize($fileTmpPath);
$dest_path = $target_dir . $uniqid . '.jpg';

//kaprodi keatas verifikasi dekan
if ($jabatan == 'kaprodi' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'wadek3' or $jabatan == 'kabag-tu') {
    //cari nip kaprodi
    $jabatanwd = 'dekan';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatanwd);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipkaprodi = $dhasil['nip'];
    $namakaprodi = $dhasil['nama'];
    $nipkaprodi = $dhasil['nip'];

    //cari nip dekan
    $jabatanwd = 'dekan';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatanwd);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipdekan = $dhasil['nip'];
} else {
    //cari nip kaprodi
    $kdjabatan = 'kaprodi';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
    $stmt->bind_param("ss", $prodi, $kdjabatan);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipkaprodi = $dhasil['nip'];
    $namakaprodi = $dhasil['nama'];

    //cari nip dekan
    $jabatanwd = 'dekan';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatanwd);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipdekan = $dhasil['nip'];
}

if ($jabatan == 'dosen') {
    $jabatan = 'Dosen';
} elseif ($jabatan == 'kaprodi') {
    $jabatan = 'Ketua Program Studi';
} elseif ($jabatan == 'wadek1') {
    $jabatan = 'Wakil Dekan bidang Akademik';
} elseif ($jabatan == 'wadek2') {
    $jabatan = 'Wakil Dekan bidang AUPK';
} elseif ($jabatan == 'wadek3') {
    $jabatan = 'Wakil Dekan bidang Kemahasiswaan';
} elseif ($jabatan == 'tendik') {
    $jabatan = 'Tenaga Kependidikan';
} elseif ($jabatan == 'kabag') {
    $jabatan = 'Kepala Bagian AUPK';
} elseif ($jabatan == 'kasubag') {
    $jabatan = 'Kepala Sub Bagian';
}


if (move_uploaded_file($buktivaksin_low, $dest_path)) {
    $sql = mysqli_query($dbsurat, "INSERT INTO surattugas (prodi, tglsurat, iduser, nama, nip,pangkat,golongan,jabatan, untuk, tglpelaksanaan, lampiran, validator1,validator2,token) 
                                    VALUES ('$prodi','$tanggal','$nip','$nama','$nip','$pangkat','$golongan','$jabatan','$untuk','$tglpelaksanaan','$dest_path','$nipkaprodi','$nipdekan','$token')");
    //kirim email;
    //cari email kaprodi berdasarkan NIP
    $sql2 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipkaprodi'");
    $dsql2 = mysqli_fetch_array($sql2);
    $emailkaprodi = $dsql2['email'];

    $subject = "Pengajuan Surat Tugas";
    $pesan = "Yth. " . $namakaprodi . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan Surat Tugas atas nama " . $nama . " di sistem SAINTEK e-Office.<br/>
        Silahkan klik tombol dibawah ini untuk melakukan verifikasi surat di website SAINTEK e-Office<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
    sendmail($emailkaprodi, $namakaprodi, $subject, $pesan);
    header("location:index.php");
} else {
    header("location:index.php?pesan=gagal");
}

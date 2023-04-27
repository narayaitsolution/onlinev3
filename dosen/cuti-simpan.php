<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tglsurat = date('Y-m-d H:i:s');

$nama = $_SESSION['nama'];
$nip = $_SESSION['nip'];
$pangkat = $_POST['pangkat'];
$golongan = $_POST['golongan'];
$jabatan = $_SESSION['jabatan'];
$prodi = $_SESSION['prodi'];
$jeniscuti = mysqli_real_escape_string($dbsurat, $_POST['cuti']);
$alasan = mysqli_real_escape_string($dbsurat, $_POST['alasan']);
$tgl1 = $_POST['tgl1'];
$tgl2 = $_POST['tgl2'];
$token = md5(uniqid());
$uniqid = random_str(12);
$cuti = jmlcuti($tgl1, $tgl2, $dbsurat);

//kaprodi keatas verifikasi wd2
if ($jabatan == 'kaprodi' or $jabatan == 'dekan' or $jabatan == 'wadek1' or $jabatan == 'wadek3' or $jabatan == 'kabag-tu') {
    //cari nip atasan langsung
    $jabatanatasan1 = 'wadek2';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatanatasan1);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipatasan1 = $dhasil['nip'];
    $namaatasan1 = $dhasil['nama'];
} elseif ($jabatan == 'wadek2') {
    //cari nip kaprodi
    $jabatanatasan1 = 'dekan';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatanatasan1);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipatasan1 = $dhasil['nip'];
    $namaatasan1 = $dhasil['nama'];
} else {
    //cari nip kaprodi
    $jabatanatasan1 = 'kaprodi';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
    $stmt->bind_param("ss", $prodi, $jabatanatasan1);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipatasan1 = $dhasil['nip'];
    $namaatasan1 = $dhasil['nama'];
}

//cari nip atasan2
$jabatanatasan2 = 'wadek2';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $jabatanatasan2);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipatasan2 = $dhasil['nip'];

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


$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['lampiran']['tmp_name'];
$fileName = $_FILES['lampiran']['name'];
$fileType = $_FILES['lampiran']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));
$lampiran_low = imgresize($fileTmpPath);
$allowedfileExtensions = array('jpg', 'jpeg');
if (in_array($fileExtension, $allowedfileExtensions)) {
    $dest_path = $target_dir . $uniqid . '.jpg';
    move_uploaded_file($lampiran_low, $dest_path);
    $fileSize = filesize($dest_path);
    $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dest_path);
    if (($info == 'image/jpg' || $info == 'image/jpeg') && $filesize < 1048576) {

        $stmt = $dbsurat->prepare("INSERT INTO cuti (prodi, tglsurat, nama, nip,pangkat,golongan,jabatan, tglizin1, tglizin2,jmlizin,jeniscuti,alasan,validator1,validator2,lampiran,token)
                                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssssssssss", $prodi, $tglsurat, $nama, $nip, $pangkat, $golongan, $jabatan, $tgl1, $tgl2, $cuti, $jeniscuti, $alasan, $nipatasan1, $nipatasan2, $dest_path, $token);
        $stmt->execute();

        //kirim email;
        //cari email kaprodi berdasarkan NIP
        $sql2 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipatasan1'");
        $dsql2 = mysqli_fetch_array($sql2);
        $emailatasan1 = $dsql2['email'];

        $subject = "Pengajuan Cuti";
        $pesan = "Yth. " . $namaatasan1 . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan <b>" . $jeniscuti . "</b> atas nama " . $nama . " di sistem SAINTEK e-Office.<br/>
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
        sendmail($emailatasan1, $namaatasan1, $subject, $pesan);
        header("location:index.php");
    }
} else {
    header("location:cuti-isi.php?pesan=gagal");
}

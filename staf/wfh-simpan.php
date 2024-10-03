<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/phpmailer/sendmail.php');

$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];

date_default_timezone_set("Asia/Jakarta");
$tglsurat = date('Y-m-d H:i:s');
$token = md5(microtime());

$tgl1 = mysqli_real_escape_string($dbsurat, $_POST['tgl1']);
$kegiatan1 = mysqli_real_escape_string($dbsurat, $_POST['kegiatan1']);
$tgl2 = mysqli_real_escape_string($dbsurat, $_POST['tgl2']);
$kegiatan2 = mysqli_real_escape_string($dbsurat, $_POST['kegiatan2']);
$tgl3 = mysqli_real_escape_string($dbsurat, $_POST['tgl3']);
$kegiatan3 = mysqli_real_escape_string($dbsurat, $_POST['kegiatan3']);
$tgl4 = mysqli_real_escape_string($dbsurat, $_POST['tgl4']);
$kegiatan4 = mysqli_real_escape_string($dbsurat, $_POST['kegiatan4']);
$tgl5 = mysqli_real_escape_string($dbsurat, $_POST['tgl5']);
$kegiatan5 = mysqli_real_escape_string($dbsurat, $_POST['kegiatan5']);

//kaprodi keatas verifikasi wd2
if ($jabatan == 'kaprodi' or $jabatan == 'dekan' or $jabatan == 'wadek1' or $jabatan == 'wadek3') {
    //cari nip kaprodi
    $jabatanwd = 'wadek2';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatanwd);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipkaprodi = $dhasil['nip'];
    $namakaprodi = $dhasil['nama'];
    //cari nip wd-2
    $nipwd = $dhasil['nip'];
} elseif ($jabatan == 'wadek2') {
    //cari nip kaprodi
    $jabatanwd = 'dekan';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatanwd);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipkaprodi = $dhasil['nip'];
    $namakaprodi = $dhasil['nama'];
    //cari nip wd-2
    $nipwd = $dhasil['nip'];
} else {
    //cari nip kaprodi
    if ($prodi == 'SAINTEK') {
        $kdjabatan = 'kabag-tu';
    } else {
        $kdjabatan = 'kaprodi';
    }
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
    $stmt->bind_param("ss", $prodi, $kdjabatan);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipkaprodi = $dhasil['nip'];
    $namakaprodi = $dhasil['nama'];

    //cari nip wd-2
    $jabatanwd = 'wadek2';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatanwd);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipwd = $dhasil['nip'];
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

$sql = "INSERT INTO wfh (prodi, tglsurat, iduser, nama, nip,jabatan, tglwfh1, kegiatan1, tglwfh2, kegiatan2,tglwfh3, kegiatan3, tglwfh4, kegiatan4,tglwfh5, kegiatan5,verifikatorprodi, verifikatorfakultas,token) 
			VALUES ('$prodi','$tglsurat','$nip','$nama','$nip','$jabatan','$tgl1','$kegiatan1','$tgl2','$kegiatan2','$tgl3','$kegiatan3','$tgl4','$kegiatan4','$tgl5','$kegiatan5','$nipkaprodi','$nipwd','$token')";

if (mysqli_query($dbsurat, $sql)) {
    //kirim email;
    //cari email kaprodi berdasarkan NIP
    $sql2 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipkaprodi'");
    $dsql2 = mysqli_fetch_array($sql2);
    $emailkaprodi = $dsql2['email'];

    $subject = "Pengajuan Ijin WFH";
    $pesan = "Yth. " . $namakaprodi . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat Ijin <i>Work From Home</i> atas nama " . $nama . " di sistem SAINTEK e-Office.<br/>
        Silahkan klik tombol dibawah ini untuk melakukan verifikasi surat di website SAINTEK e-Office<br/>
        <br/>
        <a href='https://eoffice.saintek.uin-malang.ac.id/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
    sendmail($emailkaprodi, $namakaprodi, $subject, $pesan);
    header("location:index.php");
} else {
    echo "ERROR!! Laporkan ke mailto:saintekonline@gmail.com";
    //echo "error " . mysqli_error($dbsurat);
}

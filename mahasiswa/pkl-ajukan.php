<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];

//cari nip koordinator pkl
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan='koorpkl'");
$stmt->bind_param("s", $prodi);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkoor = $dhasil['nip'];

//cari nip kajur
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan='kaprodi'");
$stmt->bind_param("s", $prodi);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkaprodi = $dhasil['nip'];

//cari nip wd-3
$jabatan = 'wadek3';
$level = 4;
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $jabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipwd = $dhasil['nip'];

$nodata = $_GET['nodata'];
$statussurat = 0;

$qupdate = mysqli_query($dbsurat, "UPDATE pkl SET validator1='$nipkoor', validator2='$nipkaprodi', validator3='$nipwd', statussurat='0' WHERE no='$nodata' AND nim='$nim'");

//kirim email ke koordinator pkl
//cari email koordinator dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipkoor'");
$dsql3 = mysqli_fetch_array($sql3);
$namakoor = $dsql3['nama'];
$emailkoor = $dsql3['email'];

//kirim email
$subject = "Pengajuan Ijin PKL";
$pesan = "Yth. " . $namakoor . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat Pengantar PKL atas nama " . $nama . " di sistem SAINTEK e-Office.<br/>
        Silahkan klik tombol dibawah ini untuk melakukan verifikasi surat di website SAINTEK e-Office<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK Online</b>";
sendmail($emailkoor, $namakoor, $subject, $pesan);

header("location:index.php?hasil=ok&pesan=Pengajuan izin PKL berhasil");

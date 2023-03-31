<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/phpmailer/sendmail.php');

$nama = $_SESSION['nama'];
$nim = $_SESSION['nip'];
$prodi = $_SESSION['prodi'];
$dosen = $_POST['dosen'];

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

//cari nip dosen
$stmt = $dbsurat->prepare("SELECT * FROM pengguna WHERE nama=?");
$stmt->bind_param("s", $dosen);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipdosen = $dhasil['nip'];
$namadosen = $dhasil['nama'];
$emaildosen = $dhasil['email'];

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
$nipwd = $dhasil['nip'];

$qcari = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE nim='$nim'");
$cekdata = mysqli_num_rows($qcari);
if ($cekdata > 0) {
    $stmt = $dbsurat->prepare("UPDATE skpi_prestasipenghargaan 
                                SET verifikator1=?,
                                    verifikator2=?,
									verifikator3=?
								WHERE nim=?");
    $stmt->bind_param("ssss", $nipdosen, $nipkaprodi, $nipwd, $nim);
    $stmt->execute();
} else {
    $stmt = $dbsurat->prepare("INSERT INTO skpi_prestasipenghargaan (tanggal,nim, nama, prodi,verifikator1,verifikator2,verifikator3)
                                VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $tanggal, $nim, $namadosen, $prodi, $nipdosen, $nipkaprodi, $nipwd);
    $stmt->execute();
}

//kirim email ke dosen pembimbing
$subject = "Pengajuan SKPI";
$pesan = "Yth. " . $namadosen . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat <b>Pengajuan SKPI</b> atas nama " . namadosen($dbsurat, $nim) . " di sistem SAINTEK e-Office.<br/>
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
sendmail($emaildosen, $namadosen, $subject, $pesan);

header("location:index.php");

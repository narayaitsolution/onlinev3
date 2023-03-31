<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/phpmailer/sendmail.php');

$nip = $_SESSION['nip'];
$nimmhs = mysqli_real_escape_string($dbsurat, $_POST['nim']);
$namamhs = mysqli_real_escape_string($dbsurat, $_POST['nama']);
$prodi = mysqli_real_escape_string($dbsurat, $_POST['prodi']);
/*
$kemampuankerja = $_POST['kemampuankerja'];
$penguasaanpengetahuan = $_POST['penguasaanpengetahuan'];
$SikapKhusus = $_POST['SikapKhusus'];
*/

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

//setujui sertifikat
$qsimpan5 = mysqli_query($dbsurat, "UPDATE skpi_prestasipenghargaan 
								    SET verifikasi2=1,
										tglverifikasi2='$tgl',
								        verifikasi3=1,
										tglverifikasi3='$tgl'
									WHERE nim='$nimmhs'");
$qsimpan5 = mysqli_query($dbsurat, "UPDATE skpi
								    SET verifikasi2=1,
										tglverifikasi2='$tgl',
								        verifikasi3=1,
										tglverifikasi3='$tgl'
									WHERE nim='$nimmhs'");


//kirim email ke admin
//cari email admin dari NIP
$sql2 = mysqli_query($dbsurat, "SELECT * FROM skpi_operator WHERE prodi='$prodi'");
$dsql2 = mysqli_fetch_array($sql2);
$nipadmin = $dsql2['kode'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE user='$nipadmin'");
$dsql3 = mysqli_fetch_array($sql3);
$namaadmin = $dsql3['nama'];
$emailadmin = $dsql3['email'];

//kirim email
$subject = "Pengajuan SKPI ";
$pesan = "Yth. " . $namaadmin . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat SKPI atas nama " . $namamhs . " di sistem SAINTEK e-Office.<br/>
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
sendmail($emailadmin, $namaadmin, $subject, $pesan);


header("location:index.php");

<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');
$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$judulskripsi = mysqli_real_escape_string($dbsurat, $_POST['judulskripsi']);
$dosen = mysqli_real_escape_string($dbsurat, $_POST['dosen']);
$pimpinaninstansi = mysqli_real_escape_string($dbsurat, $_POST['pimpinaninstansi']);
$instansi = mysqli_real_escape_string($dbsurat, $_POST['instansi']);
$alamat = mysqli_real_escape_string($dbsurat, $_POST['alamat']);
$namaalat = mysqli_real_escape_string($dbsurat, $_POST['namaalat']);
$jumlahalat = mysqli_real_escape_string($dbsurat, $_POST['jumlahalat']);
$tglmulai = mysqli_real_escape_string($dbsurat, $_POST['tglmulai']);
$tglselesai = mysqli_real_escape_string($dbsurat, $_POST['tglselesai']);
$token = md5(uniqid());

//cari nip dosen
$stmt = $dbsurat->prepare("SELECT * FROM pengguna WHERE nama=?");
$stmt->bind_param("s", $dosen);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipdosen = $dhasil['nip'];

//cari nip kajur
$kdjabatan = 'kaprodi';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan='$kdjabatan'");
$stmt->bind_param("s", $prodi);
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

//masukin data
$stmt = $dbsurat->prepare("INSERT INTO peminjamanalat (tanggal, nim, nama, prodi, judulskripsi, dosen, pimpinaninstansi, instansi, alamat, namaalat, jumlahalat,tglmulai,tglselesai,validator1,validator2,validator3,token) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssssssssssss", $tanggal, $nim, $nama, $prodi, $judulskripsi, $dosen, $pimpinaninstansi, $instansi, $alamat, $namaalat, $jumlahalat, $tglmulai, $tglselesai, $nipdosen, $nipkaprodi, $nipwd1, $token);
$stmt->execute();

//kirim email ke dosen pembimbing
//cari email dosen dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipdosen'");
$dsql3 = mysqli_fetch_array($sql3);
$namadosen = $dsql3['nama'];
$emaildosen = $dsql3['email'];

//kirim email
$surat = 'Ijin Peminjaman Alat';
$subject = "Pengajuan Surat " . $surat . "";
$pesan = "Yth. " . $namadosen . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat " . $surat . " atas nama " . $nama . " di sistem SAINTEK e-Office.<br/>
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
sendmail($emaildosen, $namadosen, $subject, $pesan);

header("location:index.php");

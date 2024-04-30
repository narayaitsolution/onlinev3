<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');

$nip = $_SESSION['nip'];
$token = $_POST['token'];

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$bulan = date('m');
$tahun = date('Y');

//cari urutan surat di tahun ini untuk no surat
$qurutan = mysqli_query($dbsurat, "SELECT * FROM beasiswa WHERE year(tanggal)=$tahun");
$urutan = mysqli_num_rows($qurutan) + 1;

$nosurat = "B-" . $urutan . ".O/FST.3/KM.01.2/" . $bulan . "/" . $tahun . "";

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE beasiswa
					SET tglvalidasi2 = '$tgl', 
					validasi2 = '1', statussurat = '1', keterangan='$nosurat'
					WHERE token = '$token' AND validator2='$nip'");

//cari NIM mahasiswa
$sql1 = mysqli_query($dbsurat, "SELECT * FROM beasiswa WHERE token='$token'");
$dsql1 = mysqli_fetch_array($sql1);
$nim = $dsql1['nim'];

//cari email pembuat surat dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
$dsql3 = mysqli_fetch_array($sql3);
$namamhs = $dsql3['nama'];
$emailmhs = $dsql3['email'];

//kirim email
$surat = "Pengajuan Surat Rekomendasi Beasiswa";
$subject = "Pengajuan Surat Rekomendasi Beasiswa";
$pesan = "Yth. " . $namamhs . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan Surat Rekomendasi Beasiswa anda telah disetujui.<br/>
        Silahkan klik tombol dibawah ini mencetak Surat Rekomendasi Beasiswa tersebut<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/mahasiswa/beasiswa-cetak.php?token=$token' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>Cetak Surat Pengantar PKL</a><br/>
        <br/>
        atau silahkan mencetak melalui website SAINTEK e-Office di <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailmhs, $namamhs, $subject, $pesan);

header("location:index.php?hasil=ok&pesan=Persetujuan Surat Rekomendasi Beasiswa berhasil");

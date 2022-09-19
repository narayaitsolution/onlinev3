<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');

$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$bulan = date('m');
$tahun = date('Y');
//cari urutan surat di tahun ini untuk no surat
$qurutan = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE year(tglsurat)=$tahun");
$urutan = mysqli_num_rows($qurutan) + 1;

$nosurat = "B-" . $urutan . ".O/FST/KM.01.2/" . $bulan . "/" . $tahun . "";

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE surattugas
					SET tglvalidasi2 = '$tgl', 
					validasi2 = '1',
                    statussurat=1,
                    keterangan = '$nosurat'
					WHERE token = '$token' AND validator2='$nip'");

//cari NIP pembuat surat dulu
$sql1 = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE token='$token'");
$dsql1 = mysqli_fetch_array($sql1);
$nim = $dsql1['nip'];

//cari email pembuat surat dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
$dsql3 = mysqli_fetch_array($sql3);
$namamhs = $dsql3['nama'];
$emailmhs = $dsql3['email'];

//kirim email
$surat = "Surat Tugas";
$subject = "Pengajuan Surat Tugas";
$pesan = "Yth. " . $namamhs . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan <b>Surat Tugas</b> anda telah disetujui.<br/>
        Silahkan klik tombol dibawah ini mencetak Surat Pengantar tersebut<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/dosen/surattugas-cetak.php?token=$token' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>Cetak Surat Tugas</a><br/>
        <br/>
        atau silahkan mencetak melalui website SAINTEK e-Office di <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailmhs, $namamhs, $subject, $pesan);

header("location:index.php");

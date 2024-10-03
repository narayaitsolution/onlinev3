<?php
session_start();

require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$bulan = date('m');
$tahun = date('Y');
//cari urutan surat di tahun ini untuk no surat
$qurutan = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE year(tglsurat)=$tahun");
$urutan = mysqli_num_rows($qurutan);
$nosurat = "B-" . $urutan . ".O/FST/KP.08.2/" . $bulan . "/" . $tahun . "";

//update status validasi dosen
$sql = mysqli_query($dbsurat, "UPDATE cuti
					SET tglvalidasi2 = '$tgl', 
					validasi2 = '1',
                    statussurat = '1',
                    keterangan = '$nosurat'
					WHERE token = '$token' and validator2='$nip'");

//cari NIP pembuat surat dulu
$sql1 = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE token='$token'");
$dsql1 = mysqli_fetch_array($sql1);
$nim = $dsql1['nim'];

//cari email pembuat surat dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
$dsql3 = mysqli_fetch_array($sql3);
$namamhs = $dsql3['nama'];
$emailmhs = $dsql3['email'];

//kirim email
$surat = 'Izin Cuti';
$subject = "Pengajuan Surat " . $surat;
$pesan = "Yth. " . $namamhs . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan Surat " . $surat . " anda telah disetujui.<br/>
        Silahkan masuk kedalam SAINTEK e-Office untuk mencetak surat anda.<br/>
        <br/>
        <a href='https://eoffice.saintek.uin-malang.ac.id' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik disini <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailmhs, $namamhs, $subject, $pesan);

header("location:index.php");

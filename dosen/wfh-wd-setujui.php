<?php
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$bulan = date('m');
$tahun = date('Y');
$qurutan = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE year(tglsurat)=$tahun");
$urutan = mysqli_num_rows($qurutan);

$nosurat = $urutan . ".O/FST.2/KP.01.4/" . $bulan . "/" . $tahun . "";

//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE wfh
					SET tglverifikasifakultas = '$tgl', 
					verifikasifakultas = '1',
					keterangan = '$nosurat'
					WHERE token = '$token'");

//cari email pembuat surat
//cari NIP pembuat surat dulu
$sql1 = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE token='$token'");
$dsql1 = mysqli_fetch_array($sql1);
$nip = $dsql1['nip'];

//cari email pembuat surat dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nip'");
$dsql3 = mysqli_fetch_array($sql3);
$namadosen = $dsql3['nama'];
$emaildosen = $dsql3['email'];

//kirim email
$subject = "Pengajuan Ijin WFH";
$pesan = "Yth. " . $namadosen . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan Surat Ijin <i>Work From Home</i> anda telah disetujui.<br/>
        Silahkan klik tombol dibawah ini mencetak Surat Ijin tersebut<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/dosen/wfh-cetakrk.php?nodata=$nodata' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>Cetak Rencana Kerja</a><br/>
        <br/>
		<a href='https://saintek.uin-malang.ac.id/online/dosen/wfh-cetakst.php?nodata=$nodata' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>Cetak Surat Tugas</a><br/>
		<br/>
        atau silahkan mencetak melalui website SAINTEK Online di <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK Online</b>";
sendmail($emaildosen, $namadosen, $subject, $pesan);

header("location:index.php");

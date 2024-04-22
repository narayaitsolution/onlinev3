<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');
date_default_timezone_set("Asia/Jakarta");
$tglsekarang = date('Y-m-d H:i:s');
$tahun = date('Y');
$bulan = date('m');

$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$nosurat = mysqli_real_escape_string($dbsurat, $_POST['nosurat']);
$pembiayaan = $_POST['pembiayaan'];

//update status validasi kaprodi
$keterangan = $nosurat . '/FST/' . $bulan . '/' . $tahun;
$statussurat = 1;
$verifikasi2 = 1;

$stmt = $dbsurat->prepare("UPDATE sk 
                            SET keterangan=?, pembiayaan=?,verifikasi2=?,tglverifikasi2=?,nosurat=?,statussurat=?
                            WHERE token=?");
$stmt->bind_param("sssssss", $keterangan, $pembiayaan, $verifikasi2, $tglsekarang, $nosurat, $statussurat, $token);
$stmt->execute();

//kirim email ke mhs
//cari email wadek3 dari NIP
$sql2 = mysqli_query($dbsurat, "SELECT * FROM sk WHERE token='$token'");
$dsql2 = mysqli_fetch_array($sql2);
$nipmhs = $dsql2['nim'];
$jenissk = $dsql2['jenissk'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipmhs'");
$dsql3 = mysqli_fetch_array($sql3);
$namamhs = $dsql3['nama'];
$emailmhs = $dsql3['email'];

//kirim email
$subject = "Status Pengajuan SK " . $jenissk . ".";
$pesan = "Yth. " . $namamhs . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan SK " . $jenissk . " anda di sistem SAINTEK e-Office <b>TELAH DISETUJUI</b>.<br>
        Silahkan mengambil SK anda di Bagian Umum Fakultas <b>pada Hari dan Jam Kerja</b>. <br>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailmhs, $namamhs, $subject, $pesan);

header("location:index.php");

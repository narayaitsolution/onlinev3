<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/phpmailer/sendmail.php');

$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$biaya = mysqli_real_escape_string($dbsurat, $_POST['biaya']);

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//nomorsurat
$bulan = date('m');
$tahun = date('Y');
//cari urutan surat di tahun ini untuk no surat
$qurutan = mysqli_query($dbsurat, "SELECT * FROM suket WHERE year(tanggal)=$tahun");
$urutan = mysqli_num_rows($qurutan);

$nosurat = "B-" . $urutan + 1 . ".O/FST.3/KM.01.2/" . $bulan . "/" . $tahun . "";


//update status validasi kaprodi
$sql = mysqli_query($dbsurat, "UPDATE delegasi
					SET tglvalidasi3 = '$tgl', 
					validasi3 = '1',
                    biaya ='$biaya',
                    keterangan='$nosurat',
                    statussurat = '1'
					WHERE token = '$token' AND validator3='$nip'");
$qanggota = mysqli_query($dbsurat, "UPDATE delegasianggota SET statussurat=1 WHERE token='$token'");

//kirim email ke wadek3
//cari email wadek3 dari NIP
$sql2 = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE token='$token'");
$dsql2 = mysqli_fetch_array($sql2);
$nama = $dsql2['nama'];
$nim = $dsql2['nim'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
$dsql3 = mysqli_fetch_array($sql3);
$namamhs = $dsql3['nama'];
$emailmhs = $dsql3['email'];

//kirim email
$subject = "Pengajuan Delegasi";
$pesan = "Yth. " . $namamhs . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan Delegasi anda telah disetujui.<br/>
        Silahkan klik tombol dibawah ini untuk masuk ke dalam sistem SAINTEK e-Office dan mencetak surat persetujuan delegasi.<br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailmhs, $namamhs, $subject, $pesan);

header("location:index.php");

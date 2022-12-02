<?php
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$nim = mysqli_real_escape_string($dbsurat, $_SESSION['nim']);
$nama = mysqli_real_escape_string($dbsurat, $_SESSION['nama']);
$prodi = $_SESSION['prodi'];

if ($prodi == 'Perpustakaan dan Ilmu Informasi') {
    //update status validasi dosen
    $sql = mysqli_query($dbsurat, "UPDATE ijinpenelitian
					                SET tglvalidasi1 = '$tgl', 
					                    validasi1 = '1',
                                        tglvalidasi2 = '$tgl', 
                                        validasi2 = '1'
					                WHERE token = '$token'");

    //kirim email ke wadek1
    //cari email wadek dari NIP
    $sql2 = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE token='$token'");
    $dsql2 = mysqli_fetch_array($sql2);
    $nama = $dsql2['nama'];
    $nipwadek1 = $dsql2['validator3'];
    $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipwadek1'");
    $dsql3 = mysqli_fetch_array($sql3);
    $namawadek1 = $dsql3['nama'];
    $emailwadek1 = $dsql3['email'];

    //kirim email
    $surat = 'Ijin Penelitian';
    $subject = "Pengajuan Surat " . $surat;
    $pesan = "Yth. " . $namawadek1 . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat " . $surat . " atas nama " . $nama . " di sistem SAINTEK e-Office.<br/>
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
    sendmail($emailwadek1, $namawadek1, $subject, $pesan);
} else {
    //update status validasi dosen
    $sql = mysqli_query($dbsurat, "UPDATE ijinpenelitian
					SET tglvalidasi1 = '$tgl', 
					validasi1 = '1'
					WHERE token = '$token'");

    //kirim email ke kajur
    //cari email kajur dari NIP
    $sql2 = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE token='$token'");
    $dsql2 = mysqli_fetch_array($sql2);
    $nama = $dsql2['nama'];
    $nipkajur = $dsql2['validator2'];
    $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipkajur'");
    $dsql3 = mysqli_fetch_array($sql3);
    $namakajur = $dsql3['nama'];
    $emailkajur = $dsql3['email'];

    //kirim email
    $surat = 'Ijin Penelitian';
    $subject = "Pengajuan Surat " . $surat;
    $pesan = "Yth. " . $namakajur . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat " . $surat . " atas nama " . $nama . " di sistem SAINTEK e-Office.<br/>
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
    sendmail($emailkajur, $namakajur, $subject, $pesan);
}
header("location:index.php");

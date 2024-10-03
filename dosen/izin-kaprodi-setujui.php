<?php
session_start();

require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$jmlizin = mysqli_real_escape_string($dbsurat, $_POST['jmlizin']);
$nipbawahan = mysqli_real_escape_string($dbsurat, $_POST['nipbawahan']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);

//cek apakah yang mengajukan kaprodi / wd
$qpengaju = mysqli_query($dbsurat, "SELECT * FROM izin WHERE token='$token'");
$dpengaju = mysqli_fetch_array($qpengaju);
$verifikator1 = $dpengaju['validator1'];
$verifikator2 = $dpengaju['validator2'];

if ($verifikator1 == $verifikator2) {
    //update status validasi dosen
    $sql = mysqli_query($dbsurat, "UPDATE izin
					                SET tglvalidasi1 = '$tgl', 
					                    validasi1 = '1',
                                        tglvalidasi2='$tgl', 
                                        validasi2 = '1',
                                        statussurat='1'
					                WHERE token = '$token' and validator1='$nip'");

    //cari email wadek dari NIP
    $sql2 = mysqli_query($dbsurat, "SELECT * FROM izin WHERE token='$token'");
    $dsql2 = mysqli_fetch_array($sql2);
    $nama = $dsql2['nama'];
    $nipbawahan = $dsql2['nip'];
    $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipbawahan'");
    $dsql3 = mysqli_fetch_array($sql3);
    $namawadek2 = $dsql3['nama'];
    $emailwadek2 = $dsql3['email'];

    //kirim email
    $surat = 'Izin';
    $subject = "Pengajuan Surat " . $surat;
    $pesan = "Yth. " . $namawadek2 . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan <b>Surat Izin</b> anda telah disetujui.<br/>
        Silahkan masuk ke sistem SAINTEK e-Office untuk mencetak surat izin anda.<br/>
        <br/>
        <a href='https://eoffice.saintek.uin-malang.ac.id/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><r/>
        <br/>
        atau klik URL berikut ini <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
    sendmail($emailwadek2, $namawadek2, $subject, $pesan);
} else {
    //update status validasi dosen
    $sql = mysqli_query($dbsurat, "UPDATE izin
					SET tglvalidasi1 = '$tgl', 
					validasi1 = '1'
					WHERE token = '$token' and validator1='$nip'");

    //cari email wadek dari NIP
    $sql2 = mysqli_query($dbsurat, "SELECT * FROM izin WHERE token='$token'");
    $dsql2 = mysqli_fetch_array($sql2);
    $nama = $dsql2['nama'];
    $nipwadek2 = $dsql2['validator2'];
    $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipwadek2'");
    $dsql3 = mysqli_fetch_array($sql3);
    $namawadek2 = $dsql3['nama'];
    $emailwadek2 = $dsql3['email'];

    //kirim email
    $surat = 'Izin';
    $subject = "Pengajuan Surat " . $surat;
    $pesan = "Yth. " . $namawadek2 . "<br/>
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
    sendmail($emailwadek2, $namawadek2, $subject, $pesan);
}
header("location:index.php");

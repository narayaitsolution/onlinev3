<?php
session_start();
require('system/dbconn.php');
require('system/phpmailer/sendmail.php');
require('system/myfunc.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');
$suhu = mysqli_real_escape_string($dbsurat, $_POST['suhu']);
$nama = mysqli_real_escape_string($dbsurat, $_POST['nama']);
$instansi = mysqli_real_escape_string($dbsurat, $_POST['instansi']);
$tujuan = mysqli_real_escape_string($dbsurat, $_POST['tujuan']);
$keperluan = mysqli_real_escape_string($dbsurat, $_POST['keperluan']);
$nohp = mysqli_real_escape_string($dbsurat, $_POST['nohp']);
$email = mysqli_real_escape_string($dbsurat, $_POST['email']);
$hakakses = 'tamu';

if ($suhu >= 37.3) {
    header("location:tamu-masuk.php?pesan=tinggi");
} elseif ($suhu < 35) {
    header("location:tamu-masuk.php?pesan=rendah");
} else {
    $stmt = $dbsurat->prepare("INSERT INTO masukfakultas (tanggal, nama, instansiasal, prodi, hakakses,suhu, keperluan, nohp,email,jammasuk)
                                VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssss", $tanggal, $nama, $instansi, $prodi, $hakakses, $suhu, $keperluan, $nohp, $email, $tanggal);
    $stmt->execute();
    $namaurl = urlencode($nama);

    //kirim email
    $subject = "Pelayanan Fakultas SAINTEK UIN Malang";
    $pesan = "Yth. " . $nama . "<br/>
        <br/>
		Salam,
        <br />
		<br />
		Terima kasih telah mengunjungi Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang pada tanggal " . tgljam_indo($tanggal) . ".
		<br />
        Untuk meningkatkan pelayanan kami mohon berkenan untuk menilai pelayanan kami melalui tombol berikut ini :
        <br/>
        <a href='https://saintek.uin-malang.ac.id/penilaianlayanan/index.php?nohp=$nohp&email=$email' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>Penilaian Layanan</a><br/>
        <br/>
        Apabila anda mengalami hal yang kurang menyenangkan selama di Fakultas Sains dan Teknologi, mohon dapat melaporkan melalui tombol berikut ini :
        <br/>
        <a href='https://saintek.uin-malang.ac.id/lapor/' style=' background-color: #FFA600;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>LAPORKAN</a><br/>
        <br/>
        Kerahasiaan laporan anda terjamin. Laporan anda sangat berarti untuk peningkatan layanan kami.
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK Online</b>";
    sendmail($email, $nama, $subject, $pesan);

    header("location:tamu-tampil.php?nama=$namaurl");
}

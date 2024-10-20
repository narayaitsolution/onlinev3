<?php
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$namalab = mysqli_real_escape_string($dbsurat, $_POST['namalab']);

//cek kapasitas lab
$sql3 = mysqli_query($dbsurat, "SELECT * FROM laboratorium WHERE namalab='$namalab'");
$dlab = mysqli_fetch_array($sql3);
$kapasitas = $dlab['kapasitas'];
if ($kapasitas > 0) {
    //update kapasitas lab
    $sql2 = mysqli_query($dbsurat, "UPDATE laboratorium
					SET kapasitas = kapasitas-1 
					WHERE namalab = '$namalab'");

    //update status validasi dosen pembimbing
    $sql = mysqli_query($dbsurat, "UPDATE ijinlab
					SET tglvalidasi1 = '$tgl', 
					validasi1 = '1'
					WHERE token = '$token'");

    //kirim email ke kajur
    //cari email kajur dari NIP
    $sql2 = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE token='$token'");
    $dsql2 = mysqli_fetch_array($sql2);
    $nama = $dsql2['nama'];
    $nipkajur = $dsql2['validator2'];
    $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipkajur'");
    $dsql3 = mysqli_fetch_array($sql3);
    $namakajur = $dsql3['nama'];
    $emailkajur = $dsql3['email'];

    //kirim email
    $surat = 'Ijin Penggunaan Lab.';
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
        <a href='https://eoffice.saintek.uin-malang.ac.id/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
    sendmail($emailkajur, $namakajur, $subject, $pesan);

    header("location:index.php");
} else {
    header("location:ijinlab-dosbing-tampil.php?token=$token&pesan=penuh");
}

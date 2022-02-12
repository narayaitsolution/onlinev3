<?php
require('system/dbconn.php');
require('system/phpmailer/sendmail.php');

$nama = $_POST['nama'];
$nip = mysqli_real_escape_string($dbsurat, $_POST['nim']);
$nohp = mysqli_real_escape_string($dbsurat, $_POST['nohp']);
$email = mysqli_real_escape_string($dbsurat, $_POST['email']);
$prodi = mysqli_real_escape_string($dbsurat, $_POST['prodi']);
$fakultas = 'Sains dan Teknologi';
$username = mysqli_real_escape_string($dbsurat, $_POST['userid']);
$password = $_POST['pass'];
$passmd5 = md5($password);
$kunci = mysqli_real_escape_string($dbsurat, $_POST['kunci']);
$jawaban = mysqli_real_escape_string($dbsurat, $_POST['jawaban']);
$token = md5(uniqid());

if ($kunci == $jawaban) {
    $stmt = $dbsurat->prepare('SELECT * FROM pengguna WHERE nip=? OR email=? OR user=?');
    $stmt->bind_param('sss', $nip, $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $jhasil = $result->num_rows;
    if ($jhasil > 0) {
        header('location:daftar.php?pesan=registered');
    } else {
        $hakakses = 'mahasiswa';
        $aktif = 1;
        $stmt = $dbsurat->prepare("INSERT INTO pengguna (nama, nip, nohp, email, prodi, fakultas, user, pass,hakakses,token,aktif) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssssss", $nama, $nip, $nohp, $email, $prodi, $fakultas, $username, $passmd5, $hakakses, $token, $aktif);
        $stmt->execute();

        //kirim email ke user
        $subject = "Pendaftaran Akun SAINTEK e-Office";
        $pesan = "Yth. " . $nama . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Pendaftaran pengguna pada SAINTEK e-Office telah berhasil dilakukan.
        <br/>
        Silahkan login ke sistem SAINTEK e-Office menggunakan UserID dan Password yang telah anda daftarkan.
		<br />
        Silahkan membalas email ini apabila ada pertanyaan terkait proses pendaftaran ini
        <br/>        
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";

        sendmail($email, $nama, $subject, $pesan);


        //kirim email admin
        $namaadmin = 'Admin SAINTEK e-Office';
        $emailadmin = 'saintekonline@gmail.com';
        $subject = "Pendaftaran Akun SAINTEK e-Office Baru";
        $pesan = "Yth. " . $namaadmin . "<br/>
        <br/>
		Assalamualaikum wr. wb.<br />
		<br />
		Terdapat pendaftaran akun baru di sistem SAINTEK e-Office atas nama <b>" . $nama . " dari Prodi " . $prodi . "</b>.<br/>
        Mohon melakukan verifikasi dan aktivasi terhadap akun tersebut.<br />
        Silahkan klik tombol berikut ini untuk masuk kedalam sistem SAINTEK e-Office.<br/>
        <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #03DF00;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>        
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
        sendmail($emailadmin, $namaadmin, $subject, $pesan);

        header("location:index.php?pesan=success");
    }
}

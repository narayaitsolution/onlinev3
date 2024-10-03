<?php
session_start();

require_once('../system/dbconn.php');
require_once('../system/myfunc.php');
require_once('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$nim = $_SESSION['nip'];
$prodi = $_SESSION['prodi'];

$query3 = mysqli_query($dbsurat, "UPDATE delegasi SET statussurat='0' WHERE token = '$token'");
$query4 = mysqli_query($dbsurat, "UPDATE delegasianggota SET statussurat='0' WHERE token='$token'");

//kirim email ke kaprodi
//cari nip kajur
$kdjabatan = 'kaprodi';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
$stmt->bind_param("ss", $prodi, $kdjabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkaprodi = $dhasil['nip'];

//cari email dosen dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipkaprodi'");
$dsql3 = mysqli_fetch_array($sql3);
$namadosen = $dsql3['nama'];
$emaildosen = $dsql3['email'];

//kirim email
$jenissurat = 'Delegasi';
$subject = "Pengajuan " . $jenissurat . "";
$pesan = "Yth. " . $namadosen . "<br/>
            <br/>
            Assalamualaikum wr. wb.
            <br />
            <br />
            Dengan hormat,
            <br />
            Terdapat pengajuan " . $jenissurat . " atas nama " . namadosen($dbsurat, $nim) . " di sistem SAINTEK e-Office.<br/>
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
sendmail($emaildosen, $namadosen, $subject, $pesan);

header("location:index.php?hasil=ok&pesan=Pengajuan Delegasi Berhasil");

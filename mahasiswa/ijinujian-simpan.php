<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
require('../system/phpmailer/sendmail.php');
$no = 1;
$tahun = date('Y');
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$nama = $_SESSION['nama'];
$nim = $_SESSION['nip'];
$prodi = $_SESSION['prodi'];
$dosen = $_POST['dosen'];
$tglmulai = $_POST['tglmulai'];
$token = md5(uniqid());

$target_dir = "../lampiran/";
$lampiran1 = $_FILES['lampiran1']['tmp_name'];
$lampiran2 = $_FILES['lampiran2']['tmp_name'];
$lampiran1_low = imgresize($lampiran1);
$lampiran2_low = imgresize($lampiran2);
$lampiran1_upload = $target_dir . $nim . '-ujianonline-izinorangtua.jpg';
$lampiran2_upload = $target_dir . $nim . '-ujianonline-persetujuanpembimbing.jpg';

//cari nip dosen
$stmt = $dbsurat->prepare("SELECT * FROM pengguna WHERE nama=?");
$stmt->bind_param("s", $dosen);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipdosen = $dhasil['nip'];

//cari nip kajur
$kdjabatan = 'kaprodi';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
$stmt->bind_param("ss", $prodi, $kdjabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkaprodi = $dhasil['nip'];

//cari nip wd-1
$jabatan = 'wadek1';
$level = 4;
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $jabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipwd = $dhasil['nip'];

if (move_uploaded_file($lampiran1_low, $lampiran1_upload)) {
    if (move_uploaded_file($lampiran2_low, $lampiran2_upload)) {
        $stmt = $dbsurat->prepare("INSERT INTO ijinujian (tanggal,nim,nama,prodi,dosen,tglmulai,lampiran1,lampiran2,validator1,validator2,validator3,token)
                                VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssssss", $tanggal, $nim, $nama, $prodi, $dosen, $tglmulai, $lampiran1_upload, $lampiran2_upload, $nipdosen, $nipkaprodi, $nipwd, $token);
        $stmt->execute();

        //kirim email ke dosen pembimbing
        //cari email dosen dari NIP
        $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipdosen'");
        $dsql3 = mysqli_fetch_array($sql3);
        $namadosen = $dsql3['nama'];
        $emaildosen = $dsql3['email'];

        //kirim email
        $surat = 'Ijin Ujian Offline';
        $subject = "Pengajuan Surat " . $surat . "";
        $pesan = "Yth. " . $namadosen . "<br/>
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
        sendmail($emaildosen, $namadosen, $subject, $pesan);

        header("location:index.php?");
    } else {
        //header("location:ijinujian-isi.php?token=$token&pesan=uploadfailed");
    };
} else {
    //header("location:ijinujian-isi.php?token=$token&pesan=uploadfailed");
}

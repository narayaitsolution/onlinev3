<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/myfunc.php');
require_once('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$kegiatan = $_POST['kegiatan'];
$namakegiatan = $_POST['namakegiatan'];
$penyelenggara = $_POST['penyelenggara'];
$tingkat = $_POST['tingkat'];
$kategori = $_POST['kategori'];
$jeniskegiatan = $_POST['jeniskegiatan'];
$peringkat = $_POST['peringkat'];
$token = md5(uniqid());
$statussurat = 0;
$jenissurat = 'Penghargaan';


//cari nip kajur
$kdjabatan = 'kaprodi';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
$stmt->bind_param("ss", $prodi, $kdjabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkaprodi = $dhasil['nip'];

//cari nip wd-1
$jabatan = 'wadek3';
$level = 4;
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $jabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipwd = $dhasil['nip'];
$target_dir = '../lampiran/';

//upload bukti
$kodeacak1 = random_str(12);
$buktiTmpPath = $_FILES['bukti']['tmp_name'];
$buktiName = $_FILES['bukti']['name'];
$buktiSize = $_FILES['bukti']['size'];
$buktiNameCmps = explode(".", $buktiName);
$fileExtension = strtolower(end($buktiNameCmps));

$bukti = imgresize($buktiTmpPath);
$allowedfileExtensions = array('jpg', 'jpeg');
if (in_array($fileExtension, $allowedfileExtensions)) {
    $buktipath = $target_dir . $kodeacak1 . '.jpg';
    move_uploaded_file($bukti, $buktipath);
    $buktiinfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $buktipath);
    if ($buktiinfo == 'image/jpeg' && $buktiSize < 2097152) {
        $statusbukti = '1';
    } else {
        $statusbukti = '0';
        header("location:penghargaan-isi.php?nip=$nip&pesan=gagal");
    }
}

//upload dok
$kodeacak2 = random_str(12);
$dokTmpPath = $_FILES['dok']['tmp_name'];
$dokName = $_FILES['dok']['name'];
$dokSize = $_FILES['dok']['size'];
$dokNameCmps = explode(".", $dokName);
$fileExtension = strtolower(end($dokNameCmps));

$dok = imgresize($dokTmpPath);
$allowedfileExtensions = array('jpg', 'jpeg');
if (in_array($fileExtension, $allowedfileExtensions)) {
    $dokpath = $target_dir . $kodeacak2 . '.jpg';
    move_uploaded_file($dok, $dokpath);
    $dokinfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dokpath);
    if ($dokinfo == 'image/jpeg' && $dokSize < 2097152) {
        $statusdok = '1';
    } else {
        $statusdok = '0';
        header("location:penghargaan-isi.php?nip=$nip&pesan=gagal");
    }
}


if ($jeniskegiatan == 'Individu') {
    $stmt = $dbsurat->prepare("INSERT INTO penghargaan (tanggal, nim, nama, prodi, kegiatan, namakegiatan, penyelenggara, tingkat, kategori, jeniskegiatan, peringkat, bukti,dokumentasi, validator2, validator3, token) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssssssssss", $tanggal, $nim, $nama, $prodi, $kegiatan, $namakegiatan, $penyelenggara, $tingkat, $kategori, $jeniskegiatan, $peringkat, $buktipath, $dokpath, $nipkaprodi, $nipwd, $token);
    $stmt->execute();

    //kirim email ke kaprodi
    //cari email dosen dari NIP
    $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipkaprodi'");
    $dsql3 = mysqli_fetch_array($sql3);
    $namadosen = $dsql3['nama'];
    $emaildosen = $dsql3['email'];

    //kirim email
    $subject = "Pengajuan " . $jenissurat . "";
    $pesan = "Yth. " . $namadosen . "<br/>
            <br/>
            Assalamualaikum wr. wb.
            <br />
            <br />
            Dengan hormat,
            <br />
            Terdapat pengajuan " . $jenissurat . " atas nama " . $nama . " di sistem SAINTEK e-Office.<br/>
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
    sendmail($emaildosen, $namadosen, $subject, $pesan);

    header("location:index.php?pesan=success");
} else {
    $statussurat = '-1';
    $stmt = $dbsurat->prepare("INSERT INTO penghargaan (tanggal, nim, nama, prodi, kegiatan, namakegiatan, penyelenggara, tingkat, kategori, jeniskegiatan, peringkat, bukti, dokumentasi, validator2, validator3,statussurat, token) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssssssssss", $tanggal, $nim, $nama, $prodi, $kegiatan, $namakegiatan, $penyelenggara, $tingkat, $kategori, $jeniskegiatan, $peringkat, $buktipath, $dokpath, $nipkaprodi, $nipwd, $statussurat, $token);
    $stmt->execute();

    $qnodata = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE nim='$nim' ORDER BY tanggal DESC");
    $dnodata = mysqli_fetch_array($qnodata);
    $token = $dnodata['token'];
    header("location:penghargaan-anggota.php?token=$token&pesan=success");
}

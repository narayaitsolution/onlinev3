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
$tglpelaksanaan = date('Y-m-d', strtotime($_POST['tglpelaksanaan']));
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
$allowed_extensions = ['jpg', 'jpeg'];
$max_file_size = 2 * 1024 * 1024; // 2MB

function secure_upload($file, $kodeacak)
{
    global $target_dir, $allowed_extensions, $max_file_size;

    $file_tmp_path = $file['tmp_name'];
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Check file extension
    if (!in_array($file_ext, $allowed_extensions)) {
        return ['status' => false, 'message' => 'Format file harus JPG/JPEG'];
    }

    // Check file size
    if ($file_size > $max_file_size) {
        return ['status' => false, 'message' => 'Ukuran file maksimal 2MB'];
    }

    $new_file_name = $kodeacak . '.' . $file_ext;
    $destination = $target_dir . $new_file_name;

    if (move_uploaded_file($file_tmp_path, $destination)) {
        // Verify file type after upload
        $file_info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $destination);
        if ($file_info !== 'image/jpeg') {
            unlink($destination); // Delete the file if it's not a JPEG
            return ['status' => false, 'message' => 'Type file harus JPG/JPEG'];
        }
        return ['status' => true, 'path' => $destination];
    } else {
        return ['status' => false, 'message' => 'File gagal diupload'];
    }
}

// Upload bukti
$bukti_result = secure_upload($_FILES['bukti'], random_str(12));
if (!$bukti_result['status']) {
    header("location:penghargaan-isi.php?nip=$nim&hasil=notok&pesan=" . $bukti_result['message']);
    exit;
}
$buktipath = $bukti_result['path'];

// Upload dok
$dok_result = secure_upload($_FILES['dok'], random_str(12));
if (!$dok_result['status']) {
    header("location:penghargaan-isi.php?nip=$nim&hasil=notok&pesan=" . $dok_result['message']);
    exit;
}
$dokpath = $dok_result['path'];

// Upload SKKM
$skkm_result = secure_upload($_FILES['skkm'], random_str(12));
if (!$skkm_result['status']) {
    header("location:penghargaan-isi.php?nip=$nim&hasil=notok&pesan=" . $skkm_result['message']);
    exit;
}
$skkmpath = $skkm_result['path'];

if ($jeniskegiatan == 'Individu') {
    $stmt = $dbsurat->prepare("INSERT INTO penghargaan (tanggal, nim, nama, prodi, kegiatan, namakegiatan, penyelenggara, tglpelaksanaan, tingkat, kategori, jeniskegiatan, peringkat, bukti,dokumentasi,skkm,validator2, validator3, token) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssssssssssss", $tanggal, $nim, $nama, $prodi, $kegiatan, $namakegiatan, $penyelenggara, $tglpelaksanaan, $tingkat, $kategori, $jeniskegiatan, $peringkat, $buktipath, $dokpath, $skkmpath, $nipkaprodi, $nipwd, $token);
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
            <a href='https://eoffice.saintek.uin-malang.ac.id/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
            <br/>
            atau klik URL berikut ini <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
            <br/>
            Wassalamualaikum wr. wb.
            <br/>
            <br/>
            <b>SAINTEK e-Office</b>";
    sendmail($emaildosen, $namadosen, $subject, $pesan);

    header("location:index.php?hasil=ok&pesan=Pengajuan berhasil!!");
} else {
    $statussurat = '-1';
    $stmt = $dbsurat->prepare("INSERT INTO penghargaan (tanggal, nim, nama, prodi, kegiatan, namakegiatan, penyelenggara,tglpelaksanaan, tingkat, kategori, jeniskegiatan, peringkat, bukti, dokumentasi, skkm, validator2, validator3,statussurat, token) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssssssssssss", $tanggal, $nim, $nama, $prodi, $kegiatan, $namakegiatan, $penyelenggara, $tglpelaksanaan, $tingkat, $kategori, $jeniskegiatan, $peringkat, $buktipath, $dokpath, $skkmpath, $nipkaprodi, $nipwd, $statussurat, $token);
    $stmt->execute();

    $qnodata = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE nim='$nim' ORDER BY tanggal DESC");
    $dnodata = mysqli_fetch_array($qnodata);
    $token = $dnodata['token'];
    header("location:penghargaan-anggota.php?token=$token&hasil=ok&pesan=Pengajuan berhasil!!");
}

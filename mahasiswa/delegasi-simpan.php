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
$namakegiatan = $_POST['namakegiatan'];
$tglmulai = date('Y-m-d', strtotime($_POST['tglmulai']));
$tglselesai = date('Y-m-d', strtotime($_POST['tglselesai']));
$tempat = $_POST['tempat'];
$tingkat = $_POST['tingkat'];
$kategori = $_POST['kategori'];
$jeniskegiatan = $_POST['jeniskegiatan'];
$token = md5(uniqid());
$kode = substr(md5(microtime()), rand(0, 26), 12);
$statussurat = 0;
$jenissurat = 'Delegasi';


//cari nip kajur
$kdjabatan = 'kaprodi';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
$stmt->bind_param("ss", $prodi, $kdjabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkaprodi = $dhasil['nip'];

//cari nip wd-3
$jabatan = 'wadek3';
$level = 4;
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $jabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipwd = $dhasil['nip'];

// Fungsi untuk upload dan validasi file
function uploadFile($file, $kode)
{
    $target_dir = "../lampiran/";
    $allowed_extensions = ['jpg', 'jpeg'];
    $max_file_size = 2 * 1024 * 1024; // 2MB

    // Validasi file
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return ['status' => false, 'message' => 'File tidak ditemukan'];
    }

    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_type = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Validasi ekstensi
    if (!in_array($file_type, $allowed_extensions)) {
        return ['status' => false, 'message' => 'Format file harus JPG/JPEG'];
    }

    // Validasi ukuran
    if ($file_size > $max_file_size) {
        return ['status' => false, 'message' => 'Ukuran file maksimal 2MB'];
    }

    // Validasi mime type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);

    if (!in_array($mime_type, ['image/jpeg', 'image/jpg'])) {
        return ['status' => false, 'message' => 'File harus berupa gambar JPG/JPEG'];
    }

    // Simpan file
    $new_filename = $target_dir . $kode . '.jpg';
    if (!move_uploaded_file($file_tmp, $new_filename)) {
        return ['status' => false, 'message' => 'Gagal menyimpan file'];
    }

    return ['status' => true, 'path' => $new_filename];
}

// Proses upload file
if (!isset($_FILES['bukti'])) {
    header("location:delegasi-isi.php?nip=$nim&pesan=File bukti tidak ditemukan&hasil=notok");
    exit;
}

$upload_result = uploadFile($_FILES['bukti'], $kode);
if (!$upload_result['status']) {
    header("location:delegasi-isi.php?nip=$nim&pesan=" . urlencode($upload_result['message']) . "&hasil=notok");
    exit;
}

$dest_path = $upload_result['path'];

// Proses penyimpanan data ke database
if ($jeniskegiatan == 'Individu') {
    $stmt = $dbsurat->prepare("INSERT INTO delegasi (tanggal, nim, nama, prodi, kegiatan, namakegiatan, tglmulai, tglselesai, tempat, tingkat, kategori, jeniskegiatan, bukti, validator1, validator2, validator3, token) 
                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssssssssss", $tanggal, $nim, $nama, $prodi, $kegiatan, $namakegiatan, $tglmulai, $tglselesai, $tempat, $tingkat, $kategori, $jeniskegiatan, $dest_path, $nipkaprodi, $nipwd, $nipwd, $token);
    $stmt->execute();

    $stmt = $dbsurat->prepare("INSERT INTO delegasianggota (token, nimketua, nimanggota) 
                                VALUES (?,?,?)");
    $stmt->bind_param("sss", $token, $nim, $nim);
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

    header("location:index.php?hasil=ok&pesan=Pengajuan Delegasi berhasil");
} else {
    $statussurat = '-1';
    $stmt = $dbsurat->prepare("INSERT INTO delegasi (tanggal, nim, nama, prodi, kegiatan, namakegiatan, tglmulai, tglselesai, tempat, tingkat, kategori, jeniskegiatan, bukti, validator1, validator2, validator3, token) 
                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssssssssss", $tanggal, $nim, $nama, $prodi, $kegiatan, $namakegiatan, $tglmulai, $tglselesai, $tempat, $tingkat, $kategori, $jeniskegiatan, $dest_path, $nipkaprodi, $nipwd, $nipwd, $token);
    $stmt->execute();

    $qnodata = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE nim='$nim' ORDER BY tanggal DESC");
    $dnodata = mysqli_fetch_array($qnodata);
    $token = $dnodata['token'];
    header("location:delegasi-anggota.php?token=$token&hasil=ok&pesan=Masukkan anggota delegasi");
}

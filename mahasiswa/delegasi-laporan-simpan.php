<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/myfunc.php');
require_once('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$token = $_POST['token'];
$noktp = $_POST['noktp'];
$norek = $_POST['norek'];
$bank = $_POST['bank'];
$nimketua = $_SESSION['nip'];

$statuslaporan = 0;

$upload_dir = "../lampiran/";
// Validasi dan upload file
$allowed_pdf = ['application/pdf'];
$allowed_image = ['image/jpeg'];
$max_size_laporan = 5 * 1024 * 1024; // 5MB
$max_size_image = 1 * 1024 * 1024; // 1MB

$errors = [];

/// Laporan file
if (isset($_FILES['laporan'])) {
    $laporan = $_FILES['laporan'];
    if (!in_array($laporan['type'], $allowed_pdf) || $laporan['size'] > $max_size_laporan) {
        $errors[] = "Laporan harus berupa file PDF dan maksimal 5MB.";
    }
} else {
    $errors[] = "File laporan tidak ditemukan.";
}

// KTP file
if (isset($_FILES['ktp'])) {
    $ktp = $_FILES['ktp'];
    if (!in_array($ktp['type'], $allowed_image) || $ktp['size'] > $max_size_image) {
        $errors[] = "Foto KTP harus berupa file JPG dan maksimal 1MB.";
    }
} else {
    $errors[] = "File KTP tidak ditemukan.";
}

// KTM file
if (isset($_FILES['ktm'])) {
    $ktm = $_FILES['ktm'];
    if (!in_array($ktm['type'], $allowed_image) || $ktm['size'] > $max_size_image) {
        $errors[] = "Foto KTM harus berupa file JPG dan maksimal 1MB.";
    }
} else {
    $errors[] = "File KTM tidak ditemukan.";
}

// Buku tabungan file
if (isset($_FILES['bukutabungan'])) {
    $bukutabungan = $_FILES['bukutabungan'];
    if (!in_array($bukutabungan['type'], $allowed_image) || $bukutabungan['size'] > $max_size_image) {
        $errors[] = "Foto buku tabungan harus berupa file JPG dan maksimal 1MB.";
    }
} else {
    $errors[] = "File buku tabungan tidak ditemukan.";
}

// Jika ada kesalahan, tampilkan dan hentikan eksekusi
if (!empty($errors)) {
    foreach ($errors as $error) {
        header("location:delegasi-laporan-isi.php?hasil=notok&token=$token&pesan=" . $error);
    }
    exit;
} else {
    // If all files are valid, proceed with database operations
    $laporan_path = $upload_dir . "laporan_" . $nimketua . time() . ".pdf";
    $ktp_path = $upload_dir . "ktp_" . $nimketua . time() . ".jpg";
    $ktm_path = $upload_dir . "ktm_" . $nimketua . time() . ".jpg";
    $bukutabungan_path = $upload_dir . "bukutabungan_" . $nimketua . time() . ".jpg";

    move_uploaded_file($laporan['tmp_name'], $laporan_path);
    move_uploaded_file($ktp['tmp_name'], $ktp_path);
    move_uploaded_file($ktm['tmp_name'], $ktm_path);
    move_uploaded_file($bukutabungan['tmp_name'], $bukutabungan_path);

    // Update tabel delegasi
    $stmt = $dbsurat->prepare("UPDATE delegasi 
                                SET laporan=?, tgllaporan=?, statuslaporan=?
                                WHERE token=?");
    $stmt->bind_param("ssss", $laporan_path, $tanggal, $statuslaporan, $token);
    $stmt->execute();

    // Insert data tabel delegasiupload
    $stmt = $dbsurat->prepare("INSERT INTO delegasiupload (tanggal, token, nimketua, laporan, noktp, fotoktp, fotoktm, norek, bank, butab) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssss",
        $tanggal,
        $token,
        $nimketua,
        $laporan_path,
        $noktp,
        $ktp_path,
        $ktm_path,
        $norek,
        $bank,
        $bukutabungan_path
    );
    $stmt->execute();

    // Cari nip wd-3
    $jabatan = 'wadek3';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatan);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipwd = $dhasil['nip'];

    // Kirim email ke koordinator
    $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipwd'");
    $dsql3 = mysqli_fetch_array($sql3);
    $namakoor = $dsql3['nama'];
    $emailkoor = $dsql3['email'];

    // Kirim email
    $jenissurat = "Laporan Kegiatan Delegasi";
    $subject = "Pengajuan " . $jenissurat;
    $pesan = "Yth. " . $namakoor . "<br/>
              <br/>
              Assalamualaikum wr. wb.
              <br />
              <br />
              Dengan hormat,
              <br />
              Terdapat pengajuan " . $jenissurat . " di sistem SAINTEK e-Office.<br/>
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
    sendmail($emailkoor, $namakoor, $subject, $pesan);

    header("location:index.php?hasil=ok&pesan=Upload laporan berhasil");
}

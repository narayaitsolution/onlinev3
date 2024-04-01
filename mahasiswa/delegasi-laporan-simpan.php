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

$target_dir = "../lampiran/";
$allowedfileExtensions = array('jpg', 'jpeg', 'pdf');

//cek file laporan
$kodeacak1 = random_str(12);
$laporanTmpPath = $_FILES['laporan']['tmp_name'];
$laporanName = $_FILES['laporan']['name'];
$laporanSize = $_FILES['laporan']['size'];
$laporanPecah = explode(".", $laporanName);
$fileExtension = strtolower(end($laporanPecah));
if ($laporanSize < 5242880) {
  if (in_array($fileExtension, $allowedfileExtensions)) {
    $laporanPath = $target_dir . $kodeacak1 . '.pdf';
    move_uploaded_file($laporanTmpPath, $laporanPath);
    $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $laporanPath);
    if ($info == 'application/pdf') {
      $statusLaporan = '1';
    } else {
      $statusLaporan = '0';
      header("location:delegasi-laporan-isi.php?token=$token&pesan=File Laporan WAJIB format PDF!!");
    };
  } else {

    header("location:delegasi-laporan-isi.php?token=$token&pesan=gagal=File Laporan WAJIB format PDF!!");
  };
} else {
  header("location:delegasi-laporan-isi.php?token=$token&pesan=gagal=Ukuran file maksimal 5MB!!");
}

//cek file ktp
$kodeacak2 = random_str(12);
$ktpTmpPath = $_FILES['ktp']['tmp_name'];
$ktpName = $_FILES['ktp']['name'];
$ktpSize = $_FILES['ktp']['size'];
$ktpPecah = explode(".", $ktpName);
$fileExtension = strtolower(end($ktpPecah));
if ($ktpSize < 1048576) {
  if (in_array($fileExtension, $allowedfileExtensions)) {
    $ktpPath = $target_dir . $kodeacak2 . '.jpg';
    move_uploaded_file($ktpTmpPath, $ktpPath);
    $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $ktpPath);
    if ($info == 'image/jpeg') {
      $statusktp = '1';
    } else {
      $statusktp = '0';
      header("location:delegasi-laporan-isi.php?token=$token&pesan=File KTP WAJIB format JPG!!");
    };
  } else {
    header("location:delegasi-laporan-isi.php?token=$token&pesan=gagal=File KTP WAJIB format JPG!!");
  };
} else {
  header("location:delegasi-laporan-isi.php?token=$token&pesan=gagal=Ukuran file KTP maksimal 1MB!!");
}

//cek file buku tabungan
$kodeacak3 = random_str(12);
$butabTmpPath = $_FILES['butab']['tmp_name'];
$butabName = $_FILES['butab']['name'];
$butabSize = $_FILES['butab']['size'];
$butabPecah = explode(".", $butabName);
$fileExtension = strtolower(end($butabPecah));
if ($butabSize < 1048576) {
  if (in_array($fileExtension, $allowedfileExtensions)) {
    $butabPath = $target_dir . $kodeacak3 . '.jpg';
    move_uploaded_file($butabTmpPath, $butabPath);
    $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $butabPath);
    if ($info == 'image/jpeg') {
      $statusbutab = '1';
    } else {
      $statusbutab = '0';

      header("location:delegasi-laporan-isi.php?token=$token&pesan=File Buku Tabungan WAJIB format JPG!!");
    };
  } else {

    header("location:delegasi-laporan-isi.php?token=$token&pesan=gagal=File Buku Tabungan WAJIB format JPG!!");
  };
} else {
  header("location:delegasi-laporan-isi.php?token=$token&pesan=gagal=Ukuran file Buku Tabungan maksimal 1MB!!");
}

//jika semua ok maka upload
if ($statusLaporan == '1' && $statusktp == '1' && $statusbutab == '1') {
  //update tabel delegasi
  $stmt = $dbsurat->prepare("UPDATE delegasi 
                            SET laporan=?, tgllaporan=?,statuslaporan=?
                            WHERE token=?");
  $stmt->bind_param("ssss", $laporanPath, $tanggal, $statuslaporan, $token);
  $stmt->execute();

  //insert data tabel delegasiupload
  $stmt = $dbsurat->prepare("INSERT INTO delegasiupload (tanggal,token,nimketua,laporan,noktp,fotoktp,norek,bank,butab) 
                            VALUES (?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param("sssssssss", $tanggal, $token, $nimketua, $laporanPath, $noktp, $ktpPath, $norek, $bank, $butabPath);
  $stmt->execute();

  //cari nip wd-3
  $jabatan = 'wadek3';
  $level = 4;
  $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
  $stmt->bind_param("s", $jabatan);
  $stmt->execute();
  $result = $stmt->get_result();
  $dhasil = $result->fetch_assoc();
  $nipwd = $dhasil['nip'];


  //kirim email ke koordinator
  //cari email dosen dari NIP
  $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipwd'");
  $dsql3 = mysqli_fetch_array($sql3);
  $namakoor = $dsql3['nama'];
  $emailkoor = $dsql3['email'];

  //kirim email
  $jenissurat = "Laporan Kegiatan Delegasi";
  $subject = "Pengajuan " . $jenissurat . "";
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
            <a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
            <br/>
            atau klik URL berikut ini <a href='https://saintek.uin-malang.ac.id/online/'>https://saintek.uin-malang.ac.id/online/</a> apabila tombol diatas tidak berfungsi.<br/>
            <br/>
            Wassalamualaikum wr. wb.
            <br/>
            <br/>
            <b>SAINTEK e-Office</b>";
  sendmail($emailkoor, $namakoor, $subject, $pesan);

  header("location:index.php?pesan=success");
}

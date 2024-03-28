<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/myfunc.php');
require_once('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$token = $_POST['token'];
$statuslaporan = 0;

$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['laporan']['tmp_name'];
$fileName = $_FILES['laporan']['name'];
$fileSize = $_FILES['laporan']['size'];
$fileType = $_FILES['laporan']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));
$kode = substr(md5(microtime()), rand(0, 26), 12);
$laporan = imgresize($fileTmpPath);
$allowedfileExtensions = array('pdf');
if (in_array($fileExtension, $allowedfileExtensions)) {
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $file_mime = finfo_file($finfo, $_FILES['laporan']['tmp_name']);
  finfo_close($finfo);

  if ($file_mime === 'application/pdf' && $fileSize <= 5242880) {

    $dest_path = $target_dir . $kode . '.pdf';
    move_uploaded_file($laporan, $dest_path);

    $stmt = $dbsurat->prepare("UPDATE delegasi 
                                  SET laporan=?, tgllaporan=?,statuslaporan=?
                                  WHERE token=?");
    $stmt->bind_param("ssss", $dest_path, $tanggal, $statuslaporan, $token);
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
  } else {
    header("location:delegasi-laporan-isi.php?token=$token&pesan=gagal");
  }
} else {
  header("location:delegasi-laporan-isi.php?token=$token&pesan=gagal");
}

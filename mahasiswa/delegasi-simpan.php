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
$tingkat = $_POST['tingkat'];
$kategori = $_POST['kategori'];
$jeniskegiatan = $_POST['jeniskegiatan'];
$token = md5(uniqid());
$kode = substr(md5(microtime()), rand(0, 26), 12);
$statussurat = 0;
$jenissurat = 'Delegasi';


//cari nip koordinator mahasiswa alumni
$kdjabatan = 'koormhsalumni';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $kdjabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkoor = $dhasil['nip'];

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


$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['bukti']['tmp_name'];

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$file_mime = finfo_file($finfo, $_FILES['bukti']['tmp_name']);
finfo_close($finfo);

if ($file_mime === 'image/jpg' || $file_mime === 'image/jpeg') {
  $fileName = $_FILES['bukti']['name'];
  $fileSize = $_FILES['bukti']['size'];
  $fileType = $_FILES['bukti']['type'];
  $fileNameCmps = explode(".", $fileName);
  $fileExtension = strtolower(end($fileNameCmps));

  $bukti = imgresize($fileTmpPath);
  $allowedfileExtensions = array('jpg', 'jpeg');
  if (in_array($fileExtension, $allowedfileExtensions)) {
    $dest_path = $target_dir . $kode . '.jpg';

    move_uploaded_file($bukti, $dest_path);
    if ($jeniskegiatan == 'Individu') {
      $stmt = $dbsurat->prepare("INSERT INTO delegasi (tanggal, nim, nama, prodi, kegiatan, namakegiatan, tingkat, kategori, jeniskegiatan,bukti, validator1, validator2, validator3, token) 
                                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stmt->bind_param("ssssssssssssss", $tanggal, $nim, $nama, $prodi, $kegiatan, $namakegiatan, $tingkat, $kategori, $jeniskegiatan, $dest_path, $nipkaprodi, $nipkoor, $nipwd, $token);
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
      $stmt = $dbsurat->prepare("INSERT INTO delegasi (tanggal, nim, nama, prodi, kegiatan, namakegiatan, tingkat, kategori, jeniskegiatan, bukti,validator1, validator2, validator3,statussurat, token) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stmt->bind_param("sssssssssssssss", $tanggal, $nim, $nama, $prodi, $kegiatan, $namakegiatan, $tingkat, $kategori, $jeniskegiatan,  $dest_path, $nipkaprodi, $nipkoor, $nipwd, $statussurat, $token);
      $stmt->execute();

      $qnodata = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE nim='$nim' ORDER BY tanggal DESC");
      $dnodata = mysqli_fetch_array($qnodata);
      $token = $dnodata['token'];
      header("location:delegasi-anggota.php?token=$token");
    }
  } else {
    header("location:delegasi-isi.php?nip=$nip&pesan=gagal");
  }
} else {
  header("location:delegasi-isi.php?nip=$nip&pesan=gagal");
}

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
$tingkat = $_POST['tingkat'];
$kategori = $_POST['kategori'];
$jeniskegiatan = $_POST['jeniskegiatan'];
$peringkat = $_POST['peringkat'];
$token = md5(uniqid());
$kode = substr(md5(microtime()), rand(0, 26), 12);
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


$target_dir = "../lampiran/";
$fileTmpPath = $_FILES['bukti']['tmp_name'];
$fileName = $_FILES['bukti']['name'];
$fileSize = $_FILES['bukti']['size'];
$fileType = $_FILES['bukti']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

if (!empty($fileName)) {
    $bukti = imgresize($fileTmpPath);
    $allowedfileExtensions = array('jpg', 'jpeg');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $dest_path = $target_dir . $kode . '.jpg';
        move_uploaded_file($bukti, $dest_path);
        $stmt = $dbsurat->prepare("INSERT INTO penghargaan (tanggal, nim, nama, prodi, kegiatan, namakegiatan, tingkat, kategori, jeniskegiatan, peringkat, bukti, validator2, validator3, token) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssssssss", $tanggal, $nim, $nama, $prodi, $kegiatan, $namakegiatan, $tingkat, $kategori, $jeniskegiatan, $peringkat, $dest_path, $nipkaprodi, $nipwd, $token);
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
        header("location:penghargaan-isi.php?nip=$nip&pesan=gagal");
    };
} else {
    header("location:penghargaan-isi.php?nip=$nip&pesan=gagal");
}

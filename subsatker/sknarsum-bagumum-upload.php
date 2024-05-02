<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/myfunc.php');
require_once('../system/phpmailer/sendmail.php');
date_default_timezone_set("Asia/Jakarta");
$tglsekarang = date('Y-m-d H:i:s');
$tahun = date('Y');
$bulan = date('m');

$nip = mysqli_real_escape_string($dbsurat, $_SESSION['nip']);
$token = mysqli_real_escape_string($dbsurat, $_POST['token']);


$target_dir = "../lampiran/";
$allowedfileExtensions = array('pdf', 'PDF');

//cek file laporan
$kodeacak1 = random_str(12);
$sktteTmpPath = $_FILES['sktte']['tmp_name'];
$sktteName = $_FILES['sktte']['name'];
$sktteSize = $_FILES['sktte']['size'];
$skttePecah = explode(".", $sktteName);
$fileExtension = strtolower(end($skttePecah));

if (in_array($fileExtension, $allowedfileExtensions)) {
    $skttePath = $target_dir . $kodeacak1 . '.pdf';
    move_uploaded_file($sktteTmpPath, $skttePath);
    $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $skttePath);
    $statussurat = '3';
    if ($info == 'application/pdf') {
        $stmt = $dbsurat->prepare("UPDATE sk 
                            SET sktte=?,statussurat=?
                            WHERE token=?");
        $stmt->bind_param("sss", $skttePath, $statussurat, $token);
        $stmt->execute();

        //kirim email ke mhs
        //cari email wadek3 dari NIP
        $sql2 = mysqli_query($dbsurat, "SELECT * FROM sk WHERE token='$token'");
        $dsql2 = mysqli_fetch_array($sql2);
        $nipmhs = $dsql2['nim'];
        $jenissk = $dsql2['jenissk'];
        $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipmhs'");
        $dsql3 = mysqli_fetch_array($sql3);
        $namamhs = $dsql3['nama'];
        $emailmhs = $dsql3['email'];

        //kirim email
        $subject = "Status Pengajuan SK " . $jenissk . ".";
        $pesan = "Yth. " . $namamhs . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan SK " . $jenissk . " anda di sistem SAINTEK e-Office <b>TELAH DISETUJUI</b>.<br>
        Silahkan unduh SK di SAINTEK e-Office. <br>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
        sendmail($emailmhs, $namamhs, $subject, $pesan);

        header("location:index.php?hasil=ok&pesan=Upload SK berhasil");
    } else {
        $statussktte = '0';
        header("location:sknarsum-bagumum-tte.php?token=$token&hasil=notok&pesan=Upload GAGAL!!");
    };
} else {
    header("location:sknarsum-bagumum-tte.php?token=$token&hasil=notok&pesan=File harus format PDF!!");
};

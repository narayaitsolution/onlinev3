<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$keterangan = $_POST['keterangan'];
$nodata = $_POST['nodata'];
$pejabat = 'wadek3';

//cari nip koordinator pkl
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $pejabat);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipwd3 = $dhasil['nip'];

//kirim email ke koordinator pkl
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipwd3'");
$dsql3 = mysqli_fetch_array($sql3);
$namawd3 = $dsql3['nama'];
$emailwd3 = $dsql3['email'];

//kirim email
$subject = "Pengajuan Pembatakan Surat Magang";
$pesan = "Yth. " . $namawd3 . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan <b>Pembatalan Surat Magang di SAINTEK e-Office</b> atas nama " . $nama . " <br/>
        dengan alasan <b>" . $keterangan . "</b>.<br/>
        Silahkan klik tombol dibawah ini untuk pembatalan surat Magang tersebut <br/>
        <br/>
        <a href='https://eoffice.saintek.uin-malang.ac.id/dosen/pengajuanmhs-maganghapus.php?nodata=$nodata' style=' background-color: #ff0000;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        History Surat Magang yang telah dibatalkan dapat dilihat di SAINTEK e-Office dari menu <b>Surat Mahasiswa Disetujui</b>.
        <br/>
        atau klik tombol dibawah ini <br><a href='https://eoffice.saintek.uin-malang.ac.id/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a> <br>Untuk mengakses SAINTEK e-Office.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailwd3, $namawd3, $subject, $pesan);

header("location:index.php?hasil=ok&pesan=Pengajuan Pembatalan Magang berhasil. Harap menunggu proses pembatalan oleh Wakil Dekan 3 Bidang Kemahasiswaan");

<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$keterangan = $_POST['keterangan'];
$nodata = $_POST['nodata'];

//cari nip koordinator pkl
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan='koorpkl'");
$stmt->bind_param("s", $prodi);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkoor = $dhasil['nip'];

//kirim email ke koordinator pkl
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipkoor'");
$dsql3 = mysqli_fetch_array($sql3);
$namakoor = $dsql3['nama'];
$emailkoor = $dsql3['email'];

//kirim email
$subject = "Pengajuan Pembatakan Surat Izin PKL";
$pesan = "Yth. " . $namakoor . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan <b>Pembatalan Surat Izin PKL di SAINTEK e-Office</b> atas nama ketua kelompok " . $nama . " <br/>
        dengan alasan <b>" . $keterangan . "</b>.<br/>
        Silahkan klik tombol dibawah ini untuk pembatalan surat Izin PKL tersebut <br/>
        <br/>
        <a href='https://saintek.uin-malang.ac.id/online/dosen/pengajuanmhs-pklhapus.php?nodata=$nodata' style=' background-color: #ff0000;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        History Surat Izin PKL yang telah dibatalkan dapat dilihat di SAINTEK e-Office dari menu <b>Surat Mahasiswa Disetujui</b>.
        <br/>
        atau klik tombol dibawah ini <br><a href='https://saintek.uin-malang.ac.id/online/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a> <br>Untuk mengakses SAINTEK e-Office.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailkoor, $namakoor, $subject, $pesan);

header("location:index.php?hasil=ok&pesan=Pengajuan Pembatalan Izin PKL berhasil. Harap menunggu proses pembatalan oleh Koordinator PKL");

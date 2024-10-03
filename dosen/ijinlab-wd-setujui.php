<?php
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');

$token = mysqli_real_escape_string($dbsurat, $_POST['token']);
$namalab = mysqli_real_escape_string($dbsurat, $_POST['namalab']);

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');
$bulan = date('m');
$tahun = date('Y');

//cari urutan surat di tahun ini untuk no surat
$qurutan = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE year(tanggal)=$tahun");
$urutan = mysqli_num_rows($qurutan);

$nosurat = "B-" . $urutan . ".O/FST/PP.00.9/" . $bulan . "/" . $tahun . "";

//update status validasi dosen pembimbing
$sql = mysqli_query($dbsurat, "UPDATE ijinlab
					SET tglvalidasi3 = '$tgl', 
					validasi3 = '1',
					keterangan='$nosurat',
					statuspengajuan='1'
					WHERE token = '$token'");

//cari NIP pembuat surat dulu
$sql1 = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE token='$token'");
$dsql1 = mysqli_fetch_array($sql1);
$nim = $dsql1['nim'];

//cari email pembuat surat dari NIP
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
$dsql3 = mysqli_fetch_array($sql3);
$namamhs = $dsql3['nama'];
$emailmhs = $dsql3['email'];

//kirim email
$surat = 'Ijin Penggunaan Lab.';
$subject = "Pengajuan Surat " . $surat;
$pesan = "Yth. " . $namamhs . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Pengajuan Surat " . $surat . " anda telah disetujui.<br/>
        Silahkan klik tombol dibawah ini mencetak Surat tersebut<br/>
        <br/>
        <a href='https://eoffice.saintek.uin-malang.ac.id/mahasiswa/ijinlab-cetak.php?token=$token' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>Cetak Surat Ijin Penggunaan Lab.</a><br/>
        <br/>
        atau silahkan mencetak melalui website SAINTEK e-Office di <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailmhs, $namamhs, $subject, $pesan);

header("location:index.php");

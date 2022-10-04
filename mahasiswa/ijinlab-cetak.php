<html>

<head>
	<link rel="stylesheet" href="../system/surat.css">
</head>

<script>
	window.print();
</script>

<!-- connect to db -->
<?php
require('../system/dbconn.php');
require('../system/myfunc.php');
?>
<!-- ./db -->

<!-- ambil data ijin lab dari tabel ijinlab -->
<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE token = '$token'");
$cek = mysqli_num_rows($query);
if ($cek > 0) {
	$data = mysqli_fetch_array($query);
	$nodata = $data['no'];
	$nim = $data['nim'];
	$nama = $data['nama'];
	$ttl = $data['ttl'];
	$alamatasal = $data['alamatasal'];
	$alamatmalang = $data['alamatmalang'];
	$nohp = $data['nohp'];
	$nohportu = $data['nohportu'];
	$riwayatpenyakit = $data['riwayatpenyakit'];
	$posisi = $data['posisi'];
	$prodi = $data['prodi'];
	$namalab = $data['namalab'];
	$dosen = $data['dosen'];
	$tglmulai = $data['tglmulai'];
	$tglselesai = $data['tglselesai'];
	$validator3 = $data['validator3'];
	$keterangan = $data['keterangan'];
	$tglvalidasi3 = $data['tglvalidasi3'];
	$validasi3 = $data['validasi3'];
}


//get data wd dekan
$datadekan = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$validator3'");
$rowdekan = mysqli_fetch_array($datadekan);
$iddekan = $rowdekan['iddosen'];
$nipdekan = $rowdekan['nip'];
$namadekan = $rowdekan['nama'];
$jabatandekan = $rowdekan['jabatan'];

//buat qrcode
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;
$tgl = date('Y-m-d');
$jam = date('H-m-s');
$codeContents = $actual_link;
$namafile = $nim . "-" . "ijinlab" . $nodata;
QRcode::png($codeContents, "../qrcode/$namafile.png", 'L', 4, 4);
?>

<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
	<tbody>
		<td colspan="5" align="center"><img src="../system/kopsurat.jpg" width="100%" /></td>
	</tbody>
</table>

<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
	<tbody>
		<tr>
			<td>&nbsp;</td>
			<td colspan="4" align="center">
				<h1>SURAT IJIN PENGGUNAAN LABORATORIUM</h1>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="4" align="center">
				<h2>Nomor : <?= $keterangan; ?></h2>
			</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
<font face="Times" size="12">
	<!-- table data pegawai -->
	<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
		<tbody>
			<tr>
				<th width="10%"></th>
				<th width="20%"></th>
				<th width="20%"></th>
				<th width="20%"></th>
				<th width="20%"></th>
				<th width="10%"></th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="4">Yang bertanda tangan di bawah ini :</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Nama</td>
				<td colspan="3">: <?= $namadekan; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>NIP</td>
				<td colspan="3">: <?= $nipdekan; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Jabatan</td>
				<td colspan="3">: <?= $jabatandekan . " Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang"; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="3"></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="4">Dengan ini Memberikan Ijin Penggunaan Layanan Laboratorium di lingkungan Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang kepada Mahasiswa Penelitian Skripsi / Tugas Akhir atas nama : </td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Nama</td>
				<td colspan="3">: <?= $nama; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>NIM</td>
				<td colspan="3">: <?= $nim; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Program Studi</td>
				<td colspan="3">: <?= $prodi; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Laboratorium</td>
				<td colspan="3">: <?= $namalab; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Penggunaan Laboratorium</td>
				<td colspan="3">: <?= tgl_indo($tglmulai); ?> s/d <?= tgl_indo($tglselesai); ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Dosen Pembimbing</td>
				<td colspan="3">: <?= namadosen($dbsurat, $dosen); ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</tbody>
	</table>

	<!-- table bawah -->
	<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
		<tbody>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align:center">Malang, <?= tgl_indo($tglvalidasi3); ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="text-align:center"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align:center">a.n Dekan</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="text-align:center">
					<small><i>Scan QRCode ini </i></small><br />
					<img src="../qrcode/<?= $namafile; ?>.png" width="80" /><br />
					<small><i>untuk verifikasi surat</i></small>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php
				if ($validasi3 == 1) {
				?>
					<td style="text-align:center"><img src="../ttd/<?= $validator3; ?>.jpg" width="300" /></td>
				<?php
				}
				?>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="text-align:center"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</tbody>
</font>
</table>

</html>
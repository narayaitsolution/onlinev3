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

<!-- session -->
<?php
//session_start();
//if($_SESSION['status']!="login"){
//	header("location:../login.php?pesan=belum_login");
//}
?>
<!-- /session -->

<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
// ambil data dari record
$datasurat = mysqli_query($dbsurat, "SELECT * FROM pengambilandata WHERE token='$token'");
$rowsurat = mysqli_fetch_array($datasurat);
$nim = $rowsurat['nim'];
$nosurat = $rowsurat['no'];
$prodi = $rowsurat['prodi'];
$nama = $rowsurat['nama'];
$judulskripsi = $rowsurat['judulskripsi'];
$dosen = $rowsurat['dosen'];
$instansi = $rowsurat['instansi'];
$alamat = $rowsurat['alamat'];
$tglpelaksanaan = $rowsurat['tglpelaksanaan'];
$data = $rowsurat['datadiperlukan'];
$validator3 = $rowsurat['validator3'];
$tglsurat = $rowsurat['tglvalidasi3'];
$keterangan = $rowsurat['keterangan'];
$tglvalidasi3 = $rowsurat['tglvalidasi3'];
$validasi3 = $rowsurat['validasi3'];
$tgl = date('Y-m-d');
$jam = date('his');

//data wd
$datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$validator3'");
$rowwd = mysqli_fetch_array($datawd);
$iddosen = $rowwd['iddosen'];
$nipwd = $rowwd['nip'];
$namawd = $rowwd['nama'];
$jabatan = $rowwd['jabatan'];

//buat qrcode
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$codeContents = $actual_link;
$namafile = $nim . "_" . $tgl . "_" . $jam;
QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);
?>

<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
	<tbody>
		<td colspan="5" align="center"><img src="../system/kopsurat.jpg" width="100%" /></td>
	</tbody>
</table>

<table table style="width:80%; margin-left:auto;margin-right:auto; text-align:justify" cellspacing="0" border="0">
	<thead>
		<tr>
			<td></td>
			<td width="20%"></td>
			<td colspan="2"></td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>&nbsp;</td>
			<td>Nomor </td>
			<td colspan="2">: <?= $keterangan; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Lampiran </td>
			<td colspan="2">: -</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Hal </td>
			<td colspan="2">: Permohonan Data </td>
			<td></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">Yth. Pimpinan <?= $instansi; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3"><?= $alamat; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">Dengan hormat,</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">Sehubungan dengan penelitian mahasiswa Jurusan <?= $prodi; ?> Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang atas nama:</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Nama</td>
			<td colspan="2">: <?= $nama; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>NIM</td>
			<td colspan="2">: <?= $nim; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Judul</td>
			<td colspan="2">: <?= $judulskripsi; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Dosen Pembimbing</td>
			<td colspan="2">: <?= $dosen; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">Maka kami mohon Bapak/Ibu berkenan memberikan izin pada mahasiswa tersebut untuk melakukan penelitian dan mendapatkan data <?= $data; ?> di <?= $instansi; ?> dengan waktu pelaksanaan pada tanggal <?= tgl_indo($tglpelaksanaan); ?>.</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">Demikian permohonan ini, atas perhatian dan kerjasamanya disampaikan terimakasih.</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
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
			<td style="text-align:center">Malang, <?= tgl_indo($tgl); ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<small><i>Scan QRCode ini </i></small><br />
				<img src="../qrcode/<?= $namafile; ?>.png" width="80" /><br />
				<small><i>untuk verifikasi surat</i></small>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<?php
			if ($validasi3 == 1) {
				$sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip = '$validator3'");
				$jdata = mysqli_num_rows($sql);
				if ($jdata > 0) {
					$hasil = mysqli_fetch_array($sql);
					$ttd = $hasil['ttd'];
				} else {
					$ttd = 'imamtazi.jpg';
				}
			?>
				<td style="text-align:center"><img src="../ttd/<?= $ttd; ?>" width="300" /></td>
			<?php
			}
			?>
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
			<td style="text-align:center"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align:center"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align:center"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>


</html>
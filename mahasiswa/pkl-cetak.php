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

<?php
session_start();
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
?>

<?php
$datasurat = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE token='$token'");
$rowsurat = mysqli_fetch_array($datasurat);
$nosurat = $rowsurat['keterangan'];
$nodata = $rowsurat['no'];
$nim = $rowsurat['nim'];
$prodi = $rowsurat['prodi'];
$instansi = $rowsurat['instansi'];
$tempatpkl = $rowsurat['tempatpkl'];
$alamat = $rowsurat['alamat'];
$tglmulai = date('Y-m-d', strtotime($rowsurat['tglmulai']));
$tglselesai = date('Y-m-d', strtotime($rowsurat['tglselesai']));
$idkoordinator = $rowsurat['validator1'];
$tglvalidasi3 = $rowsurat['tglvalidasi3'];
$validator3 = $rowsurat['validator3'];
$validasi3 = $rowsurat['validasi3'];
$tglsurat = date('Y-m-d', strtotime($tglvalidasi3));
$pklmagang = $rowsurat['pklmagang'];
$statussurat = $rowsurat['statussurat'];

if ($statussurat == 1) {

	//data koordinator PKL jurusan
	$datakoor = mysqli_query($dbsurat, "SELECT nama FROM pejabat WHERE nip='$idkoordinator'");
	$rowkoor = mysqli_fetch_row($datakoor);
	$koordinator = $rowkoor[0];

	//data wd
	$datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$validator3'");
	$rowwd = mysqli_fetch_array($datawd);
	$idwd = $rowwd['iddosen'];
	$nipwd = $rowwd['nip'];
	$namawd = $rowwd['nama'];
	$jabatan = $rowwd['jabatan'];

	//buat qrcode
	$tgl = date('Y-m-d');
	$jam = date('H-m-i');
	include "../system/phpqrcode/qrlib.php";
	$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	//echo $actual_link;
	$codeContents = $actual_link;
	$namafile = $nim . "_" . $tgl . "_" . $jam;
	QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);
?>

	<body>
		<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
			<tbody>
				<td colspan="5" align="center"><img src="../system/kopsurat.jpg" width="100%" /></td>
			</tbody>
		</table>

		<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
			<tbody>
				<tr>
					<td>&nbsp;</td>
					<td>Nomor </td>
					<td>: <?= $nosurat; ?></td>
					<td style="text-align:right">Malang, <?= tgl_indo($tglsurat); ?></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Lampiran </td>
					<td>: -</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Hal </td>
					<td>: Izin <?= $pklmagang; ?></td>
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
					<td colspan="3">Yth. <?= $instansi; ?></td>
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
					<td colspan="3" align="justify">Sehubungan dengan persiapan pelaksanaan <?= $pklmagang; ?> Mahasiswa Program Studi <?= $prodi; ?> Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang, maka dengan ini kami mengajukan permohonan untuk menerima penempatan mahasiswa kami di <?= $instansi; ?> pada Unit Kerja / Bagian <?= $tempatpkl ?> dengan waktu pelaksanaan mulai tanggal <?= tgl_indo($tglmulai); ?> sampai dengan tanggal <?= tgl_indo($tglselesai); ?>. </td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">Nama - nama mahasiswa tersebut adalah :</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>

		<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="1">
			<tbody>
				<tr>
					<td width="20%" align="center">NIM</td>
					<td width="50%" align="center">Nama</td>
					<td width="30%" align="center">No. Telp</td>
				</tr>
				<?php
				// data peserta observasi
				$dataanggota = mysqli_query($dbsurat, "SELECT * FROM pklanggota WHERE nimketua='$nim' and nodata='$nodata'");
				$jmlanggota = mysqli_num_rows($dataanggota);
				while ($rowanggota = mysqli_fetch_array($dataanggota)) {
					$nimanggota = $rowanggota['nimanggota'];
					$namaanggota = $rowanggota['nama'];
					$telepon = $rowanggota['telepon'];
				?>
					<tr>
						<td width="20%" align="center"><?= $nimanggota; ?></td>
						<td width="50%" align="left"><?= $namaanggota; ?></td>
						<td width="30%" align="center"><?= $telepon; ?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
			<tbody>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">Koordinator <?= $pklmagang; ?> Program Studi <?= $prodi ?> <?= $koordinator; ?></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">Demikian permohonan kami, atas kesediaannya disampaikan terima kasih.</td>
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
					<td style="text-align:center">Malang, <?= tgl_indo($tglsurat); ?></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="text-align:center"><small><i>Scan QRCode ini </i><br />
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
						<td style="text-align:center"><br />
							<!--<?= $jabatan; ?><br />-->
							<img src="../ttd/<?= $ttd; ?>" width="350" /><br />
							<!--<u><?= $namawd; ?></u><br />
						NIP. <?= $nipwd; ?>-->
						</td>
					<?php
					}
					?>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</body>
<?php
} else {
?>
	<br>
	<br>
	<br>
	<h1 style="text-align: center;">SURAT TIDAK DITEMUKAN / SUDAH DIBATALKAN!!</h1>
<?php
}
?>

</html>
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
//get data wfh from table wfh
$nodata = mysqli_real_escape_string($dbsurat, $_GET['nodata']);
$query = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE no='$nodata'");
$data = mysqli_fetch_array($query);
$fakultas = $data['fakultas'];
$prodi = $data['prodi'];
$tglsurat = $data['tglsurat'];
$iduser = $data['iduser'];
$nip = $data['nip'];
$nama = $data['nama'];
$jabatan = $data['jabatan'];
$tglwfh1 = $data['tglwfh1'];
$kegiatan1 = $data['kegiatan1'];
$tglwfh2 = $data['tglwfh2'];
$kegiatan2 = $data['kegiatan2'];
$tglwfh3 = $data['tglwfh3'];
$kegiatan3 = $data['kegiatan3'];
$tglwfh4 = $data['tglwfh4'];
$kegiatan4 = $data['kegiatan4'];
$tglwfh5 = $data['tglwfh5'];
$kegiatan5 = $data['kegiatan5'];
$verifikatorjurusan = $data['verifikatorprodi'];
$verifikasijurusan = $data['verifikasiprodi'];
$tglverifikasijurusan = $data['tglverifikasiprodi'];
$nosurat = $data['keterangan'];

//get data kajur
$datakajur = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$verifikatorjurusan'");
$row = mysqli_fetch_array($datakajur);
$iddosen = $row['iddosen'];
$nipkajur = $row['nip'];
$namakajur = $row['nama'];
$jabatankajur = $row['kdjabatan'];

//buat qrcode
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$codeContents = $actual_link;
$tgl = date('Y-m-d');
$jam = date('H-m-s');
$namafile = $nip . "_" . $tgl . "_" . $jam;
$ttdkaprodi = $nip . "-WFH-" . $nodata;
QRcode::png($codeContents, "../qrcode/$namafile.png", 'L', 4, 4);

//buat qrcode ttd
$ttd = "https://$_SERVER[HTTP_HOST]/online/dosen/wfh-ttd.php?nodata=$nodata";
$codeContents2 = $ttd;
$ttdkaprodi = $nip . "-WFH-" . $nodata;
QRcode::png($codeContents2, "../qrcode/$ttdkaprodi.png", 'L', 4, 4);
?>

<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
	<tbody>
		<td colspan="5" align="center"><img src="../system/kopsurat.jpg" width="100%" /></td>
	</tbody>
</table>


<table table style="width:100%; margin-left:auto;margin-right:auto;table-layout: fixed;" cellspacing="0" border="0">
	<colgroup>
		<col span="1" style="width: 10%;">
		<col span="1" style="width: 20%;">
		<col span="1" style="width: 30%;">
		<col span="1" style="width: 20%;">
		<col span="1" style="width: 10%;">
	</colgroup>
	<tbody>
		<tr>
			<td>&nbsp;</td>
			<td colspan="4">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="4" align="center">
				<h1>RENCANA KERJA <i>WORK FROM HOME</i> (WFH)</h1>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Nama</td>
			<td colspan="3">: <?php echo $nama; ?> </td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>NIP </td>
			<td colspan="3">: <?php echo $nip; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Jabatan</td>
			<td colspan="3">: <?= $jabatan; ?></td>
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
			<td colspan="4" style="text-align:center"></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="4"></td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>

<!-- table data pegawai -->
<?php $no = 1 ?>
<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="1">
	<tbody>
		<tr>
			<td style="text-align:center" width="5%"><b>No.</b></td>
			<td style="text-align:center" width="20%"><b>Tanggal</b></td>
			<td style="text-align:center" width="75%"><b>Kegiatan</b></td>
		</tr>
		<tr>
			<td style="text-align:center"><?= $no; ?></td>
			<td style="text-align:center"><?= tgl_indo($tglwfh1); ?></td>
			<td style="text-align:left"><?= nl2br($kegiatan1); ?></td>
			<?php $no++; ?>
		</tr>
		<?php
		if (date($tglwfh2) != 0) {
		?>
			<tr>
				<td style="text-align:center"><?= $no; ?></td>
				<td style="text-align:center"><?= tgl_indo($tglwfh2); ?></td>
				<td style="text-align:left"><?= nl2br($kegiatan2); ?></td>
				<?php $no++; ?>
			</tr>
		<?php
		}
		?>
		<?php
		if (date($tglwfh3) != 0) {
		?>
			<tr>
				<td style="text-align:center"><?= $no; ?></td>
				<td style="text-align:center"><?= tgl_indo($tglwfh3); ?></td>
				<td style="text-align:left"><?= nl2br($kegiatan3); ?></td>
				<?php $no++; ?>
			</tr>
		<?php
		}
		?>
		<?php
		if (date($tglwfh4) != 0) {
		?>
			<tr>
				<td style="text-align:center"><?= $no; ?></td>
				<td style="text-align:center"><?= tgl_indo($tglwfh4); ?></td>
				<td style="text-align:left"><?= nl2br($kegiatan4); ?></td>
				<?php $no++; ?>
			</tr>
		<?php
		}
		?>
		<?php
		if (date($tglwfh5) != 0) {
		?>
			<tr>
				<td style="text-align:center"><?= $no; ?></td>
				<td style="text-align:center"><?= tgl_indo($tglwfh5); ?></td>
				<td style="text-align:left"><?= nl2br($kegiatan5); ?></td>
				<?php $no++; ?>
			</tr>
		<?php
		}
		?>
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
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align:center">Malang, <?php echo tgl_indo($tglverifikasijurusan); ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align:center">Menyetujui</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><small><i>Scan QRCode ini </i></small><br />
				<img src="../qrcode/<?php echo $namafile; ?>.png" width="70" /><br />
				<small><i>untuk verifikasi</i></small><br />
				<small><i>keaslian surat</i></small>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<?php
			if ($verifikasijurusan == 1) {
			?>
				<td style="text-align:center">
					<?php
					if ($jabatankajur == 'wadek2') {
						$sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan = '$jabatankajur'");
						$hasil = mysqli_fetch_array($sql);
						$ttd = $hasil['ttd'];
					?>
						<img src="../ttd/<?= $ttd; ?>" width="300px">
					<?php
					} elseif ($jabatankajur == 'dekan') {
						$sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan = '$jabatankajur'");
						$hasil = mysqli_fetch_array($sql);
						$ttd = $hasil['ttd'];
					?>
						<img src="../ttd/<?= $ttd; ?>" width="300px">
					<?php
					} else {
						$sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan = '$jabatankajur' AND prodi='$prodi'");
						$hasil = mysqli_fetch_array($sql);
						$namakajur = $hasil['nama'];
						$nipkajur = $hasil['nip'];
						$ttd = $hasil['ttd'];
					?>
						Kepala Bagian Tata Usaha,<br />
						<img src="../qrcode/<?= $ttdkaprodi; ?>.png" width="70" /><br />
						<u><?= $namakajur; ?></u><br />
						NIP. <?= $nipkajur; ?>
					<?php
					}
					?>
				</td>
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
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
<?php

function conHari($hari)
{
	switch ($hari) {
		case 'Sun':
			$getHari = "Minggu";
			break;
		case 'Mon':
			$getHari = "Senin";
			break;
		case 'Tue':
			$getHari = "Selasa";
			break;
		case 'Wed':
			$getHari = "Rabu";
			break;
		case 'Thu':
			$getHari = "Kamis";
			break;
		case 'Fri':
			$getHari = "Jumat";
			break;
		case 'Sat':
			$getHari = "Sabtu";
			break;
		default:
			$getHari = "Salah";
			break;
	}
	return $getHari;
}
?>

</html>
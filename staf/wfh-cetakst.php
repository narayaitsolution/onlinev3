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
$query = mysqli_query($dbsurat, "select * from wfh where no='$nodata'");
$data = mysqli_fetch_array($query);
$fakultas = $data['fakultas'];
$jurusan = $data['prodi'];
$tglsurat = $data['tglsurat'];
$iduser = $data['iduser'];
$nip = $data['nip'];
$nama = $data['nama'];
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
$verifikatorfakultas = $data['verifikatorfakultas'];
$verifikasifakultas = $data['verifikasifakultas'];
$tglverifikasifakultas = $data['tglverifikasifakultas'];
$nosurat = $data['keterangan'];
$mulaiwfh = $tglwfh1;
if (date($tglwfh5) != 0) {
	$akhirwfh = $tglwfh5;
} else {
	if (date($tglwfh4) != 0) {
		$akhirwfh = $tglwfh4;
	} else {
		if (date($tglwfh3) != 0) {
			$akhirwfh = $tglwfh3;
		} else {
			if (date($tglwfh2 != 0)) {
				$akhirwfh = $tglwfh2;
			} else {
				$akhirwfh = $tglwfh1;
			}
		}
	}
}

//get data wd
$datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan='wadek2'");
$rowwd = mysqli_fetch_array($datawd);
$iddosen = $rowwd['iddosen'];
$nipwd = $rowwd['nip'];
$namawd = $rowwd['nama'];
$jabatan = $rowwd['jabatan'];

//buat qrcode
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;
$tgl = date('Y-m-d');
$jam = date('H-m-s');
$codeContents = $actual_link;
$namafile = $nip . "_" . $tgl . "_" . $jam;
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
			<td colspan="4">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="4" align="center">
				<h1>SURAT TUGAS</h1>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="4" align="center">
				<h2>Nomor : <?php echo $nosurat; ?></h2>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Menimbang</td>
			<td colspan="2">: Permohonan Surat Tugas <i>Work From Home</i> Tanggal <?php echo tgl_indo($tglsurat); ?> </td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Dasar</td>
			<td colspan="2">: 1. SE Rektor UIN Malang No. 276 Tahun 2021</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="4" style="text-align:center"><b>Memberikan Tugas</b></td>
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
<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="1">
	<tbody>
		<tr>
			<td style="text-align:center">No.</td>
			<td style="text-align:center">Nama</td>
			<td style="text-align:center">NIP / NIDT</td>
			<td style="text-align:center">Tempat Tugas</td>
		</tr>
		<tr>
			<td style="text-align:center">1.</td>
			<td style="text-align:center"><?php echo $nama; ?></td>
			<td style="text-align:center"><?php echo $nip; ?></td>
			<td style="text-align:center"><?php echo $jurusan; ?></td>
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
			<td colspan="6">Untuk melaksanakan work from home pada tanggal :
				<ul>
					<?php if (date($tglwfh1) != 0) {
						echo "<li>" . tgl_indo($tglwfh1) . "</li>";
					} ?>
					<?php if (date($tglwfh2) != 0) {
						echo "<li>" . tgl_indo($tglwfh2) . "</li>";
					} ?>
					<?php if (date($tglwfh3) != 0) {
						echo "<li>" . tgl_indo($tglwfh3) . "</li>";
					} ?>
					<?php if (date($tglwfh4) != 0) {
						echo "<li>" . tgl_indo($tglwfh4) . "</li>";
					} ?>
					<?php if (date($tglwfh5) != 0) {
						echo "<li>" . tgl_indo($tglwfh5) . "</li>";
					} ?>
				</ul>
			</td>
		</tr>
		<tr>
			<td colspan="6">Selesai melaksanakan tugas agar segera menyampaikan laporan kepada pemberi tugas.</td>
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
			<td style="text-align:center">Malang, <?php echo tgl_indo($tglverifikasifakultas); ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="text-center">
				<small><i>Scan QRCode ini </i></small><br />
				<img src="../qrcode/<?php echo $namafile; ?>.png" width="70" /><br />
				<small><i>untuk verifikasi</i></small><br />
				<small><i>keaslian surat</i></small><br />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<?php
			if ($verifikasifakultas == 1) {
				if (strtotime($tglverifikasifakultas) > 1629046800) {
					$sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan='wadek2'");
					$dsql = mysqli_fetch_array($sql);
					$ttd = $dsql['ttd'];
				} else {
					$ttd = 'dwisuheriyanto.jpg';
				}

			?>
				<td style="text-align:center">
					<!--<?= $jabatan; ?><br />-->
					<img src="../ttd/<?= $ttd; ?>" width="300px"><br />
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

</html>
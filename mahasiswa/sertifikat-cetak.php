<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
  <link rel="stylesheet" href="../system/surat.css">
</head>

<script>
  //window.print();
</script>

<!-- connect to db -->
<?php require_once('../system/dbconn.php'); ?>
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
  $namafile = $nim . "-" . "ijinlab" . $nodata;
}
?>

<div id="bg">
  <div id="id">
    <table>
      <tr>
        <td>
          <br />
          <img src="../system/saintek-logo.png" width="100%" />
        </td>
      </tr>
    </table>
    <center>
      <!--foto disini-->
    </center>

    <div class="container" align="center">
      <p style="margin-top:2%">Nama</p>
      <p style="font-weight: bold;margin-top:-4%"><?php echo $nama; ?></p>
      <p style="margin-top:-4%">NIM <b><?php echo $nim; ?></b></p>
      <p style="margin-top:-4%">Program Studi <b><?php echo $prodi; ?></b></p>
      <p style="margin-top:-4%">Laboratorium </p>
      <p style="font-weight: bold;margin-top:-4%"><?php echo $namalab; ?></p>
      <p style="margin-top:-4%">Waktu Penggunaan Lab. </p>
      <p style="font-weight: bold;margin-top:-4%"><?php echo tgl_indo($tglmulai) . " s/d " . tgl_indo($tglselesai); ?></p>
      <p style="margin-top:-4%">Dosen Pembimbing </p>
      <p style="font-weight: bold;margin-top:-4%"><?php echo $dosen; ?></p>
      <p style="margin-top:-4%">Surat Ijin Penggunaan Laboratorium </p>
      <p style="font-weight: bold;margin-top:-4%"><img src="../qrcode/<?php echo $namafile . '.png'; ?>" width="140"></img></p>
    </div>
  </div>
  <!--
		<div class="id-1">
			<center>
				<img src=<?php echo "" ?> alt="Avatar" width="200px" height="175px" >        
				<div class="container" align="center">
					<p style="margin:auto">The bearer whose photograph appears overleaf is a staff of</p>
					<h2 style="color:#00BFFF;margin-left:2%">THE STATE OF <?php echo $idsx; ?> </h2>
					<p style="margin:auto">If lost and found please return to the nearest police station</p>
					<hr align="center" style="border: 1px solid black;width:80%;margin-top:13%"></hr> 
					<p align="center" style="margin-top:-2%">Authorized Signature</p>
      		<p> Fakultas Sains dan Teknologi </p>
				</div>
      </center>
		</div>
		-->
</div>

<?php
function tgl_indo($tanggal)
{
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function semester($tanggal)
{
  $pecahkan = explode('-', $tanggal);
  if ($pecahkan[1] < 7) {
    return "Genap Tahun Akademik " . $pecahkan[0] . "/" . $pecahkan[0];
  } else {
    return "Ganjil Tahun Akademik " . $pecahkan[0] . "/" . $pecahkan[0];
  }
}
?>
<style>
  body {
    background: #008080;
  }

  #bg {
    width: 1000px;
    height: 450px;
    margin: 60px;
    float: left;
  }

  #id {
    width: 250px;
    height: 450px;
    position: absolute;
    opacity: 0.88;
    font-family: sans-serif;
    transition: 0.4s;
    /* background-color: #FFFFFF; */
    border-radius: 2%;
  }

  #id::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: url('../system/idcard.jpg');
    /*if you want to change the background image replace logo.png*/
    background-repeat: repeat-x;
    background-size: 250px 450px;
    border-radius: 2%;
    /* opacity: 0.2; */
    z-index: -1;
    text-align: center;
  }

  .container {
    font-size: 12px;
    font-family: sans-serif;
  }

  .id-1 {
    transition: 0.4s;
    width: 250px;
    height: 450px;
    background: #FFFFFF;
    text-align: center;
    font-size: 16px;
    font-family: sans-serif;
    float: left;
    margin: auto;
    margin-left: 270px;
    border-radius: 2%;
  }
</style>

</html>
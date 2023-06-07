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

<!-- ambil data -->
<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$jam = date('H-i-s');
$tahun = date('Y');
$bulan = date('m');
?>

<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
  <tbody>
    <td colspan="5" style="text-align: center;"><img src="../system/kopsurat.jpg" width="100%" /></td>
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
      <td colspan="3" style="text-align: center;"><b>SURAT PERSETUJUAN DELEGASI</b></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
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
<font face="Times" size="12">
  <!-- table data pegawai -->
  <table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
    <tbody>
      <tr>
        <th width="10%">&nbsp;</th>
        <th width="20%"></th>
        <th width="20%"></th>
        <th width="20%"></th>
        <th width="20%"></th>
        <th width="10%"></th>
      </tr>
      <tr>
        <td colspan="6">Terkait dengan pengajuan delegasi mahasiswa atas nama :</td>
      </tr>
      <!-- ambil data -->
      <?php
      $nomer = 1;
      $qdelegasi = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE token='$token'");
      while ($ddelegasi = mysqli_fetch_array($qdelegasi)) {
        $nodata = $ddelegasi['no'];
        $nim = $ddelegasi['nim'];
        $prodi = $ddelegasi['prodi'];
        $jeniskegiatan = $ddelegasi['jeniskegiatan'];
        $namakegiatan = $ddelegasi['namakegiatan'];
        $tglvalidasi3 = $ddelegasi['tglvalidasi3'];
        $validasi3 = $ddelegasi['validasi3'];
        $validator3 = $ddelegasi['validator3'];
      ?>
        <tr>
          <td><?= $nomer; ?></td>
          <td>Nama</td>
          <td colspan="4">: <?= namadosen($dbsurat, $nim); ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>NIM</td>
          <td colspan="4">: <?= $nim; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Jurusan</td>
          <td colspan="4">: <?= $prodi; ?></td>
        </tr>
      <?php
        if ($jeniskegiatan == 'Kelompok') {
          $qdelegasikelompok = mysqli_query($dbsurat, "SELECT * FROM delegasianggota WHERE nodata='$nodata'");
          while ($ddelegasikelompok = mysqli_fetch_array($qdelegasikelompok)) {
            $nimanggota = $ddelegasikelompok['nimanggota'];
          }
        }
      }
      ?>
      <tr>
        <td colspan="6">&nbsp;</td>
      </tr>

      <tr>
        <td colspan="6">Dengan tujuan delegasi adalah untuk <?= $namakegiatan; ?>, maka dengan ini saya sampaikan bahwa pengajuan delegasi telah <b>DISETUJUI</b>. Dan dengan ini pula, mohon pihak administrasi dapat dengan segera menerbitkan SK terkait mahasiswa yang akan didelegasikan.</td>
      </tr>
      <tr>
        <td colspan="6">Demikian surat ini dibuat sebenar - benarnya.</td>
      </tr>

    </tbody>
  </table>

  <!-- ambil data wd --?>
  <?php
  //data wd
  $datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$validator3'");
  $rowwd = mysqli_fetch_array($datawd);
  $idwd = $rowwd['iddosen'];
  $nipwd = $rowwd['nip'];
  $namawd = $rowwd['nama'];
  $jabatanwd = $rowwd['jabatan'];

  //buat qrcode
  include "../system/phpqrcode/qrlib.php";
  $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  //echo $actual_link;
  $tgl = date('Y-m-d');
  $jam = date('H-m-s');
  $codeContents = $actual_link;
  $namafile = $nim . "-" . "suket" . $nodata;
  QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);

  ?>
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
        <td style="text-align:center">
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
    </tbody>
</font>
</table>

</html>
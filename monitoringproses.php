<?php
require('system/myfunc.php');
require('system/dbconn.php');
$bulanini = date('m');
$tahunini = date('Y-m');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SAINTEK e-Office</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="template/plugins/fontawesome6/css/all.css">
  <link rel="stylesheet" href="template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="template/dist/css/adminlte.min.css">
  <style>
    .login-page {
      background-image: url('system/saintek-bg.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>

<body class="hold-transition ">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <h1 style="text-align: center;">Monitoring Proses</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- grafik -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Proses Surat Pengantar PKL</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
              </div>
            </div>
            <?php $no = 1; ?>
            <div class="card-body">
              <!-- cari data PKL 1 tahun terakhir -->
              <?php
              //bulan ini
              $totalWaktu = 0;
              $jumlahData = 0;
              echo 'Bulan = ' . blnthn_indo($tahunini) . '<br>';
              $qbulanini = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini' AND statussurat = 1");
              while ($dbulanini = mysqli_fetch_array($qbulanini)) {
                $waktuawal = strtotime($dbulanini['tanggal']);
                $waktuakhir = strtotime($dbulanini['tglvalidasi3']);
                $selisihWaktu = $waktuakhir - $waktuawal;
                $totalWaktu += $selisihWaktu;
                $jumlahData++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData . '<br>';
              if ($jumlahData > 0) {
                $rataWaktu = $totalWaktu / $jumlahData;
                $rataWaktu = gmdate('H:i:s', $rataWaktu); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini) . ' : ' . $rataWaktu;
              echo '<hr>';

              //bulan ini -1
              $totalWaktu1 = 0;
              $jumlahData1 = 0;
              $bulanini1 = $bulanini - 1;
              echo 'Bulan = ' . bln_indo($bulanini1) . '<br>';
              $qbulanini1 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini1' AND statussurat = 1");
              while ($dbulanini1 = mysqli_fetch_array($qbulanini1)) {
                $waktuawal1 = strtotime($dbulanini1['tanggal']);
                $waktuakhir1 = strtotime($dbulanini1['tglvalidasi3']);
                $selisihWaktu1 = $waktuakhir1 - $waktuawal1;
                $totalWaktu1 += $selisihWaktu1;
                $jumlahData1++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData1 . '<br>';
              if ($jumlahData1 > 0) {
                $rataWaktu1 = $totalWaktu1 / $jumlahData1;
                $rataWaktu1 = gmdate('H:i:s', $rataWaktu1); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu1 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini1) . ' : ' . $rataWaktu1;
              echo '<hr>';

              //bulan ini -2
              $totalWaktu2 = 0;
              $jumlahData2 = 0;
              $bulanini2 = $bulanini - 2;
              echo 'Bulan = ' . bln_indo($bulanini2) . '<br>';
              $qbulanini2 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini2' AND statussurat = 1");
              while ($dbulanini2 = mysqli_fetch_array($qbulanini2)) {
                $waktuawal2 = strtotime($dbulanini2['tanggal']);
                $waktuakhir2 = strtotime($dbulanini2['tglvalidasi3']);
                $selisihWaktu2 = $waktuakhir2 - $waktuawal2;
                $totalWaktu2 += $selisihWaktu2;
                $jumlahData2++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData2 . '<br>';
              if ($jumlahData2 > 0) {
                $rataWaktu2 = $totalWaktu2 / $jumlahData2;
                $rataWaktu2 = gmdate('H:i:s', $rataWaktu2); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu2 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini2) . ' : ' . $rataWaktu2;
              echo '<hr>';

              //bulan ini -3
              $totalWaktu3 = 0;
              $jumlahData3 = 0;
              $bulanini3 = $bulanini - 3;
              echo 'Bulan = ' . bln_indo($bulanini3) . '<br>';
              $qbulanini3 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini3' AND statussurat = 1");
              while ($dbulanini3 = mysqli_fetch_array($qbulanini3)) {
                $waktuawal3 = strtotime($dbulanini3['tanggal']);
                $waktuakhir3 = strtotime($dbulanini3['tglvalidasi3']);
                $selisihWaktu3 = $waktuakhir3 - $waktuawal3;
                $totalWaktu3 += $selisihWaktu3;
                $jumlahData3++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData3 . '<br>';
              if ($jumlahData3 > 0) {
                $rataWaktu3 = $totalWaktu3 / $jumlahData3;
                $rataWaktu3 = gmdate('H:i:s', $rataWaktu3); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu3 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini3) . ' : ' . $rataWaktu3;
              echo '<hr>';

              //bulan ini -4
              $totalWaktu4 = 0;
              $jumlahData4 = 0;
              $bulanini4 = $bulanini - 4;
              echo 'Bulan = ' . bln_indo($bulanini4) . '<br>';
              $qbulanini4 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini4' AND statussurat = 1");
              while ($dbulanini4 = mysqli_fetch_array($qbulanini4)) {
                $waktuawal4 = strtotime($dbulanini4['tanggal']);
                $waktuakhir4 = strtotime($dbulanini4['tglvalidasi3']);
                $selisihWaktu4 = $waktuakhir4 - $waktuawal4;
                $totalWaktu4 += $selisihWaktu4;
                $jumlahData4++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData4 . '<br>';
              if ($jumlahData4 > 0) {
                $rataWaktu4 = $totalWaktu4 / $jumlahData4;
                $rataWaktu4 = gmdate('H:i:s', $rataWaktu4); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu4 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini4) . ' : ' . $rataWaktu4;
              echo '<hr>';

              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <script src="template/plugins/jquery/jquery.min.js"></script>
  <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
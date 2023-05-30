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

  <script src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body class="hold-transition ">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <h1 style="text-align: center;">Waktu Proses Pengajuan Surat</h1>
          <h4 style="text-align: center;">Fakultas Sains dan Teknologi</h4>
          <h4 style="text-align: center;">UIN Maulana Malik Ibrahim Malang</h4>
        </div>
      </div>
    </div>
  </section>

  <!-- surat pengantar PKL -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Rata - Rata Waktu Proses Surat (dalam jam)</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
              </div>
            </div>
            <?php $no = 1; ?>
            <div class="card-body">
              <div id="chart_div"></div>

              <!-- pengantar PKL -->
              <?php
              //bulan ini
              $suratpkl = 'Pengantar PKL';
              $totalWaktupkl = 0;
              $jumlahDatapkl = 0;
              $qpkl = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE statussurat = 1 ORDER by no DESC LIMIT 100");
              while ($dpkl = mysqli_fetch_array($qpkl)) {
                $waktuawalpkl = strtotime($dpkl['tanggal']);
                $waktuakhirpkl = strtotime($dpkl['tglvalidasi3']);
                $selisihWaktupkl = $waktuakhirpkl - $waktuawalpkl;
                $totalWaktupkl += $selisihWaktupkl;
                $jumlahDatapkl++;
              }
              $rataWaktupkl = $totalWaktupkl / $jumlahDatapkl;
              $rataWaktupkljam = date('H', $rataWaktupkl);
              //echo 'Rata-rata waktu proses Pengantar PKL : ' . $rataWaktupkljam;
              ?>

              <!-- surat keterangan rekomendasi-->
              <?php
              //bulan ini
              $suratrekom = 'Rekomendasi';
              $totalWakturekom = 0;
              $jumlahDatarekom = 0;
              $qrekom = mysqli_query($dbsurat, "SELECT * FROM suket WHERE jenissurat='Surat Keterangan Rekomendasi' AND statussurat = 1 ORDER by no DESC LIMIT 100");
              while ($drekom = mysqli_fetch_array($qrekom)) {
                $waktuawalrekom = strtotime($drekom['tanggal']);
                $waktuakhirrekom = strtotime($drekom['tglvalidasi3']);
                $selisihWakturekom = $waktuakhirrekom - $waktuawalrekom;
                $totalWakturekom += $selisihWakturekom;
                $jumlahDatarekom++;
              }
              $rataWakturekom = $totalWakturekom / $jumlahDatarekom;
              $rataWakturekomjam = date('H', $rataWakturekom);
              ?>

              <!-- surat keterangan aktif kuliah-->
              <?php
              //bulan ini
              $surataktif = 'Aktif Kuliah';
              $totalWaktuaktif = 0;
              $jumlahDataaktif = 0;
              $qaktif = mysqli_query($dbsurat, "SELECT * FROM suket WHERE jenissurat='Surat Keterangan Aktif Kuliah' AND statussurat = 1 ORDER by no DESC LIMIT 100");
              while ($daktif = mysqli_fetch_array($qaktif)) {
                $waktuawalaktif = strtotime($daktif['tanggal']);
                $waktuakhiraktif = strtotime($daktif['tglvalidasi3']);
                $selisihWaktuaktif = $waktuakhiraktif - $waktuawalaktif;
                $totalWaktuaktif += $selisihWaktuaktif;
                $jumlahDataaktif++;
              }
              $rataWaktuaktif = $totalWaktuaktif / $jumlahDataaktif;
              $rataWaktuaktifjam = date('H', $rataWaktuaktif);
              ?>

              <!-- surat keterangan kelakuan baik-->
              <?php
              //bulan ini
              $suratbaik = 'Kelakuan Baik';
              $totalWaktubaik = 0;
              $jumlahDatabaik = 0;
              $qbaik = mysqli_query($dbsurat, "SELECT * FROM suket WHERE jenissurat='Surat Keterangan Kelakuan Baik' AND statussurat = 1 ORDER by no DESC LIMIT 100");
              while ($dbaik = mysqli_fetch_array($qbaik)) {
                $waktuawalbaik = strtotime($dbaik['tanggal']);
                $waktuakhirbaik = strtotime($dbaik['tglvalidasi3']);
                $selisihWaktubaik = $waktuakhirbaik - $waktuawalbaik;
                $totalWaktubaik += $selisihWaktubaik;
                $jumlahDatabaik++;
              }
              $rataWaktubaik = $totalWaktubaik / $jumlahDatabaik;
              $rataWaktubaikjam = date('H', $rataWaktubaik);
              ?>

              <!-- surat keterangan penurunan ukt-->
              <?php
              //bulan ini
              $suratturunukt = 'Penurunan UKT';
              $totalWaktuturunukt = 0;
              $jumlahDataturunukt = 0;
              $qturunukt = mysqli_query($dbsurat, "SELECT * FROM suket WHERE jenissurat='Surat Keterangan Penurunan UKT' AND statussurat = 1 ORDER by no DESC LIMIT 100");
              while ($dturunukt = mysqli_fetch_array($qturunukt)) {
                $waktuawalturunukt = strtotime($dturunukt['tanggal']);
                $waktuakhirturunukt = strtotime($dturunukt['tglvalidasi3']);
                $selisihWaktuturunukt = $waktuakhirturunukt - $waktuawalturunukt;
                $totalWaktuturunukt += $selisihWaktuturunukt;
                $jumlahDataturunukt++;
              }
              $rataWaktuturunukt = $totalWaktuturunukt / $jumlahDataturunukt;
              $rataWaktuturunuktjam = date('H', $rataWaktuturunukt);
              ?>

              <!-- surat keterangan keringanan ukt-->
              <?php
              //bulan ini
              $suratringanukt = 'Keringanan UKT';
              $totalWakturinganukt = 0;
              $jumlahDataringanukt = 0;
              $qringanukt = mysqli_query($dbsurat, "SELECT * FROM suket WHERE jenissurat='Surat Keterangan Keringanan UKT' AND statussurat = 1 ORDER by no DESC LIMIT 100");
              while ($dringanukt = mysqli_fetch_array($qringanukt)) {
                $waktuawalringanukt = strtotime($dringanukt['tanggal']);
                $waktuakhirringanukt = strtotime($dringanukt['tglvalidasi3']);
                $selisihWakturinganukt = $waktuakhirringanukt - $waktuawalringanukt;
                $totalWakturinganukt += $selisihWakturinganukt;
                $jumlahDataringanukt++;
              }
              $rataWakturinganukt = $totalWakturinganukt / $jumlahDataringanukt;
              $rataWakturinganuktjam = date('H', $rataWakturinganukt);
              ?>


              <!-- surat ijin penelitian -->
              <?php
              //bulan ini
              $suratpenelitian = 'Ijin Penelitian';
              $totalWaktupenelitian = 0;
              $jumlahDatapenelitian = 0;
              $qpenelitian = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE statussurat = 1 ORDER by no DESC LIMIT 100");
              while ($dpenelitian = mysqli_fetch_array($qpenelitian)) {
                $waktuawalpenelitian = strtotime($dpenelitian['tanggal']);
                $waktuakhirpenelitian = strtotime($dpenelitian['tglvalidasi3']);
                $selisihWaktupenelitian = $waktuakhirpenelitian - $waktuawalpenelitian;
                $totalWaktupenelitian += $selisihWaktupenelitian;
                $jumlahDatapenelitian++;
              }
              $rataWaktupenelitian = $totalWaktupenelitian / $jumlahDatapenelitian;
              $rataWaktupenelitianjam = date('H', $rataWaktupenelitian);
              ?>

              <!-- surat ijin observasi -->
              <?php
              //bulan ini
              $suratobservasi = 'Ijin Observasi';
              $totalWaktuobservasi = 0;
              $jumlahDataobservasi = 0;
              $qobservasi = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE statussurat = 1 ORDER by no DESC LIMIT 100");
              while ($dobservasi = mysqli_fetch_array($qobservasi)) {
                $waktuawalobservasi = strtotime($dobservasi['tanggal']);
                $waktuakhirobservasi = strtotime($dobservasi['tglvalidasi3']);
                $selisihWaktuobservasi = $waktuakhirobservasi - $waktuawalobservasi;
                $totalWaktuobservasi += $selisihWaktuobservasi;
                $jumlahDataobservasi++;
              }
              $rataWaktuobservasi = $totalWaktuobservasi / $jumlahDataobservasi;
              $rataWaktuobservasijam = date('H', $rataWaktuobservasi);
              ?>

              <!-- surat ijin pengambilan data -->
              <?php
              //bulan ini
              $suratpengambilandata = 'Pengambilan Data';
              $totalWaktupengambilandata = 0;
              $jumlahDatapengambilandata = 0;
              $qpengambilandata = mysqli_query($dbsurat, "SELECT * FROM pengambilandata WHERE statussurat = 1 ORDER by no DESC LIMIT 100");
              while ($dpengambilandata = mysqli_fetch_array($qpengambilandata)) {
                $waktuawalpengambilandata = strtotime($dpengambilandata['tanggal']);
                $waktuakhirpengambilandata = strtotime($dpengambilandata['tglvalidasi3']);
                $selisihWaktupengambilandata = $waktuakhirpengambilandata - $waktuawalpengambilandata;
                $totalWaktupengambilandata += $selisihWaktupengambilandata;
                $jumlahDatapengambilandata++;
              }
              $rataWaktupengambilandata = $totalWaktupengambilandata / $jumlahDatapengambilandata;
              $rataWaktupengambilandatajam = date('H', $rataWaktupengambilandata);
              ?>

              <!-- surat ijin pengambilan data -->
              <?php
              //bulan ini
              $suratizinlab = 'Izin Penggunaan Lab';
              $totalWaktuizinlab = 0;
              $jumlahDataizinlab = 0;
              $qizinlab = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE statuspengajuan = 1 ORDER by no DESC LIMIT 100");
              while ($dizinlab = mysqli_fetch_array($qizinlab)) {
                $waktuawalizinlab = strtotime($dizinlab['tanggal']);
                $waktuakhirizinlab = strtotime($dizinlab['tglvalidasi3']);
                $selisihWaktuizinlab = $waktuakhirizinlab - $waktuawalizinlab;
                $totalWaktuizinlab += $selisihWaktuizinlab;
                $jumlahDataizinlab++;
              }
              $rataWaktuizinlab = $totalWaktuizinlab / $jumlahDataizinlab;
              $rataWaktuizinlabjam = date('H', $rataWaktuizinlab);
              ?>

              <script>
                // Load the Visualization API and the corechart package
                google.charts.load('current', {
                  'packages': ['corechart']
                });

                // Set a callback to run when the Google Visualization API is loaded
                google.charts.setOnLoadCallback(drawChart);

                //set value
                var bulanini = <?= $bulanini; ?>;

                // Callback function to create and populate the chart
                function drawChart() {
                  // Create the data table
                  var data = new google.visualization.DataTable();
                  data.addColumn('string', 'Surat');
                  data.addColumn('number', 'Waktu Proses');
                  data.addColumn({
                    role: 'style'
                  });
                  data.addRows([
                    ['<?= $suratpkl; ?>', <?= $rataWaktupkljam; ?>, 'Yellow'],
                    ['<?= $suratrekom; ?>', <?= $rataWakturekomjam; ?>, 'Blue'],
                    ['<?= $surataktif; ?>', <?= $rataWaktuaktifjam; ?>, 'Red'],
                    ['<?= $suratbaik; ?>', <?= $rataWaktubaikjam; ?>, 'Green'],
                    ['<?= $suratturunukt; ?>', <?= $rataWaktuturunuktjam; ?>, 'fuschia'],
                    ['<?= $suratringanukt; ?>', <?= $rataWakturinganuktjam; ?>, 'Gold'],
                    ['<?= $suratpenelitian; ?>', <?= $rataWaktupenelitianjam; ?>, 'Brown'],
                    ['<?= $suratobservasi; ?>', <?= $rataWaktuobservasijam; ?>, 'Silver'],
                    ['<?= $suratpengambilandata; ?>', <?= $rataWaktupengambilandatajam; ?>, 'Magenta'],
                    ['<?= $suratizinlab; ?>', <?= $rataWaktuizinlabjam; ?>, 'Orange']
                  ]);

                  // Set chart options
                  var options = {
                    chartArea: {
                      width: '90%'
                    },
                    legend: {
                      position: 'none'
                    }
                  };

                  // Instantiate and draw the chart
                  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                  chart.draw(data, options);
                }
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <hr>
  <a href="https://saintek.uin-malang.ac.id" class="btn btn-primary">KEMBALI</a>


  <script src="template/plugins/jquery/jquery.min.js"></script>
  <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
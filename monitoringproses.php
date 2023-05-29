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
          <h1 style="text-align: center;">Monitoring Proses</h1>
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
              <h3 class="card-title">Proses Surat Pengantar PKL</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
              </div>
            </div>
            <?php $no = 1; ?>
            <div class="card-body">
              <div id="chart_div"></div>

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
                $rataWaktu = floor($rataWaktu / 3600);
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
                $rataWaktu1 = floor($rataWaktu1 / 3600);
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
                $rataWaktu2 = floor($rataWaktu2 / 3600);
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

              //bulan ini -5
              $totalWaktu5 = 0;
              $jumlahData5 = 0;
              $bulanini5 = $bulanini - 5;
              if (($bulanini5) <= '0') {
                $bulanini5 = 12 - $bulanini5;
              }
              echo 'Bulan = ' . bln_indo($bulanini5) . '<br>';
              $qbulanini5 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini5' AND statussurat = 1");
              while ($dbulanini5 = mysqli_fetch_array($qbulanini5)) {
                $waktuawal5 = strtotime($dbulanini5['tanggal']);
                $waktuakhir5 = strtotime($dbulanini5['tglvalidasi3']);
                $selisihWaktu5 = $waktuakhir5 - $waktuawal5;
                $totalWaktu5 += $selisihWaktu5;
                $jumlahData5++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData5 . '<br>';
              if ($jumlahData5 > 0) {
                $rataWaktu5 = $totalWaktu5 / $jumlahData5;
                $rataWaktu5 = gmdate('H:i:s', $rataWaktu5); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu5 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini5) . ' : ' . $rataWaktu5;
              echo '<hr>';

              //bulan ini -6
              $totalWaktu6 = 0;
              $jumlahData6 = 0;
              $bulanini6 = $bulanini - 6;
              if (($bulanini6) <= '0') {
                $bulanini6 = 12 + $bulanini6;
              }
              echo 'Bulan = ' . bln_indo($bulanini6) . '<br>';
              $qbulanini6 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini6' AND statussurat = 1");
              while ($dbulanini6 = mysqli_fetch_array($qbulanini6)) {
                $waktuawal6 = strtotime($dbulanini6['tanggal']);
                $waktuakhir6 = strtotime($dbulanini6['tglvalidasi3']);
                $selisihWaktu6 = $waktuakhir6 - $waktuawal6;
                $totalWaktu6 += $selisihWaktu6;
                $jumlahData6++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData6 . '<br>';
              if ($jumlahData6 > 0) {
                $rataWaktu6 = $totalWaktu6 / $jumlahData6;
                $rataWaktu6 = gmdate('H:i:s', $rataWaktu6); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu6 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini6) . ' : ' . $rataWaktu6;
              echo '<hr>';

              //bulan ini -7
              $totalWaktu7 = 0;
              $jumlahData7 = 0;
              $bulanini7 = $bulanini - 7;
              if (($bulanini7) <= '0') {
                $bulanini7 = 12 + $bulanini7;
              }
              echo 'Bulan = ' . bln_indo($bulanini7) . '<br>';
              $qbulanini7 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini7' AND statussurat = 1");
              while ($dbulanini7 = mysqli_fetch_array($qbulanini7)) {
                $waktuawal7 = strtotime($dbulanini7['tanggal']);
                $waktuakhir7 = strtotime($dbulanini7['tglvalidasi3']);
                $selisihWaktu7 = $waktuakhir7 - $waktuawal7;
                $totalWaktu7 += $selisihWaktu7;
                $jumlahData7++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData7 . '<br>';
              if ($jumlahData7 > 0) {
                $rataWaktu7 = $totalWaktu7 / $jumlahData7;
                $rataWaktu7 = gmdate('H:i:s', $rataWaktu7); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu7 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini7) . ' : ' . $rataWaktu7;
              echo '<hr>';

              //bulan ini -8
              $totalWaktu8 = 0;
              $jumlahData8 = 0;
              $bulanini8 = $bulanini - 8;
              if (($bulanini8) <= '0') {
                $bulanini8 = 12 + $bulanini8;
              }
              echo 'Bulan = ' . bln_indo($bulanini8) . '<br>';
              $qbulanini8 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini8' AND statussurat = 1");
              while ($dbulanini8 = mysqli_fetch_array($qbulanini8)) {
                $waktuawal8 = strtotime($dbulanini8['tanggal']);
                $waktuakhir8 = strtotime($dbulanini8['tglvalidasi3']);
                $selisihWaktu8 = $waktuakhir8 - $waktuawal8;
                $totalWaktu8 += $selisihWaktu8;
                $jumlahData8++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData8 . '<br>';
              if ($jumlahData8 > 0) {
                $rataWaktu8 = $totalWaktu8 / $jumlahData8;
                $rataWaktu8 = gmdate('H:i:s', $rataWaktu8); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu8 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini8) . ' : ' . $rataWaktu8;
              echo '<hr>';

              //bulan ini -9
              $totalWaktu9 = 0;
              $jumlahData9 = 0;
              $bulanini9 = $bulanini - 9;
              if (($bulanini9) <= '0') {
                $bulanini9 = 12 + $bulanini9;
              }
              echo 'Bulan = ' . bln_indo($bulanini9) . '<br>';
              $qbulanini9 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini9' AND statussurat = 1");
              while ($dbulanini9 = mysqli_fetch_array($qbulanini9)) {
                $waktuawal9 = strtotime($dbulanini9['tanggal']);
                $waktuakhir9 = strtotime($dbulanini9['tglvalidasi3']);
                $selisihWaktu9 = $waktuakhir9 - $waktuawal9;
                $totalWaktu9 += $selisihWaktu9;
                $jumlahData9++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData9 . '<br>';
              if ($jumlahData9 > 0) {
                $rataWaktu9 = $totalWaktu9 / $jumlahData9;
                $rataWaktu9 = gmdate('H:i:s', $rataWaktu9); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu9 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini9) . ' : ' . $rataWaktu9;
              echo '<hr>';

              //bulan ini -10
              $totalWaktu10 = 0;
              $jumlahData10 = 0;
              $bulanini10 = $bulanini - 10;
              if (($bulanini10) <= '0') {
                $bulanini10 = 12 + $bulanini10;
              }
              echo 'Bulan = ' . bln_indo($bulanini10) . '<br>';
              $qbulanini10 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini10' AND statussurat = 1");
              while ($dbulanini10 = mysqli_fetch_array($qbulanini10)) {
                $waktuawal10 = strtotime($dbulanini10['tanggal']);
                $waktuakhir10 = strtotime($dbulanini10['tglvalidasi3']);
                $selisihWaktu10 = $waktuakhir10 - $waktuawal10;
                $totalWaktu10 += $selisihWaktu10;
                $jumlahData10++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData10 . '<br>';
              if ($jumlahData10 > 0) {
                $rataWaktu10 = $totalWaktu10 / $jumlahData10;
                $rataWaktu10 = gmdate('H:i:s', $rataWaktu10); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu10 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini10) . ' : ' . $rataWaktu10;
              echo '<hr>';

              //bulan ini -11
              $totalWaktu11 = 0;
              $jumlahData11 = 0;
              $bulanini11 = $bulanini - 11;
              if (($bulanini11) <= '0') {
                $bulanini11 = 12 + $bulanini11;
              }
              echo 'Bulan = ' . bln_indo($bulanini11) . '<br>';
              $qbulanini11 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE MONTH(tanggal) = '$bulanini11' AND statussurat = 1");
              while ($dbulanini11 = mysqli_fetch_array($qbulanini11)) {
                $waktuawal11 = strtotime($dbulanini11['tanggal']);
                $waktuakhir11 = strtotime($dbulanini11['tglvalidasi3']);
                $selisihWaktu11 = $waktuakhir11 - $waktuawal11;
                $totalWaktu11 += $selisihWaktu11;
                $jumlahData11++;
              }
              echo 'Jumlah pengajuan surat = ' . $jumlahData11 . '<br>';
              if ($jumlahData11 > 0) {
                $rataWaktu11 = $totalWaktu11 / $jumlahData11;
                $rataWaktu11 = gmdate('H:i:s', $rataWaktu11); // Format waktu dalam jam:menit:detik
              } else {
                $rataWaktu11 = 'Tidak ada data';
              }
              echo 'Rata-rata waktu proses bulan ' . bln_indo($bulanini11) . ' : ' . $rataWaktu11;
              echo '<hr>';
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
                  data.addColumn('string', 'Bulan');
                  data.addColumn('number', 'Jam');
                  data.addRows([
                    ['<?= bln_indo($bulanini); ?>', <?= $rataWaktu; ?>]
                  ]);

                  // Set chart options
                  var options = {
                    title: 'Rata - Rata Lama Proses Surat Pengantar PKL (dalam jam)',
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


  <script src="template/plugins/jquery/jquery.min.js"></script>
  <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
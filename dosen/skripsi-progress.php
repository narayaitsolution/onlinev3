<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "dosen") {
  header("location:../deauth.php");
}
$no = 1;
$tahun = date('Y');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SAINTEK e-Office</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
  <link rel="stylesheet" href="../template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Google Chart -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- grafik pengunjung fakultas -->
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);
    <?php
    //sempro
    $qsemprobiologi = mysqli_query($dbsurat, "SELECT * FROM sempro WHERE prodi='Biologi'");
    $jsemprobiologi = mysqli_num_rows($qsemprobiologi);
    $qsemprofisika = mysqli_query($dbsurat, "SELECT * FROM sempro WHERE prodi='Fisika'");
    $jsemprofisika = mysqli_num_rows($qsemprofisika);
    $qsemprokimia = mysqli_query($dbsurat, "SELECT * FROM sempro WHERE prodi='Kimia'");
    $jsemprokimia = mysqli_num_rows($qsemprokimia);
    $qsempromatematika = mysqli_query($dbsurat, "SELECT * FROM sempro WHERE prodi='Matematika'");
    $jsempromatematika = mysqli_num_rows($qsempromatematika);
    $qsemproti = mysqli_query($dbsurat, "SELECT * FROM sempro WHERE prodi='Teknik Informatika'");
    $jsemproti = mysqli_num_rows($qsemproti);
    $qsemprota = mysqli_query($dbsurat, "SELECT * FROM sempro WHERE prodi='Teknik Arsitektur'");
    $jsemprota = mysqli_num_rows($qsemprota);
    $qsempropii = mysqli_query($dbsurat, "SELECT * FROM sempro WHERE prodi='Perpustakaan dan Ilmu Informasi'");
    $jsempropii = mysqli_num_rows($qsempropii);
    $totalsempro = $jsemprobiologi + $jsemprofisika + $jsemprokimia + $jsempromatematika + $jsemproti + $jsemprota + $jsempropii;


    //kompre
    $qkomprebiologi = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE prodi='Biologi'");
    $jkomprebiologi = mysqli_num_rows($qkomprebiologi);
    $qkomprefisika = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE prodi='Fisika'");
    $jkomprefisika = mysqli_num_rows($qkomprefisika);
    $qkomprekimia = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE prodi='Kimia'");
    $jkomprekimia = mysqli_num_rows($qkomprekimia);
    $qkomprematematika = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE prodi='Matematika'");
    $jkomprematematika = mysqli_num_rows($qkomprematematika);
    $qkompreti = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE prodi='Teknik Informatika'");
    $jkompreti = mysqli_num_rows($qkompreti);
    $qkompreta = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE prodi='Teknik Arsitektur'");
    $jkompreta = mysqli_num_rows($qkompreta);
    $qkomprepii = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE prodi='Perpustakaan dan Ilmu Informasi'");
    $jkomprepii = mysqli_num_rows($qkomprepii);
    $totalkompre = $jkomprebiologi + $jkomprefisika + $jkomprekimia + $jkomprematematika + $jkompreti + $jkompreta + $jkomprepii;

    //semhas
    $qsemhasbiologi = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE prodi='Biologi'");
    $jsemhasbiologi = mysqli_num_rows($qsemhasbiologi);
    $qsemhasfisika = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE prodi='Fisika'");
    $jsemhasfisika = mysqli_num_rows($qsemhasfisika);
    $qsemhaskimia = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE prodi='Kimia'");
    $jsemhaskimia = mysqli_num_rows($qsemhaskimia);
    $qsemhasmatematika = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE prodi='Matematika'");
    $jsemhasmatematika = mysqli_num_rows($qsemhasmatematika);
    $qsemhasti = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE prodi='Teknik Informatika'");
    $jsemhasti = mysqli_num_rows($qsemhasti);
    $qsemhasta = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE prodi='Teknik Arsitektur'");
    $jsemhasta = mysqli_num_rows($qsemhasta);
    $qsemhaspii = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE prodi='Perpustakaan dan Ilmu Informasi'");
    $jsemhaspii = mysqli_num_rows($qsemhaspii);
    $totalsemhas = $jsemhasbiologi + $jsemhasfisika + $jsemhaskimia + $jsemhasmatematika + $jsemhasti + $jsemhasta + $jsemhaspii;

    //skripsi
    $qskripsibiologi = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE prodi='Biologi'");
    $jskripsibiologi = mysqli_num_rows($qskripsibiologi);
    $qskripsifisika = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE prodi='Fisika'");
    $jskripsifisika = mysqli_num_rows($qskripsifisika);
    $qskripsikimia = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE prodi='Kimia'");
    $jskripsikimia = mysqli_num_rows($qskripsikimia);
    $qskripsimatematika = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE prodi='Matematika'");
    $jskripsimatematika = mysqli_num_rows($qskripsimatematika);
    $qskripsiti = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE prodi='Teknik Informatika'");
    $jskripsiti = mysqli_num_rows($qskripsiti);
    $qskripsita = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE prodi='Teknik Arsitektur'");
    $jskripsita = mysqli_num_rows($qskripsita);
    $qskripsipii = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE prodi='Perpustakaan dan Ilmu Informasi'");
    $jskripsipii = mysqli_num_rows($qskripsipii);
    $totalskripsi = $jskripsibiologi + $jskripsifisika + $jskripsikimia + $jskripsimatematika + $jskripsiti + $jskripsita + $jskripsipii;

    ?>

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Progress', 'Biologi', 'Fisika', 'Kimia', 'Matematika', 'T. Informatika', 'T. Arsitektur', 'Perpustakaan Ilmu Informasi'],
        ['Sempro', '<?= $jsemprobiologi; ?>', <?= $jsemprofisika; ?>, <?= $jsemprokimia; ?>, <?= $jsempromatematika; ?>, <?= $jsemproti; ?>, <?= $jsemprota; ?>, <?= $jsempropii; ?>],
        ['Kompre', '<?= $jkomprebiologi; ?>', <?= $jkomprefisika; ?>, <?= $jkomprekimia; ?>, <?= $jkomprematematika; ?>, <?= $jkompreti; ?>, <?= $jkompreta; ?>, <?= $jkomprepii; ?>],
        ['Semhas', '<?= $jsemhasbiologi; ?>', <?= $jsemhasfisika; ?>, <?= $jsemhaskimia; ?>, <?= $jsemhasmatematika; ?>, <?= $jsemhasti; ?>, <?= $jsemhasta; ?>, <?= $jsemhaspii; ?>],
        ['Skripsi', '<?= $jskripsibiologi; ?>', <?= $jskripsifisika; ?>, <?= $jskripsikimia; ?>, <?= $jskripsimatematika; ?>, <?= $jskripsiti; ?>, <?= $jskripsita; ?>, <?= $jskripsipii; ?>]
      ]);

      var options = {
        chart: {
          //title: 'Data Progress Skripsi Mahasiswa'
        },
        bars: 'vertical' // Required for Material Bar Charts.
      };
      var chart = new google.charts.Bar(document.getElementById('barchart_material'));
      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  </script>

  <!-- grafik aktivitas mahasiswa di fakutlas -->
  <script type="text/javascript">
    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    <?php
    //ambil data
    $qkuliah = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE keperluan='Kuliah' AND DATE(tanggal) = CURDATE()");
    $jkuliah = mysqli_num_rows($qkuliah);
    $qpraktikum = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE keperluan='Praktikum' AND DATE(tanggal) = CURDATE()");
    $jpraktikum = mysqli_num_rows($qpraktikum);
    $qdosen = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE keperluan='Konsultasi' AND DATE(tanggal) = CURDATE()");
    $jdosen = mysqli_num_rows($qdosen);
    $qadmin = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE keperluan='Administrasi' AND DATE(tanggal) = CURDATE()");
    $jadmin = mysqli_num_rows($qadmin);
    $qskripsi = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE keperluan='Ujian Skripsi' AND DATE(tanggal) = CURDATE()");
    $jskripsi = mysqli_num_rows($qskripsi);
    $qtesis = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE keperluan='Ujian Tesis' AND DATE(tanggal) = CURDATE()");
    $jtesis = mysqli_num_rows($qtesis);
    $qpenelitian = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE keperluan='Penelitian' AND DATE(tanggal) = CURDATE()");
    $jpenelitian = mysqli_num_rows($qpenelitian);
    $qpertemuan = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE keperluan='Pertemuan' AND DATE(tanggal) = CURDATE()");
    $jpertemuan = mysqli_num_rows($qpertemuan);
    $qlain2 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE keperluan<>'Pertemuan' AND keperluan<>'Penelitian' AND keperluan<>'Ujian Tesis' AND keperluan<>'Ujian Skripsi' AND keperluan<>'Administrasi' AND keperluan<>'Konsultasi' AND keperluan<>'Praktikum' AND keperluan<>'Kuliah' AND DATE(tanggal) = CURDATE()");
    $jlain2 = mysqli_num_rows($qlain2);
    ?>

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Tujuan', 'Jumlah'],
        ['Kuliah', <?= $jkuliah; ?>],
        ['Praktikum', <?= $jpraktikum; ?>],
        ['Konsultasi', <?= $jdosen; ?>],
        ['Administrasi', <?= $jadmin; ?>],
        ['Ujian Skripsi', <?= $jskripsi; ?>],
        ['Ujian Tesis', <?= $jtesis; ?>],
        ['Penelitian', <?= $jpenelitian; ?>],
        ['Pertemuan', <?= $jpertemuan; ?>],
        ['Lain - Lain', <?= $jlain2; ?>],
      ]);

      var options = {
        is3D: true,
        legend: {
          position: 'none'
        },
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
      chart.draw(data, options);
    }
  </script>

  <!-- Grafik Prodi Paling banyak dikunjungi -->
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    <?php
    //ambil data
    $qsaintek = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='SAINTEK' AND DATE(tanggal) = CURDATE()");
    $jsaintek = mysqli_num_rows($qsaintek);
    $qbiologi = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='Biologi' AND DATE(tanggal) = CURDATE()");
    $jbiologi = mysqli_num_rows($qbiologi);
    $qfisika = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='Fisika' AND DATE(tanggal) = CURDATE()");
    $jfisika = mysqli_num_rows($qfisika);
    $qkimia = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='Kimia' AND DATE(tanggal) = CURDATE()");
    $jkimia = mysqli_num_rows($qkimia);
    $qinformatika = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='Teknik Informatika' AND DATE(tanggal) = CURDATE()");
    $jinfomatika = mysqli_num_rows($qinformatika);
    $qmatematika = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='Matematika' AND DATE(tanggal) = CURDATE()");
    $jmatematika = mysqli_num_rows($qmatematika);
    $qarsitektur = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='Teknik Arsitektur' AND DATE(tanggal) = CURDATE()");
    $jarsitektur = mysqli_num_rows($qarsitektur);
    $qperpus = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='Perpustakaan dan Ilmu Informasi' AND DATE(tanggal) = CURDATE()");
    $jperpus = mysqli_num_rows($qperpus);
    $qmit = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='Magister Informatika' AND DATE(tanggal) = CURDATE()");
    $jmit = mysqli_num_rows($qmit);
    $qmbio = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE prodi='Magister Biologi' AND DATE(tanggal) = CURDATE()");
    $jmbio = mysqli_num_rows($qmbio);
    ?>

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Program Studi', 'Fakultas', 'Biologi', 'Fisika', 'Kimia', 'Informatika', 'Matematika', 'Arsitektur', 'Perpustakaan', 'Magister TI', 'Magister Biologi'],
        ['Pengunjung', <?= $jsaintek; ?>, <?= $jbiologi; ?>, <?= $jfisika; ?>, <?= $jkimia; ?>, <?= $jinfomatika; ?>, <?= $jmatematika; ?>, <?= $jarsitektur; ?>, <?= $jperpus; ?>, <?= $jmit; ?>, <?= $jmbio; ?>]
      ]);

      var options = {
        legend: {
          position: 'top'
        },
        legend: {
          position: 'none'
        },
        bars: 'horizontal' // Required for Material Bar Charts.
      };

      var chart = new google.charts.Bar(document.getElementById('barchart_material2'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  </script>
</head>

<body class="hold-transition sidebar-mini text-sm">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php
    require('navbar.php');
    ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php
    require('sidebar.php');
    ?>
    <!-- ./Main Sidebar Container -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3>Dashboard</h3>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <?php
      if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "success") {
      ?>
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>UPDATE</strong> data berhasil
          </div>
      <?php
        }
      }
      ?>

      <!-- data pengunjung fakultas -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Seminar Proposal</span>
                  <span class="info-box-number"><?= $totalsempro; ?><small> orang</small></span>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-book-quran"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Ujian Komprehensif</span>
                  <span class="info-box-number"><?= $totalkompre; ?><small> orang</small></span>
                </div>
              </div>
            </div>

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-square-poll-vertical"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Seminar Hasil</span>
                  <span class="info-box-number"><?= $totalsemhas; ?><small> orang</small></span>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-graduation-cap"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Ujian Skripsi</span>
                  <span class="info-box-number"><?= $totalskripsi; ?><small> orang</small></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
        </div>
      </section>

      <!-- grafik pengunjung fakultas-->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <!-- Default box -->
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Progress Skripsi Mahasiswa per Program Studi</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.card-header -->
                <?php $no = 1; ?>
                <div class="card-body p-0">
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="card-body" id="barchart_material" style="height: 300px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-4">
              <!-- Default box -->
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Aktivitas Mahasiswa</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.card-header -->
                <?php $no = 1; ?>
                <div class="card-body p-0">
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div id="piechart_3d" style="height: 300px;"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-8">
              <!-- Default box -->
              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title">Grafik Pengunjung Prodi (total)</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.card-header -->
                <?php $no = 1; ?>
                <div class="card-body p-0">
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div id="barchart_material2" style="height:300px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- data suhu -->
      <?php
      $suhumin = 36;
      $suhumax = 36;
      $suhurata = 0;
      $suhutotal = 0;
      $qdata = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = CURDATE()");
      $jdata = mysqli_num_rows($qdata);
      $qsuhu = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = CURDATE()");
      while ($dsuhu = mysqli_fetch_array($qsuhu)) {
        $suhutotal = $suhutotal + $dsuhu['suhu'];
        //suhu minimal
        if ($dsuhu['suhu'] < $suhumin) {
          $suhumin = $dsuhu['suhu'];
          $mhsmin = $dsuhu['nama'];
        };
        //suhu maksimal
        if ($dsuhu['suhu'] > $suhumax) {
          $suhumax = $dsuhu['suhu'];
          $mhsmax = $dsuhu['nama'];
        }
      }
      $suhurata = $suhutotal / $jdata;
      ?>
      <!--
            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-12 col-sm-3 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Pengunjung</span>
                                    <span class="info-box-number"><?= $jdata; ?><small> orang</small></span>
                                </div>
                            </div>
                        </div>

                      
                        <div class="col-12 col-sm-3 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-thermometer-half"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Rata - Rata Suhu</span>
                                    <?php
                                    if ($suhurata > 36) {
                                    ?>
                                        <span class="info-box-number" style="color:green"><?= number_format($suhurata, 2); ?> <small><sup>o</sup>C</small></span>
                                    <?php
                                    } elseif ($suhurata > 37) {
                                    ?>
                                        <span class="info-box-number" style="color:orange"><?= number_format($suhurata, 2); ?><small><sup>o</sup>C</small></span>
                                    <?php
                                    } elseif ($suhurata > 38) {
                                    ?>
                                        <span class="info-box-number" style="color:red"><?= number_format($suhurata, 2); ?><small><sup>o</sup>C</small></span>
                                    <?php
                                    } else {
                                    ?>
                                        <span class="info-box-number" style="color:blue"><?= number_format($suhurata, 2); ?><small><sup>o</sup>C</small></span>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-12 col-sm-9 col-md-3">
                            <div class="info-box mb-3">
                                <?php
                                if ($suhumin <= 36) {
                                ?>
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-thermometer-quarter"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" style="color:blue">Suhu Minimal <?= number_format($suhumin, 1); ?> <small><sup>o</sup>C</small></span>
                                        <span class="info-box-number" style="color:blue"><small><?= $mhsmin; ?></small></span>
                                    </div>
                                <?php
                                } elseif ($suhumax <= 36.5) {
                                ?>
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thermometer-quarter"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" style="color:green">Suhu Minimal <?= number_format($suhumin, 1); ?> <small><sup>o</sup>C</small></span>
                                        <span class="info-box-number" style="color:green"><small><?= $mhsmin; ?></small></span>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thermometer-quarter"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" style="color:orange">Suhu Minimal <?= number_format($suhumin, 1); ?> <small><sup>o</sup>C</small></span>
                                        <span class="info-box-number" style="color:orange"><small><?= $mhsmin; ?></small></span>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-9 col-md-3">
                            <div class="info-box mb-3">
                                <?php
                                if ($suhumax <= 36.5) {
                                ?>
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thermometer-full"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" style="color:green">Suhu Maksimal <?= number_format($suhumax, 1); ?> <small><sup>o</sup>C</small></span>
                                        <span class="info-box-number" style="color:green"><small><?= $mhsmax; ?></small></span>
                                    </div>
                                <?php
                                } elseif ($suhumax <= 37) {
                                ?>
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thermometer-full"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" style="color:orange">Suhu Maksimal <?= number_format($suhumax, 1); ?> <small><sup>o</sup>C</small></span>
                                        <span class="info-box-number" style="color:orange"><small><?= $mhsmax; ?></small></span>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thermometer-full"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" style="color:red">Suhu Maksimal <?= number_format($suhumax, 1); ?> <small><sup>o</sup>C</small></span>
                                        <span class="info-box-number" style="color:red"><small><?= $mhsmax; ?></small></span>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
             -->
      <section class="content text-sm">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Daftar Pengunjung Fakultas</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>

                <?php $no = 1; ?>
                <div class="card-body p-0">
                  <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover text-sm">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>Nama</th>
                          <th>Tanggal</th>
                          <th>Prodi</th>
                          <th>Keperluan</th>
                          <th>Jam Masuk</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = DATE(NOW()) ORDER BY tanggal DESC");
                        while ($data = mysqli_fetch_array($query)) {
                          $nodata = $data['nodata'];
                          $tanggal = $data['tanggal'];
                          $nama = $data['nama'];
                          $prodi = $data['prodi'];
                          $suhu = $data['suhu'];
                          $keperluan = $data['keperluan'];
                          $jammasuk = $data['jammasuk'];
                          $jamkeluar = $data['jamkeluar'];
                        ?>
                          <tr>
                            <td><?= $no; ?></td>
                            <td><?= $nama; ?></td>
                            <td><?= tgl_indo($tanggal); ?></td>
                            <td><?= $prodi; ?></td>
                            <td><?= $keperluan; ?></td>
                            <td><?= tgljam_indo($jammasuk); ?></td>
                          </tr>
                        <?php
                          $no++;
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- footer -->
    <?php
    //include('footerdsn.php');
    ?>
    <!-- /.footer -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="../template/plugins/jquery/jquery.min.js"></script>
  <script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../template/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../template/plugins/jszip/jszip.min.js"></script>
  <script src="../template/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../template/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="../template/dist/js/adminlte.min.js"></script>


  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["excel", "pdf", "print"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": true,
        "responsive": true,
      });
    });
  </script>
</body>

</html>
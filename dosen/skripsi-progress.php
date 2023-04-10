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
//cek apakah pengelola skpi
$qpengelolaskpi = mysqli_query($dbsurat, "SELECT * FROM skpi_operator WHERE kode='$nip'");
$jpengelolaskpi = mysqli_num_rows($qpengelolaskpi);
if ($jpengelolaskpi = 0) {
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
              <h3>Progress Skripsi Mahasiswa</h3>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

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

      <!-- data progress mahasiswa -->
      <section class="content">
        <div class="container-fluid">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Data Progress Mahasiswa</h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered text-sm">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Program Studi</th>
                    <th class="text-center">Tahapan</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">NIM</th>
                    <th class="text-center">Tanggal Ujian</th>
                    <th class="text-center">Pembimbing 1</th>
                    <th class="text-center">Pembimbing 2</th>
                    <th class="text-center">Penguji 1</th>
                    <th class="text-center">Penguji 2</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  //sempro
                  $qprestasi = mysqli_query($dbsurat, "SELECT * FROM sempro ORDER BY tglujian DESC, nim ASC");
                  while ($data = mysqli_fetch_array($qprestasi)) {
                    $nodata = $data[0];
                    $nim = $data['nim'];
                    $prodi = $data['prodi'];
                    $pembimbing1 = $data['pembimbing1'];
                    $pembimbing2 = $data['pembimbing2'];
                    $penguji1 = $data['penguji1'];
                    $penguji2 = $data['penguji2'];
                    $tglujian = $data['tglujian'];
                  ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $prodi; ?></td>
                      <td>Seminar Proposal</td>
                      <td><?= namadosen($dbsurat, $nim); ?></td>
                      <td><?= $nim; ?></td>
                      <td><?= tgl_indo($tglujian); ?></td>
                      <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                      <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                      <td><?= namadosen($dbsurat, $penguji1); ?></td>
                      <td><?= namadosen($dbsurat, $penguji2); ?></td>
                    </tr>
                  <?php
                    $no++;
                  }
                  ?>
                  <?php
                  //kompre
                  $qprestasi = mysqli_query($dbsurat, "SELECT * FROM kompre ORDER BY tglujian DESC, nim ASC");
                  while ($data = mysqli_fetch_array($qprestasi)) {
                    $nodata = $data[0];
                    $nim = $data['nim'];
                    $prodi = $data['prodi'];
                    $pembimbing1 = $data['pembimbing1'];
                    $pembimbing2 = $data['pembimbing2'];
                    $penguji1 = $data['penguji1'];
                    $penguji2 = $data['penguji2'];
                    $tglujian = $data['tglujian'];
                  ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $prodi; ?></td>
                      <td>Ujian Komprehensif</td>
                      <td><?= namadosen($dbsurat, $nim); ?></td>
                      <td><?= $nim; ?></td>
                      <td><?= tgl_indo($tglujian); ?></td>
                      <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                      <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                      <td><?= namadosen($dbsurat, $penguji1); ?></td>
                      <td><?= namadosen($dbsurat, $penguji2); ?></td>
                    </tr>
                  <?php
                    $no++;
                  }
                  ?>
                  <?php
                  //semhas
                  $qprestasi = mysqli_query($dbsurat, "SELECT * FROM semhas ORDER BY tglujian DESC, nim ASC");
                  while ($data = mysqli_fetch_array($qprestasi)) {
                    $nodata = $data[0];
                    $nim = $data['nim'];
                    $prodi = $data['prodi'];
                    $pembimbing1 = $data['pembimbing1'];
                    $pembimbing2 = $data['pembimbing2'];
                    $penguji1 = $data['penguji1'];
                    $penguji2 = $data['penguji2'];
                    $tglujian = $data['tglujian'];
                  ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $prodi; ?></td>
                      <td>Seminar Hasil</td>
                      <td><?= namadosen($dbsurat, $nim); ?></td>
                      <td><?= $nim; ?></td>
                      <td><?= tgl_indo($tglujian); ?></td>
                      <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                      <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                      <td><?= namadosen($dbsurat, $penguji1); ?></td>
                      <td><?= namadosen($dbsurat, $penguji2); ?></td>
                    </tr>
                  <?php
                    $no++;
                  }
                  ?>
                  <?php
                  //skripsi
                  $qprestasi = mysqli_query($dbsurat, "SELECT * FROM skripsi ORDER BY tglujian DESC, nim ASC");
                  while ($data = mysqli_fetch_array($qprestasi)) {
                    $nodata = $data[0];
                    $nim = $data['nim'];
                    $prodi = $data['prodi'];
                    $pembimbing1 = $data['pembimbing1'];
                    $pembimbing2 = $data['pembimbing2'];
                    $penguji1 = $data['penguji1'];
                    $penguji2 = $data['penguji2'];
                    $tglujian = $data['tglujian'];
                  ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $prodi; ?></td>
                      <td>Ujian Skripsi</td>
                      <td><?= namadosen($dbsurat, $nim); ?></td>
                      <td><?= $nim; ?></td>
                      <td><?= tgl_indo($tglujian); ?></td>
                      <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                      <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                      <td><?= namadosen($dbsurat, $penguji1); ?></td>
                      <td><?= namadosen($dbsurat, $penguji2); ?></td>
                    </tr>
                  <?php
                    $no++;
                  }
                  ?>
                </tbody>
              </table>
              <br />
            </div>
          </div>
        </div>
      </section>

    </div>

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
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": true,
        "responsive": true,
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
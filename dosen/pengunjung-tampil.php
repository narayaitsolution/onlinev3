<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "dosen") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');
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
        //hari ini
        $tglhariini = date('Y-m-d');
        $qtotalhariini = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglhariini'");
        $jtotalhariini = mysqli_num_rows($qtotalhariini);
        $qmhshariini = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglhariini' AND hakakses='mahasiswa'");
        $jmhshariini = mysqli_num_rows($qmhshariini);
        $qtendikhariini = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglhariini' AND hakakses='tendik'");
        $jtendikhariini = mysqli_num_rows($qtendikhariini);
        $qdosenhariini = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglhariini' AND hakakses='dosen'");
        $jdosenhariini = mysqli_num_rows($qdosenhariini);
        $qtamuhariini = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglhariini' AND hakakses='tamu'");
        $jtamuhariini = mysqli_num_rows($qtamuhariini);

        //kemarin
        $tglkemarin = date('Y-m-d', strtotime("-1 days"));
        $qtotalkemarin = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin'");
        $jtotalkemarin = mysqli_num_rows($qtotalkemarin);
        $qmhskemarin = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin' AND hakakses='mahasiswa'");
        $jmhskemarin = mysqli_num_rows($qmhskemarin);
        $qtendikkemarin = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin' AND hakakses='tendik'");
        $jtendikkemarin = mysqli_num_rows($qtendikkemarin);
        $qdosenkemarin = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin' AND hakakses='dosen'");
        $jdosenkemarin = mysqli_num_rows($qdosenkemarin);
        $qtamukemarin = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin' AND hakakses='tamu'");
        $jtamukemarin = mysqli_num_rows($qtamukemarin);

        //kemarin2
        $tglkemarin2 = date('Y-m-d', strtotime("-2 days"));
        $qtotalkemarin2 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin2'");
        $jtotalkemarin2 = mysqli_num_rows($qtotalkemarin2);
        $qmhskemarin2 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin2' AND hakakses='mahasiswa'");
        $jmhskemarin2 = mysqli_num_rows($qmhskemarin2);
        $qtendikkemarin2 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin2' AND hakakses='tendik'");
        $jtendikkemarin2 = mysqli_num_rows($qtendikkemarin2);
        $qdosenkemarin2 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin2' AND hakakses='dosen'");
        $jdosenkemarin2 = mysqli_num_rows($qdosenkemarin2);
        $qtamukemarin2 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin2' AND hakakses='tamu'");
        $jtamukemarin2 = mysqli_num_rows($qtamukemarin2);

        //kemarin3
        $tglkemarin3 = date('Y-m-d', strtotime("-3 days"));
        $qtotalkemarin3 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin3'");
        $jtotalkemarin3 = mysqli_num_rows($qtotalkemarin3);
        $qmhskemarin3 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin3' AND hakakses='mahasiswa'");
        $jmhskemarin3 = mysqli_num_rows($qmhskemarin3);
        $qtendikkemarin3 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin3' AND hakakses='tendik'");
        $jtendikkemarin3 = mysqli_num_rows($qtendikkemarin3);
        $qdosenkemarin3 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin3' AND hakakses='dosen'");
        $jdosenkemarin3 = mysqli_num_rows($qdosenkemarin3);
        $qtamukemarin3 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin3' AND hakakses='tamu'");
        $jtamukemarin3 = mysqli_num_rows($qtamukemarin3);

        //kemarin4
        $tglkemarin4 = date('Y-m-d', strtotime("-4 days"));
        $qtotalkemarin4 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin4'");
        $jtotalkemarin4 = mysqli_num_rows($qtotalkemarin4);
        $qmhskemarin4 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin4' AND hakakses='mahasiswa'");
        $jmhskemarin4 = mysqli_num_rows($qmhskemarin4);
        $qtendikkemarin4 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin4' AND hakakses='tendik'");
        $jtendikkemarin4 = mysqli_num_rows($qtendikkemarin4);
        $qdosenkemarin4 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin4' AND hakakses='dosen'");
        $jdosenkemarin4 = mysqli_num_rows($qdosenkemarin4);
        $qtamukemarin4 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin4' AND hakakses='tamu'");
        $jtamukemarin4 = mysqli_num_rows($qtamukemarin4);

        //kemarin5
        $tglkemarin5 = date('Y-m-d', strtotime("-5 days"));
        $qtotalkemarin5 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin5'");
        $jtotalkemarin5 = mysqli_num_rows($qtotalkemarin5);
        $qmhskemarin5 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin5' AND hakakses='mahasiswa'");
        $jmhskemarin5 = mysqli_num_rows($qmhskemarin5);
        $qtendikkemarin5 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin5' AND hakakses='tendik'");
        $jtendikkemarin5 = mysqli_num_rows($qtendikkemarin5);
        $qdosenkemarin5 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin5' AND hakakses='dosen'");
        $jdosenkemarin5 = mysqli_num_rows($qdosenkemarin5);
        $qtamukemarin5 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin5' AND hakakses='tamu'");
        $jtamukemarin5 = mysqli_num_rows($qtamukemarin5);

        //kemarin6
        $tglkemarin6 = date('Y-m-d', strtotime("-6 days"));
        $qtotalkemarin6 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin6'");
        $jtotalkemarin6 = mysqli_num_rows($qtotalkemarin6);
        $qmhskemarin6 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin6' AND hakakses='mahasiswa'");
        $jmhskemarin6 = mysqli_num_rows($qmhskemarin6);
        $qtendikkemarin6 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin6' AND hakakses='tendik'");
        $jtendikkemarin6 = mysqli_num_rows($qtendikkemarin6);
        $qdosenkemarin6 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin6' AND hakakses='dosen'");
        $jdosenkemarin6 = mysqli_num_rows($qdosenkemarin6);
        $qtamukemarin6 = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = '$tglkemarin6' AND hakakses='tamu'");
        $jtamukemarin6 = mysqli_num_rows($qtamukemarin6);
        ?>

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Tanggal', 'Mahasiswa', 'Dosen', 'Staf', 'Tamu'],
                ['<?= tgl_indo($tglkemarin6); ?>', <?= $jmhskemarin6; ?>, <?= $jdosenkemarin6; ?>, <?= $jtendikkemarin6; ?>, <?= $jtamukemarin6; ?>],
                ['<?= tgl_indo($tglkemarin5); ?>', <?= $jmhskemarin5; ?>, <?= $jdosenkemarin5; ?>, <?= $jtendikkemarin5; ?>, <?= $jtamukemarin5; ?>],
                ['<?= tgl_indo($tglkemarin4); ?>', <?= $jmhskemarin4; ?>, <?= $jdosenkemarin4; ?>, <?= $jtendikkemarin4; ?>, <?= $jtamukemarin4; ?>],
                ['<?= tgl_indo($tglkemarin3); ?>', <?= $jmhskemarin3; ?>, <?= $jdosenkemarin3; ?>, <?= $jtendikkemarin3; ?>, <?= $jtamukemarin3; ?>],
                ['<?= tgl_indo($tglkemarin2); ?>', <?= $jmhskemarin2; ?>, <?= $jdosenkemarin2; ?>, <?= $jtendikkemarin2; ?>, <?= $jtamukemarin2; ?>],
                ['<?= tgl_indo($tglkemarin); ?>', <?= $jmhskemarin; ?>, <?= $jdosenkemarin; ?>, <?= $jtendikkemarin; ?>, <?= $jtamukemarin; ?>],
                ['<?= tgl_indo($tglhariini); ?>', <?= $jmhshariini; ?>, <?= $jdosenhariini; ?>, <?= $jtendikhariini; ?>, <?= $jtamuhariini; ?>]
            ]);

            var options = {
                chart: {
                    title: 'Data 1 minggu terakhir',
                    subtitle: 'Tanggal <?= $tglkemarin6; ?> s/d <?= $tglhariini; ?>',
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
            <!-- cari data pengunjung -->
            <?php
            $tglhariini = date('Y-m-d');
            $qtotal = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = CURDATE()");
            $jtotal = mysqli_num_rows($qtotal);
            $qmhs = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = CURDATE() AND hakakses='mahasiswa'");
            $jmhs = mysqli_num_rows($qmhs);
            $qtendik = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = CURDATE() AND hakakses='tendik'");
            $jtendik = mysqli_num_rows($qtendik);
            $qdosen = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = CURDATE() AND hakakses='dosen'");
            $jdosen = mysqli_num_rows($qdosen);
            $qtamu = mysqli_query($dbsurat, "SELECT * FROM masukfakultas WHERE DATE(tanggal) = CURDATE() AND hakakses='tamu'");
            $jtamu = mysqli_num_rows($qtamu);
            ?>
            <!-- data pengunjung fakultas -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pengunjung Hari Ini</span>
                                    <span class="info-box-number"><?= $jtotal; ?><small> orang</small></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-graduation-cap"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Mahasiswa Hari Ini</span>
                                    <span class="info-box-number"><?= $jmhs; ?><small> orang</small></span>
                                </div>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-secret"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Dosen & Staf Hari ini</span>
                                    <span class="info-box-number"><?= $jdosen + $jtendik; ?><small> orang</small></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tamu Hari Ini</span>
                                    <span class="info-box-number"><?= $jtamu; ?><small> orang</small></span>
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
                                    <h3 class="card-title">Grafik Pengunjung Fakultas SAINTEK</h3>
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

                        <!-- suhu -->
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

                        <!-- Suhu minimal -->
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

            <!-- data pengunjung fakultas -->
            <section class="content text-sm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
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
                                                    <th>Suhu</th>
                                                    <th>Tanggal</th>
                                                    <th>Prodi</th>
                                                    <th>Keperluan</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Keluar</th>
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
                                                        <td><?= $suhu; ?></td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                        <td><?= $prodi; ?></td>
                                                        <td><?= $keperluan; ?></td>
                                                        <td><?= tgljam_indo($jammasuk); ?></td>
                                                        <td><?= tgljam_indo($jamkeluar); ?></td>
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
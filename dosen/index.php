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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAINTEK e-Office</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../template/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- rekap atas -->
                <div class="container-fluid">
                    <div class="row">

                        <!-- pegunjung fakulas -->
                        <?php
                        if ($jabatan == 'wadek3' or $jabatan == 'wadek2') {
                        ?>
                            <div class="col col-sm col-md">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pengunjung Fakultas</span>
                                        <span class="info-box-number">
                                            <a href="pengunjung-tampil.php" class="btn btn-danger btn-sm btn-block">CEK</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <!-- pengajuan mahasiswa -->
                        <div class="col col-sm col-md">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Surat Mahasiswa</span>
                                    <span class="info-box-number">
                                        <a href="pengajuanmhs-tampil.php" class="btn btn-info btn-sm btn-block">CEK</a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- pengajuan bawahan -->
                        <?php
                        if ($jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
                        ?>
                            <div class="col col-sm col-md">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-envelope"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Surat Bawahan</span>
                                        <span class="info-box-number"><a href="pengajuanbawahan-tampil.php" class="btn btn-danger btn-sm btn-block">CEK</a></span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>

                        <!-- riwayat surat -->
                        <?php
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Riwayat Surat'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <div class="col col-sm col-md">
                                <div class="info-box mb">
                                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-envelope-open"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Riwayat Surat</span>
                                        <span class="info-box-number"><a href="datasurat-tampil.php" class="btn btn-secondary btn-sm btn-block">CEK</a></span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <!-- pengajuan pribadi -->
                        <div class="col col-sm col-md">
                            <div class="info-box mb">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-secret"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pengajuan Pribadi</span>
                                    <span class="info-box-number"><a href="pengajuansurat-tampil.php" class="btn btn-warning btn-sm btn-block">CEK</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php
        require('footer.php');
        ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /.control-sidebar -->
    </div>

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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
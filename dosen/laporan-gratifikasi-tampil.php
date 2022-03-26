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
$jab = array("dekan", "wadek1", "wadek2", "wadek3");

if (!in_array($jabatan, $jab)) {
    header("location:../deauth.php");
}


$kode = mysqli_real_escape_string($dbsurat, "$_GET[kode]");
$qijinujian = mysqli_query($dbsurat, "SELECT * FROM gratifikasi WHERE kode='$kode'");
$dijinujian = mysqli_fetch_array($qijinujian);
$tanggal = $dijinujian['tanggal'];
$penerima = $dijinujian['penerima'];
$jabatan = $dijinujian['jabatan'];
$tempat = $dijinujian['tempat'];
$waktu = $dijinujian['waktu'];
$uraian = $dijinujian['uraian'];
$bukti = $dijinujian['bukti'];
$status = $dijinujian['status'];
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
    <link rel="stylesheet" href="../template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
                </div>
            </section>

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Keluhan</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form action="ijinujian-simpan.php" enctype="multipart/form-data" method="POST" id="my-form">
                                            <div class="form-group row">
                                                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= tgljam_indo($tanggal); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="namamhs" class="col-sm-2 col-form-label">Penerima Gratifikasi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="penerima" value="<?= $penerima; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="prodimhs" class="col-sm-2 col-form-label">Jabatan Penerima Gratifikasi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="jabatan" value="<?= $jabatan; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="dosen" class="col-sm-2 col-form-label">Tempat Penerimaan Gratifikasi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="tempat" value="<?= $tempat; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="dosen" class="col-sm-2 col-form-label">Waktu Penerimaan Gratifikasi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="waktu" value="<?= tgljam_indo($waktu); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="dosen" class="col-sm-2 col-form-label">Gratifikasi yang diterima</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="uraian" value="<?= $uraian; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tglmulai" class="col-sm-2 col-form-label">Bukti</label>
                                                <div class="col-sm-10">
                                                    <a href="<?= $bukti; ?>"><img src="<?= $bukti; ?>" width="50%"></a>
                                                </div>
                                            </div>
                                            <hr>
                                            <form role="form" method="POST" id="my-form">
                                                <input type="hidden" name="kode" value="<?= $kode; ?>">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button name="aksi" id="btn-submit" value="setujui" type="submit" formaction="laporan-gratifikasi-simpan.php" class="btn btn-warning btn-block btn-lg" onclick="return confirm('Tindak Lanjuti ?')"> <i class="fa fa-check"></i> Tindak Lanjuti</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
    <?php
    //require('footer.php');
    ?>

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
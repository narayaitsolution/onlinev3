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
$tahun = date('Y');
$no = 1;
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
                                    <h3 class="card-title">Pengajuan Izin Work From Home</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form action="wfh-simpan.php" method="POST" id="my-form">
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-1</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        Tanggal<br />
                                                        <input type="date" class="form-control" id="tgl1" name="tgl1" value="<?= date('Y-m-d', strtotime('+1 day')); ?>" required>
                                                        Kegiatan<br />
                                                        <textarea class="form-control" rows="3" id="kegiatan1" name="kegiatan1" placeholder="uraian kegiatan WFH hari ke-1" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-2</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        Tanggal<br />
                                                        <input type="date" class="form-control" id="tgl2" name="tgl2">
                                                        Kegiatan<br />
                                                        <textarea class="form-control" rows="3" id="kegiatan2" name="kegiatan2" placeholder="uraian kegiatan WFH hari ke-2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-3</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        Tanggal<br />
                                                        <input type="date" class="form-control" id="tgl3" name="tgl3">
                                                        Kegiatan<br />
                                                        <textarea class="form-control" rows="3" id="kegiatan3" name="kegiatan3" placeholder="uraian kegiatan WFH hari ke-3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-4</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        Tanggal<br />
                                                        <input type="date" class="form-control" id="tgl4" name="tgl4">
                                                        Kegiatan<br />
                                                        <textarea class="form-control" rows="3" id="kegiatan4" name="kegiatan4" placeholder="uraian kegiatan WFH hari ke-4"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-5</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        Tanggal<br />
                                                        <input type="date" class="form-control" id="tgl5" name="tgl5">
                                                        Kegiatan<br />
                                                        <textarea class="form-control" rows="3" id="kegiatan5" name="kegiatan5" placeholder="uraian kegiatan WFH hari ke-5"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <button type="submit" id="btn-submit" class="btn btn-primary btn-block btn-lg" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fa fa-upload"></i> Ajukan</button>
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
    require('footer.php');
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
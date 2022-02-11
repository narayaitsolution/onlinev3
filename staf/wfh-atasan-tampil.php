<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['jabatan'] != "kabag-tu") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');
$tahun = date('Y');
$no = 1;
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
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

            <!-- ambil data -->
            <?php
            $qwfh = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE token='$token'");
            $dwfh = mysqli_fetch_array($qwfh);
            $namabawahan = $dwfh['nama'];
            $nipbawahan = $dwfh['nip'];
            $jabatanbawahan = $dwfh['jabatan'];
            $tglsurat = $dwfh['tglsurat'];
            $tglwfh1 = $dwfh['tglwfh1'];
            $kegiatan1 = $dwfh['kegiatan1'];
            $tglwfh2 = $dwfh['tglwfh2'];
            $kegiatan2 = $dwfh['kegiatan2'];
            $tglwfh3 = $dwfh['tglwfh3'];
            $kegiatan3 = $dwfh['kegiatan3'];
            $tglwfh4 = $dwfh['tglwfh4'];
            $kegiatan4 = $dwfh['kegiatan4'];
            $tglwfh5 = $dwfh['tglwfh5'];
            $kegiatan5 = $dwfh['kegiatan5'];

            ?>
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
                                        <div class="form-group row">
                                            <label for="namabawahan" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="namabawahan" name="namabawahan" value="<?= $namabawahan; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nipbawahan" class="col-sm-2 col-form-label">NIP</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nipbawahan" name="nipbawahan" value="<?= $nipbawahan; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $jabatanbawahan; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tlgpengajuan" class="col-sm-2 col-form-label">Tanggal Pengajuan Izin</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tglpengajuan" name="tglpengajuan" value="<?= tgljam_indo($tglsurat); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-1</label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    Tanggal<br />
                                                    <input type="text" class="form-control" id="tgl1" name="tgl1" value="<?= tgl_indo($tglwfh1); ?>" readonly>
                                                    Kegiatan<br />
                                                    <textarea class="form-control" rows="3" id="kegiatan1" name="kegiatan1" readonly><?= $kegiatan1; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (!empty($tglwfh2)) {
                                        ?>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-2</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        Tanggal<br />
                                                        <input type="text" class="form-control" id="tgl2" name="tgl2" value="<?= tgl_indo($tglwfh2); ?>" readonly>
                                                        Kegiatan<br />
                                                        <textarea class="form-control" rows="3" id="kegiatan2" name="kegiatan2" readonly><?= $kegiatan2; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($tglwfh3)) {
                                        ?>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-3</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        Tanggal<br />
                                                        <input type="text" class="form-control" id="tgl3" name="tgl3" value="<?= tgl_indo($tglwfh3); ?>" readonly>
                                                        Kegiatan<br />
                                                        <textarea class="form-control" rows="3" id="kegiatan3" name="kegiatan3" readonly><?= $kegiatan3; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($tglwfh4)) {
                                        ?>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-4</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        Tanggal<br />
                                                        <input type="text" class="form-control" id="tgl4" name="tgl4" value="<?= tgl_indo($tglwfh4); ?>" readonly>
                                                        Kegiatan<br />
                                                        <textarea class="form-control" rows="3" id="kegiatan4" name="kegiatan4" readonly><?= $kegiatan4; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($tglwfh5)) {
                                        ?>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">WFH Hari ke-5</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        Tanggal<br />
                                                        <input type="text" class="form-control" id="tgl5" name="tgl5" value="<?= tgl_indo($tglwfh5); ?>" readonly>
                                                        Kegiatan<br />
                                                        <textarea class="form-control" rows="3" id="kegiatan5" name="kegiatan5" readonly><?= $kegiatan5; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <hr>
                                        <form role="form" method="POST">
                                            <input type="hidden" name="token" value="<?= $token; ?>"></input>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button name="aksi" value="setujui" type="submit" formaction="wfh-atasan-setujui.php" class="btn btn-success btn-block btn-lg" onclick="return confirm('Apakah anda menyetujui pengajuan ini ?')"> <i class="fa fa-check"></i> Setujui</button>
                                                </div>
                                                <div class="col-6">
                                                    <button name="aksi" value="tolak" type="button" data-toggle="modal" data-target="#modal-tolak" class="btn btn-danger btn-block btn-lg"> <i class="fa fa-times"></i> Tolak</button>
                                                </div>
                                            </div>
                                            <!-- modal tolak -->
                                            <div class="modal fade" id="modal-tolak">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Alasan Penolakan</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <textarea class="form-control" rows="3" name="keterangan"></textarea>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                            <button name="aksi" value="tolak" type="submit" formaction="wfh-atasan-tolak.php" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menolak pengajuan ini ?')"> <i class="fa fa-times"></i> Tolak</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ./modal tolak-->
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
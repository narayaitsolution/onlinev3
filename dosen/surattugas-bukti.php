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

$token = mysqli_real_escape_string($dbsurat, "$_GET[token]");
$qst = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE token='$token'");
$dst = mysqli_fetch_array($qst);
$nodata = $dst['no'];
$tglsurat = $dst['tglsurat'];
$nipbawahan = $dst['nip'];
$namabawahan = $dst['nama'];
$golonganbawahan = $dst['golongan'];
$pangkatbawahan = $dst['pangkat'];
$jabatanbawahan = $dst['jabatan'];
$untuk = $dst['untuk'];
$tglpelaksanaan = $dst['tglpelaksanaan'];
$lampiran = $dst['lampiran'];

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
                                    <h3 class="card-title">Pengajuan Surat Tugas</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="tglsurat" class="col-sm-2 col-form-label">Tanggal Pengajuan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tglsurat" name="tglsurat" value="<?= tgljam_indo($tglsurat); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $namabawahan; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nip" name="nip" value="<?= $nipbawahan; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pangkat" class="col-sm-2 col-form-label">Pangkat</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="pangkat" name="pangkat" value="<?= $pangkatbawahan; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="golongan" class="col-sm-2 col-form-label">Golongan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="golongan" name="golongan" value="<?= $golonganbawahan; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $jabatanbawahan; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instansi" class="col-sm-2 col-form-label">Untuk</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="untuk" rows="5" readonly><?= $untuk; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instansi" class="col-sm-2 col-form-label">Tanggal Pelaksanaan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tglpelaksanaan" name="tglpelaksanaan" value="<?= tgl_indo($tglpelaksanaan); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instansi" class="col-sm-2 col-form-label">Template Laporan</label>
                                            <div class="col-sm-10">
                                                <a href="../doc/IzinOrangTua.docx" class="btn btn-primary" target="_blank"><i class="fa-solid fa-download"></i> Download Template</a>
                                            </div>
                                        </div>
                                        <form role="form" action="surattugas-bukti-upload.php" enctype="multipart/form-data" method="POST" id="my-form">
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">Bukti Pelaksanaan</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="bukti" class="form-control" accept=".pdf" required>
                                                    <small style="color: red;">Jenis file PDF ukuran maksimal 5MB</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <input type="hidden" name="token" value="<?= $token; ?>">
                                            <input type="hidden" name="nodata" value="<?= $nodata; ?>">
                                            <button name="aksi" id="btn-submit" value="upload" type="submit" class="btn btn-primary btn-block btn-lg" onclick="return confirm('Menguggah bukti pelaksanaan ?')"> <i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
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
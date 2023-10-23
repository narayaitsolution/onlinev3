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

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col">
                            <?php
                            if (isset($pesan)) {
                                $pesan = $_GET['pesan'];
                                if ($pesan = 'berhasil') {
                            ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>BERHASIL!!</strong> aksi data berhasil
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>GAGAL!!</strong> aksi gagal!!
                                    </div>
                            <?php
                                }
                            }
                            ?>
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
                                    <h3 class="card-title">Capaian Pembelajaran</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form action="skpi-simpan.php" method="POST">
                                            <div class="form-group row">
                                                <label for="prodi" class="col-sm-2 col-form-label">Capaian Pembelajaran</label>
                                                <div class="col-sm-10">
                                                    <select name="cpl" class="form-control">
                                                        <option value="Kemampuan Kerja">Kemampuan Kerja</option>
                                                        <option value="Penguasaan Pengetahuan">Penguasaan Pengetahuan</option>
                                                        <option value="Sikap Khusus">Sikap Khusus</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="indonesia" class="col-sm-2 col-form-label">Indonesia</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="indonesia">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="english" class="col-sm-2 col-form-label">English</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="english">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="sifat" class="col-sm-2 col-form-label">Sifat</label>
                                                <div class="col-sm-10">
                                                    <select name="sifat" class="form-control">
                                                        <option value="0" selected>Opsional</option>
                                                        <option value="1">Disarankan</option>
                                                        <option value="2">Wajib</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <button type="submit" class="btn btn-warning btn-lg btn-block" onclick="return confirm ('Simpan Data ?')">SIMPAN</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- capaian pembelajaran -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Data Capaian Pembelajaran</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <th width="5%" style="text-align: center;">No</th>
                                                    <th style="text-align: center;" width="10%">Capaian Pembelajaran</th>
                                                    <th style="text-align: center;" width="40%">Indonesia</th>
                                                    <th style="text-align: center;" width="40%">English</th>
                                                    <th style="text-align: center;" width="5%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $qcpl = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE jurusan='$prodi' ORDER BY cpl, indonesia");
                                                while ($dcpl = mysqli_fetch_array($qcpl)) {
                                                    $nodata = $dcpl['no'];
                                                    $cpl = $dcpl['cpl'];
                                                    $indonesia = $dcpl['indonesia'];
                                                    $english = $dcpl['english'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $cpl; ?></td>
                                                        <td><?= $indonesia; ?></td>
                                                        <td><?= $english; ?></td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-danger btn-sm" href="skpi-hapus.php?no=<?= $nodata; ?>" onclick="return confirm ('Yakin hapus data ini ?')">
                                                                <i class="fas fa-trashbin"></i> Hapus
                                                            </a>
                                                        </td>
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
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
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
if ($_SESSION['hakakses'] != "subsatker") {
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
                            <h1>Data Pengguna</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- notifications -->


            <!-- tabel pengajuan mahasiswa -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Pengajuan Mahasiswa -->
                        <div class="col-sm">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Data Pengguna</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-hover text-sm">
                                        <thead>
                                            <tr>
                                                <td style="text-align:center">No</td>
                                                <td style="text-align:center">Prodi</td>
                                                <td style="text-align:center">Nama</td>
                                                <td style="text-align:center">Golongan</td>
                                                <td style="text-align:center">Pangkat</td>
                                                <td style="text-align:center">No.HP</td>
                                                <td style="text-align:center">E-mail</td>
                                                <td style="text-align:center">Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- data pengguna-->
                                            <?php
                                            $qpengguna = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE hakakses<>'mahasiswa' ORDER BY prodi, nama");
                                            while ($dpengguna = mysqli_fetch_array($qpengguna)) {
                                                $nip = $dpengguna['nip'];
                                                $nama = $dpengguna['nama'];
                                                $golongan = $dpengguna['golongan'];
                                                $pangkat = $dpengguna['pangkat'];
                                                $nohp = $dpengguna['nohp'];
                                                $email = $dpengguna['email'];
                                                $prodi = $dpengguna['prodi'];
                                                $token = $dpengguna['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $prodi; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $golongan; ?></td>
                                                    <td><?= $pangkat; ?></td>
                                                    <td><?= $nohp; ?></td>
                                                    <td><?= $email; ?></td>
                                                    <td style="text-align: center;"><a href="pengguna-detail.php?token=<?= $token; ?>" class="btn btn-warning"><i class="fas fa-pencil"></i> Edit</a></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /data pengguna-->

                                        </tbody>
                                    </table>
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
                "buttons": ["excel", "pdf", "print"]
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
            $('#example3').DataTable({
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
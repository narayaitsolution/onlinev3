<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['jabatan'] != "bagkeu") {
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
    <title>SAINTEK e-Office - Rekap Delegasi</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="../template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
        <!-- ./Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3>Rekap. Delegasi</h3>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- data pengunjung fakultas -->
            <section class="content text-sm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Pengajuan Delegasi Disetujui tahun <?= $tahun; ?></h3>
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
                                                    <th width="5%">No</th>
                                                    <th>Prodi</th>
                                                    <th>Nama Ketua</th>
                                                    <th>NIM</th>
                                                    <th>No. HP</th>
                                                    <th>LPJ</th>
                                                    <th>No. KTP</th>
                                                    <th>Foto KTP</th>
                                                    <th>Foto KTM</th>
                                                    <th>Bank</th>
                                                    <th>No. Rekening</th>
                                                    <th>Foto Buku Tabungan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE statussurat =1 and year(tanggal) = '$tahun' ORDER BY tanggal DESC, prodi ASC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nim = $data['nim'];
                                                    $nama = $data['nama'];
                                                    $prodi = $data['prodi'];
                                                    $statussurat = $data['statussurat'];
                                                    $keterangan = $data['keterangan'];
                                                    $laporan = $data['laporan'];
                                                    $statuslaporan = $data['statuslaporan'];
                                                    $token = $data['token'];
                                                    //cari data upload
                                                    $qupload = mysqli_query($dbsurat, "SELECT * FROM delegasiupload WHERE token='$token'");
                                                    $dupload = mysqli_fetch_array($qupload);
                                                    $noktp = $dupload['noktp'];
                                                    $fotoktp = $dupload['fotoktp'];
                                                    $fotoktm = $dupload['fotoktm'];
                                                    $bank = $dupload['bank'];
                                                    $norek = $dupload['norek'];
                                                    $butab = $dupload['butab'];

                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $prodi; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $nim; ?></td>
                                                        <td><?= nohp($dbsurat, $nim); ?></td>
                                                        <?php
                                                        if (!empty($laporan)) {
                                                        ?>
                                                            <td style="text-align: center;"><a href="<?= $laporan; ?>" class="btn btn-info" target="_blank"><i class="fas fa-eye"></i></a></td>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td style="text-align: center;"><a href="#" class="btn btn-sm btn-secondary" onclick="alert ('Belum upload LPJ')"><span>&#10006;</span></a></td>
                                                        <?php
                                                        }
                                                        ?>
                                                        <td><?= $noktp; ?></td>
                                                        <?php
                                                        if (!empty($fotoktp)) {
                                                        ?>
                                                            <td style="text-align: center;"><a href="<?= $fotoktp; ?>" class="btn btn-info" target="_blank"><i class="fas fa-eye"></i></a></td>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td style="text-align: center;"><a href="#" class="btn btn-sm btn-secondary" onclick="alert ('Belum upload Foto KTP')"><span>&#10006;</span></a></td>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if (!empty($fotoktm)) {
                                                        ?>
                                                            <td style="text-align: center;"><a href="<?= $fotoktm; ?>" class="btn btn-info" target="_blank"><i class="fas fa-eye"></i></a></td>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td style="text-align: center;"><a href="#" class="btn btn-sm btn-secondary" onclick="alert ('Belum upload Foto KTM')"><span>&#10006;</span></a></td>
                                                        <?php
                                                        }
                                                        ?>
                                                        <td><?= $bank; ?></td>
                                                        <td><?= $norek; ?></td>
                                                        <?php
                                                        if (!empty($butab)) {
                                                        ?>
                                                            <td style="text-align: center;"><a href="<?= $butab; ?>" class="btn btn-info" target="_blank"><i class="fas fa-eye"></i></a></td>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td style="text-align: center;"><a href="#" class="btn btn-sm btn-secondary" onclick="alert ('Belum upload Foto Buku Tabungan')"><span>&#10006;</span></a></td>
                                                        <?php
                                                        }
                                                        ?>
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
                "buttons": ["excel"]
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
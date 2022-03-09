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
if ($_SESSION['hakakses'] != "dosen") {
    $sql = mysqli_query($dbsurat, "SELECT * FROM laboratorium WHERE kalab='$nip'");
    $jsql = mysqli_num_rows($sql);
    if ($jsql > 0) {
        header("location:../deauth.php");
    }
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

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $no = 1;
                            $statussurat = 0;
                            ?>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Data Pengguna Lab. Aktif </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped" id="example2">
                                        <thead>
                                            <tr>
                                                <th width="5%" style="text-align:center">No</th>
                                                <th style="text-align:center">Nama Mahasiswa</th>
                                                <th style="text-align:center">Tgl. Selesai</th>
                                                <th style="text-align:center">Tgl. Mulai</th>
                                                <th style="text-align:center">Aksi</th>
                                                <th style="text-align:center">Status</th>
                                                <th style="text-align:center">Laboratorium</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE statuspengajuan >= 1 AND validator1='$nip' ORDER BY statuspengajuan ASC, tglselesai ASC");
                                            while ($dsql = mysqli_fetch_array($sql)) {
                                                $namamhs = $dsql['nama'];
                                                $nimmhs = $dsql['nim'];
                                                $namalab = $dsql['namalab'];
                                                $dosen = $dsql['dosen'];
                                                $tglmulai = $dsql['tglmulai'];
                                                $tglselesai = $dsql['tglselesai'];
                                                $statuspengajuan = $dsql['statuspengajuan'];
                                                $token = $dsql['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $namamhs; ?></td>
                                                    <td><?= tgl_indo($tglselesai); ?></td>
                                                    <td><?= tgl_indo($tglmulai); ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinlab-kalab-penggunalab-detail.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <?php
                                                    if ($statuspengajuan == '1') {
                                                        $status = 'AKTIF';
                                                    } elseif ($statuspengajuan == '2') {
                                                        $status = 'DITOLAK';
                                                    } elseif ($statuspengajuan == '3') {
                                                        $status = 'SELESAI';
                                                    }
                                                    ?>
                                                    <td style="text-align: center;">
                                                        <?= $status; ?>
                                                    </td>
                                                    <td><?= $namalab; ?></td>
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
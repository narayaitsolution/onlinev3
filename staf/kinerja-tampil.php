<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "tendik") {
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
                            <h1>Kinerja</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- notifikasi -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <?php
                            if (isset($_GET['pesan'])) {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?= $_GET['pesan']; ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
            </section>
            <!-- ambil data statistik-->
            <?php
            //sesuai tusi
            $qjmlkinerjatusi = mysqli_query($dbsurat, "SELECT * FROM kinerja WHERE jeniskerja='TUSI'");
            $jjmlkinerjatusi = mysqli_num_rows($qjmlkinerjatusi);
            //tisak sesuai tusi
            $qjmlkinerjanontusi = mysqli_query($dbsurat, "SELECT * FROM kinerja WHERE jeniskerja='Non-TUSI'");
            $jjmlkinerjanontusi = mysqli_num_rows($qjmlkinerjanontusi);
            //tisak sesuai tusi
            $qjmlkinerjask = mysqli_query($dbsurat, "SELECT * FROM kinerja WHERE jeniskerja='SK'");
            $jjmlkinerjask = mysqli_num_rows($qjmlkinerjask);
            //jamkerja
            $totalkerja = 0;
            $qjamkerja = mysqli_query($dbsurat, "SELECT * FROM kinerja");
            while ($djamkerja = mysqli_fetch_array($qjamkerja)) {
                $lamakerja = $djamkerja['lamakerja'];
                $totalkerja = $totalkerja + $lamakerja;
            }
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?= $totalkerja; ?> <sup style="font-size: 20px">Jam</sup></h3>
                                    <p>Total Jam Kerja</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $jjmlkinerjatusi; ?> <sup style="font-size: 20px">Pekerjaan</sup></h3>
                                    <p>Sesuai TUSI</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-person-digging"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= $jjmlkinerjanontusi; ?> <sup style="font-size: 20px">Pekerjaan</sup></h3>
                                    <p>Diluar TUSI</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-person-digging"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $jjmlkinerjask; ?> <sup style="font-size: 20px">Pekerjaan</sup></h3>
                                    <p>Berdasarkan SK</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-person-digging"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <a href="kinerja-isi.php" class="btn btn-danger btn-lg btn-block"><i class="fa-solid fa-square-plus"></i> Tambah Data</a>
                        </div>
                    </div>
                    <hr>
                </div>
            </section>

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Rekap Kinerja</h3>
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
                                                    <td style="text-align:center">No</td>
                                                    <td style="text-align:center">Tanggal</td>
                                                    <td style="text-align:center">Kegiatan</td>
                                                    <td style="text-align:center">Lama Kegiatan (jam)</td>
                                                    <td style="text-align:center">Jenis Kegiatan</td>
                                                    <td style="text-align:center">Aksi</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query = mysqli_query($dbsurat, "SELECT * FROM kinerja WHERE nip='$nip' order by tglkerja desc");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $tglkerja = $data['tglkerja'];
                                                    $pekerjaan = $data['pekerjaan'];
                                                    $lamakerja = $data['lamakerja'];
                                                    $jeniskerja = $data['jeniskerja'];
                                                    $verifikasi = $data['verifikasi'];
                                                    $token = $data['token'];
                                                    if ($verifikasi == 0) {
                                                        $status = 'Belum di verifikasi';
                                                    } elseif ($verifikasi == 1) {
                                                        $status = 'Terverifikasi';
                                                    } elseif ($verifikasi == 2) {
                                                        $status = 'Ditolak atasan';
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= tgl_indo($tglkerja); ?></td>
                                                        <td><?= $pekerjaan; ?></td>
                                                        <td style="text-align: center;"><?= $lamakerja; ?></td>
                                                        <td style="text-align: center;"><?= $jeniskerja; ?></td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-info btn-sm" href="kinerja-detail.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Detail
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
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": ["excel", "pdf", "print", "colvis"]
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
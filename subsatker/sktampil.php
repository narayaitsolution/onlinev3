<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($nama != "Bagian Umum Fakultas") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');
$no = 1;
$tahun = date('Y');
$tahunlalu = date('Y', strtotime('-1 year'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAINTEK e-Office</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
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
                            <a href="index.php" class="btn btn-primary"><i class="nav-icon fas fa-arrow-left"></i> KEMBALI</a>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- cards -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Pengajuan SK narasumber -->
                        <?php
                        $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='narasumber' AND statussurat= 3 AND year(tanggal)=$tahun");
                        $jnarsum = mysqli_num_rows($qnarsum);
                        ?>
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $jnarsum; ?> <sup style="font-size: 20px">SK Narasumber</sup></h3>
                                    <p>Selesai</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Pengajuan SK Narasumber dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /pengajuan sk narasumber -->

                        <!-- Pengajuan SK panitia -->
                        <?php
                        $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='panitia' AND statussurat= 3 AND year(tanggal)=$tahun");
                        $jnarsum = mysqli_num_rows($qnarsum);
                        ?>
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?= $jnarsum; ?> <sup style="font-size: 20px">SK Panitia</sup></h3>
                                    <p>Selesai</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Pengajuan SK Narasumber dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- pengajuan sk panitia -->

                        <!-- Pengajuan SK peserta -->
                        <?php
                        $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk = 'peserta' AND statussurat= 3 AND year(tanggal)=$tahun");
                        $jnarsum = mysqli_num_rows($qnarsum);
                        ?>
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $jnarsum; ?> <sup style="font-size: 20px">SK Peserta</sup></h3>
                                    <p>Selesai</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Pengajuan SK Narasumber dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- penhajuan sk peserta-->
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Pengajuan Surat Mahasiswa -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Surat Mahasiswa Selesai Tahun <?= $tahun; ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped text-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No.</th>
                                    <th style="text-align: center;">Surat</th>
                                    <th style="text-align: center;">Tgl. Pengajuan</th>
                                    <th style="text-align: center;">Nama</th>
                                    <th style="text-align: center;">NIM</th>
                                    <th style="text-align: center;">Prodi</th>
                                    <th style="text-align: center;">Print</th>
                                    <th style="text-align: center;">Jumlah Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>

                                <!-- SK Narsum-->
                                <?php
                                $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='narasumber' AND statussurat= 1 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($qnarsum);
                                while ($data = mysqli_fetch_array($qnarsum)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $prodi = $data['prodi'];
                                    $surat = 'SK Narasumber';
                                    $verifikasi1 = $data['verifikasi1'];
                                    $verifikator1 = $data['verifikator1'];
                                    $verifikasi2 = $data['verifikasi2'];
                                    $verifikator2 = $data['verifikator2'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                    $cetak = $data['cetak'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= namadosen($dbsurat, $nim); ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td style="text-align: center;"><a class="btn btn-success btn-sm" href="sknarsum-bagumum-cetak.php?token=<?= $token; ?>" target="_blank">
                                                <i class="fas fa-print"></i> Cetak
                                            </a>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= $cetak; ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- SK Narsum -->

                                <!-- SK Panitia-->
                                <?php
                                $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='panitia' AND statussurat= 1 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($qnarsum);
                                while ($data = mysqli_fetch_array($qnarsum)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $prodi = $data['prodi'];
                                    $surat = 'SK Panitia';
                                    $verifikasi1 = $data['verifikasi1'];
                                    $verifikator1 = $data['verifikator1'];
                                    $verifikasi2 = $data['verifikasi2'];
                                    $verifikator2 = $data['verifikator2'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                    $cetak = $data['cetak'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= namadosen($dbsurat, $nim); ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td style="text-align: center;"><a class="btn btn-success btn-sm" href="skpanitia-bagumum-cetak.php?token=<?= $token; ?>" target="_blank">
                                                <i class="fas fa-print"></i> Cetak
                                            </a>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= $cetak; ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- SK Panitia -->

                                <!-- SK peserta-->
                                <?php
                                $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='peserta' AND statussurat= 1 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($qnarsum);
                                while ($data = mysqli_fetch_array($qnarsum)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $prodi = $data['prodi'];
                                    $surat = 'SK Peserta';
                                    $verifikasi1 = $data['verifikasi1'];
                                    $verifikator1 = $data['verifikator1'];
                                    $verifikasi2 = $data['verifikasi2'];
                                    $verifikator2 = $data['verifikator2'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                    $cetak = $data['cetak'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= namadosen($dbsurat, $nim); ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td style="text-align: center;"><a class="btn btn-success btn-sm" href="skpeserta-bagumum-cetak.php?token=<?= $token; ?>" target="_blank">
                                                <i class="fas fa-print"></i> Cetak
                                            </a>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= $cetak; ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- SK peserta -->

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

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
                "buttons": ["excel", "print"]
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
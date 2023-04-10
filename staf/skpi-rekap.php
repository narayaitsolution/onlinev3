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
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- notifications -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- pengajuan bawahan -->
                        <?php
                        if ($jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
                            $qwfh = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE verifikatorprodi='$nip' AND verifikasiprodi = 0 and verifikasifakultas=0");
                            $jwfh = mysqli_num_rows($qwfh);
                            $qst = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE validator1='$nip' AND validasi1 = 0 and validasi2=0");
                            $jst = mysqli_num_rows($qst);
                            $tbawahan = $jwfh + $jst;

                        ?>
                            <!--
                            <div class="col-lg col-6">
                                <a href="pengajuanbawahan-tampil.php">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><?= $tbawahan; ?> <sup style="font-size: 20px">surat</sup></h3>
                                            <p>Bawahan <br /> menunggu verifikasi</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-email"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        -->
                        <?php
                        }
                        ?>
                        <!-- ./col -->
                        <!--
                        <div class="col-lg col-6">
                            <a href="#">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>2 <sup style="font-size: 20px">surat</sup></h3>
                                        <p>Disposisi <br />masuk</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-android-mail"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    -->

                    </div>
                </div>
            </section>


            <!-- tabel disposisi surat -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        if ($jabatan == 'dekan' or $jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
                        ?>
                            <!-- Disposisi Surat -->
                            <div class="col-sm">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Disposisi Surat</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <?php $no = 1; ?>
                                    <div class="card-body">
                                        <table id="example4" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center">No</th>
                                                    <th style="text-align:center">Tanggal</th>
                                                    <th style="text-align:center">Laporan</th>
                                                    <th style="text-align:center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- laporan keluhan -->
                                                <?php
                                                $qlaporan = mysqli_query($dbsurat, "SELECT * FROM laporkan WHERE petugas='$nip' AND status=1");
                                                while ($dlaporan = mysqli_fetch_array($qlaporan)) {
                                                    $tanggal = $dlaporan['tanggal'];
                                                    $surat = 'Laporan Keluhan';
                                                    $kode = $dlaporan['kode'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><a class="btn btn-info btn-sm" href="disposisi-laporkan-tampil.php?kode=<?= $kode; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- tabel pengajuan bawahan & mahasiswa -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Pengajuan Mahasiswa -->
                        <?php
                        if ($jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
                        ?>
                            <!-- Pengajuan Bawahan -->
                            <div class="col-sm">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan Surat Bawahan</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <?php $no = 1; ?>
                                    <div class="card-body">
                                        <table id="example3" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <td style="text-align:center">No</td>
                                                    <td style="text-align:center">Surat</td>
                                                    <td style="text-align:center">Nama</td>
                                                    <td style="text-align:center">PRODI</td>
                                                    <td style="text-align:center">Aksi</td>
                                                    <td style="text-align:center">Tgl. Pengajuan</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- WFH as kaprodi -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE verifikatorprodi='$nip' AND verifikasiprodi = 0 and verifikasifakultas=0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Izin WFH';
                                                    $verifikasiprodi = $data['verifikasiprodi'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="wfh-atasan-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. WFH as kaprodi-->

                                                <!-- Surattugas as kaprodi -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE validator1='$nip' AND validasi1 = 0 and validasi2=0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Tugas';
                                                    $verifikasiprodi = $data['verifikasiprodi'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="#">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. surat tugas as kaprodi-->

                                                <!-- izin as atasan -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM izin WHERE validator1='$nip' AND validasi1=0 and validasi2 = 0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Izin';
                                                    $validasi2 = $data['validasi2'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="izin-atasan-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. izin as atasan-->


                                                <!-- izin as kabag-tu -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM izin WHERE validator2='$nip' AND validasi1=1 and validasi2 = 0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Izin';
                                                    $validasi2 = $data['validasi2'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="izin-kabag-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. izin as kabag tu-->

                                                <!-- izin as atasan -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE validator1='$nip' AND validasi1=0 and validasi2 = 0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Izin';
                                                    $validasi2 = $data['validasi2'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="cuti-atasan-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. izin as atasan-->

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- tabel pengajuan SKPI -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Pengajuan SKPI Mahasiswa</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <th width="5%" style="text-align: center;">No</th>
                                                    <th style="text-align: center;">Nama</th>
                                                    <th style="text-align: center;">NIM</th>
                                                    <th width="20%" style="text-align: center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE verifikasi1='1' AND verifikasi2='1' AND verifikasi3='1' GROUP BY nim ORDER BY tanggal");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $nim = $data['nim'];
                                                    $nama = $data['nama'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $nim; ?></td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-info btn-sm" href="skpi-detail.php?nim=<?= $nim; ?>">
                                                                <i class="fas fa-magnifying"></i> Detail
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
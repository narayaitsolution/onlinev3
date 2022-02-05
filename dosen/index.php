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

            <!-- notifications -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg col-6">
                            <a href="pengajuanmhs-tampil.php">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>150 <sup style="font-size: 20px">surat</sup></h3>
                                        <p>Surat Mahasiswa <br /> menunggu verifikasi</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-email"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- pengajuan bawahan -->
                        <?php
                        if ($jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
                            $qwfh = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE verifikatorprodi='$nip' AND verifikasiprodi = 0 and verifikasifakultas=0");
                            $jwfh = mysqli_num_rows($qwfh);
                            $qst = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE verifikatorprodi='$nip' AND verifikasiprodi = 0 and verifikasifakultas=0");
                            $jst = mysqli_num_rows($qst);
                            $tbawahan = $jwfh + $jst;

                        ?>
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
                        <?php
                        }
                        ?>
                        <!-- ./col -->
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

                        <?php
                        if ($jabatan == 'wadek3' or $jabatan == 'wadek2') {
                        ?>
                            <div class="col-lg col-6">
                                <a href="#">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>60 <sup style="font-size: 20px">orang</sup></h3>
                                            <p>Pengunjung Fakultas <br />masuk</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-ios-people"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
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
                                    <h3 class="card-title">Pengajuan Surat Pribadi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <th width="5%" style="text-align: center;">No</th>
                                                    <th width="20%" style="text-align: center;">Jenis Surat</th>
                                                    <th style="text-align: center;">Status Surat</th>
                                                    <th width="20%" style="text-align: center;">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Izin-->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM izin WHERE nip='$nip' ORDER BY tglizin1 DESC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $jenissurat = 'Surat Izin';
                                                    $keterangan = $data['keterangan'];
                                                    $verifikasiprodi = $data['verifikasiprodi'];
                                                    $verifikatorprodi = $data['verifikatorprodi'];

                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $jenissurat; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($verifikasiprodi == 0) {
                                                            ?>
                                                                menunggu verifikasi <?= namadosen($dbsurat, $verifikatorprodi); ?>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasiprodi == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="izin-cetak.php?nodata=<?php echo $nodata; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasiprodi == 2) {
                                                            ?>
                                                                Ditolak oleh <?= namadosen($dbsurat, $verifikatorprodi); ?>
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?= $keterangan; ?>
                                                            <br />
                                                            <?php
                                                            if ($verifikasiprodi <> 1) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="izin-hapus.php?nodata=<?php echo $nodata; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>

                                                <!-- pengajuan WFH-->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE nip='$nip' and year(tglsurat) = $tahun ORDER BY tglwfh1 DESC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tglwfh1 = $data['tglwfh1'];
                                                    $tglwfh2 = $data['tglwfh2'];
                                                    $tglwfh3 = $data['tglwfh3'];
                                                    $tglwfh4 = $data['tglwfh4'];
                                                    $tglwfh5 = $data['tglwfh5'];
                                                    $verifikasiprodi = $data['verifikasiprodi'];
                                                    $verifikatorprodi = $data['verifikatorprodi'];
                                                    $verifikasifakultas = $data['verifikasifakultas'];
                                                    $verifikatorfakultas = $data['verifikatorfakultas'];
                                                    $jenissurat = 'Izin WFH';
                                                    $keterangan = $data['keterangan'];
                                                    if (date($tglwfh5) != 0) {
                                                        $wfhselesai = $tglwfh5;
                                                    } else {
                                                        if (date($tglwfh4) != 0) {
                                                            $wfhselesai = $tglwfh4;
                                                        } else {
                                                            if (date($tglwfh3) != 0) {
                                                                $wfhselesai = $tglwfh3;
                                                            } else {
                                                                if (date($tglwfh2) != 0) {
                                                                    $wfhselesai = $tglwfh2;
                                                                }
                                                            }
                                                        }
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $jenissurat; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($verifikasiprodi == 0) {
                                                            ?>
                                                                menunggu verifikasi <?= namadosen($dbsurat, $verifikatorprodi); ?>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasiprodi == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="wfh-cetakrk.php?nodata=<?php echo $nodata; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak Rencana Kerja
                                                                </a>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasiprodi == 2) {
                                                            ?>
                                                                Ditolak oleh <?= namadosen($dbsurat, $verifikatorprodi); ?>
                                                            <?php
                                                            };
                                                            ?>

                                                            <?php
                                                            if ($verifikasifakultas == 0) {
                                                            ?>
                                                                Menunggu verifikasi <?= namadosen($dbsurat, $verifikatorfakultas); ?>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasifakultas == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="wfh-cetakst.php?nodata=<?php echo $nodata; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak Surat Tugas
                                                                </a>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasifakultas == 2) {
                                                            ?>
                                                                Ditolak oleh <?= namadosen($dbsurat, $verifikatorfakultas); ?>
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?= $keterangan; ?>
                                                            <br />
                                                            <?php
                                                            if ($verifikasifakultas <> 1) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="wfh-hapus.php?nodata=<?php echo $nodata; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            };
                                                            ?>
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
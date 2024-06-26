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

            <!-- Main content -->
            <section class="content">
                <!-- rekap atas -->
                <div class="container-fluid">
                    <div class="row">
                        <!-- pengajuan wfh -->
                        <?php
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Pengajuan WFH'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <div class="col col-sm col-md">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-home"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Work From Home</span>
                                        <span class="info-box-number">
                                            <a href="wfh-isi.php" class="btn btn-info btn-sm btn-block">Ajukan</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <!-- pengajuan izin -->
                        <?php
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Pengajuan Izin Cuti'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <div class="col col-sm col-md">
                                <div class="info-box mb">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-envelope"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Izin</span>
                                        <span class="info-box-number"><a href="izin-isi.php" class="btn btn-warning btn-sm btn-block">Ajukan</a></span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <!-- pengajuan cuti -->
                        <div class="col col-sm col-md">
                            <div class="info-box mb">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-envelope"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cuti</span>
                                    <span class="info-box-number"><a href="#" class="btn btn-success btn-sm btn-block" onclick="return alert ('Mohon maaf, sedang dalam proses pengembangan')">Ajukan</a></span>
                                </div>
                            </div>
                        </div>

                        <!-- pengajuan surat tugas -->
                        <?php
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Pengajuan Surat Tugas'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <div class="col col-sm col-md">
                                <div class="info-box mb">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-car"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Surat Tugas</span>
                                        <span class="info-box-number"><a href="#" class="btn btn-primary btn-sm btn-block" onclick="return alert ('Mohon maaf, sedang dalam proses pengembangan')">Ajukan</a></span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>


                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pengajuan Surat</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <th width="5%" style="text-align: center;">No</th>
                                                    <th width="10%" style="text-align: center;">Jenis Surat</th>
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
                                                $query = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE nip='$nip' ORDER BY tglwfh1 DESC");
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
        <!-- /.content-wrapper -->

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
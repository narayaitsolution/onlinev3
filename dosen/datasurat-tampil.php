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
    <link rel="stylesheet" href="../template/plugins/fontawesome-free/css/all.min.css">
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
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Pengajuan Surat Mahasiswa -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Pengajuan Surat Mahasiswa</h3>
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
                                    <th width="5%">No.</th>
                                    <th width="35%"> Surat</th>
                                    <th width="30%">Nama</th>
                                    <th width="15%">Prodi</th>
                                    <th width="10%">Status</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>

                                <!-- PKL Koordinator-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE validator1='$nip' OR validator2='$nip' OR validator3='$nip' ORDER BY prodi");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Ijin PKL';
                                    $validasi1 = $data['validasi1'];
                                    $validasi2 = $data['validasi2'];
                                    $validasi3 = $data['validasi3'];
                                    $keterangan = $data['keterangan'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td> <?php
                                                if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                                    echo 'Disetujui';
                                                } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                                    echo 'Ditolak';
                                                } else {
                                                    echo 'Proses';
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                            ?>
                                                <a class="btn btn-success btn-sm" href="../mahasiswa/pkl-cetak.php?nodata=<?= $nodata; ?>" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php
                                            } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                            ?>
                                                <a class="btn btn-danger btn-sm" onclick="return alert('<?= $keterangan; ?>')">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Dalam proses verifikasi')">
                                                    <i class="fas fa-spinner"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /. PKL koordinator-->

                                <!-- ijin lab -->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM ijinlab where validator0='$nip' OR validator1='$nip' OR validator2='$nip' OR validator3='$nip' ORDER BY prodi");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Ijin Penggunaan Laboratorium';
                                    $validasi0 = $data['validasi0'];
                                    $validasi1 = $data['validasi1'];
                                    $validasi2 = $data['validasi2'];
                                    $validasi3 = $data['validasi3'];
                                    $keterangan = $data['keterangan'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td> <?php
                                                if ($validasi0 == 1 and $validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                                    echo 'Disetujui';
                                                } elseif ($validasi0 == 2 or $validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                                    echo 'Ditolak';
                                                } else {
                                                    echo 'Proses';
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($validasi0 == 1 and $validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                            ?>
                                                <a class="btn btn-success btn-sm" href="../mahasiswa/ijinlab-cetak.php?nodata=<?= $nodata; ?>" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php
                                            } elseif ($validasi0 == 2 or $validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                            ?>
                                                <a class="btn btn-danger btn-sm" onclick="return alert('<?= $keterangan; ?>')">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Dalam proses verifikasi')">
                                                    <i class="fas fa-spinner"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /.ijin lab -->

                                <!-- ijin penelitian -->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE validator1='$nip' OR validator2='$nip' OR validator3='$nip' ORDER BY prodi");
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Ijin Penelitian';
                                    $validasi1 = $data['validasi1'];
                                    $validasi2 = $data['validasi2'];
                                    $validasi3 = $data['validasi3'];
                                    $keterangan = $data['keterangan'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td> <?php
                                                if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                                    echo 'Disetujui';
                                                } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                                    echo 'Ditolak';
                                                } else {
                                                    echo 'Proses';
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                            ?>
                                                <a class="btn btn-success btn-sm" href="../mahasiswa/ijinpenelitian-cetak.php?nodata=<?= $nodata; ?>" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php
                                            } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                            ?>
                                                <a class="btn btn-danger btn-sm" onclick="return alert('<?= $keterangan; ?>')">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Dalam proses verifikasi')">
                                                    <i class="fas fa-spinner"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /.ijin penelitian -->

                                <!-- peminjaman alat -->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM peminjamanalat WHERE validator1='$nip' OR validator2='$nip' OR validator3='$nip' ORDER BY prodi");
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Ijin Peminjaman Alat';
                                    $validasi1 = $data['validasi1'];
                                    $validasi2 = $data['validasi2'];
                                    $validasi3 = $data['validasi3'];
                                    $keterangan = $data['keterangan'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td> <?php
                                                if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                                    echo 'Disetujui';
                                                } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                                    echo 'Ditolak';
                                                } else {
                                                    echo 'Proses';
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                            ?>
                                                <a class="btn btn-success btn-sm" href="../mahasiswa/peminjamanalat-cetak.php?nodata=<?= $nodata; ?>" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php
                                            } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                            ?>
                                                <a class="btn btn-danger btn-sm" onclick="return alert('<?= $keterangan; ?>')">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Dalam proses verifikasi')">
                                                    <i class="fas fa-spinner"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /peminjaman alat -->

                                <!-- Observasi -->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE validator1='$nip' OR validator2='$nip' OR validator3='$nip' ORDER BY prodi");
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Ijin Observasi';
                                    $validasi1 = $data['validasi1'];
                                    $validasi2 = $data['validasi2'];
                                    $validasi3 = $data['validasi3'];
                                    $keterangan = $data['keterangan'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td> <?php
                                                if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                                    echo 'Disetujui';
                                                } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                                    echo 'Ditolak';
                                                } else {
                                                    echo 'Proses';
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                            ?>
                                                <a class="btn btn-success btn-sm" href="../mahasiswa/observasi-cetak.php?nodata=<?= $nodata; ?>" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php
                                            } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                            ?>
                                                <a class="btn btn-danger btn-sm" onclick="return alert('<?= $keterangan; ?>')">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Dalam proses verifikasi')">
                                                    <i class="fas fa-spinner"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /Observasi -->

                                <!-- pengambilandata -->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM pengambilandata WHERE validator1='$nip' OR validator2='$nip' OR validator3='$nip' ORDER BY prodi");
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $prodi = $data['prodi'];
                                    $nama = $data['nama'];
                                    $surat = 'Ijin Pengambilan Data';
                                    $validasi1 = $data['validasi1'];
                                    $validasi2 = $data['validasi2'];
                                    $validasi3 = $data['validasi3'];
                                    $keterangan = $data['keterangan'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td> <?php
                                                if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                                    echo 'Disetujui';
                                                } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                                    echo 'Ditolak';
                                                } else {
                                                    echo 'Proses';
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                            ?>
                                                <a class="btn btn-success btn-sm" href="../mahasiswa/pengambilandata-cetak.php?nodata=<?= $nodata; ?>" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php
                                            } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                            ?>
                                                <a class="btn btn-danger btn-sm" onclick="return alert('<?= $keterangan; ?>')">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Dalam proses verifikasi')">
                                                    <i class="fas fa-spinner"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /pengambilandata -->

                                <!-- Surat Keterangan -->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM suket WHERE validator1='$nip' OR validator2='$nip' OR validator3='$nip' ORDER BY prodi");
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $nim = $data['nim'];
                                    $prodi = $data['prodi'];
                                    $nama = $data['nama'];
                                    $surat = $data['jenissurat'];
                                    $validasi1 = $data['validasi1'];
                                    $validasi2 = $data['validasi2'];
                                    $validasi3 = $data['validasi3'];
                                    $keterangan = $data['keterangan'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td> <?php
                                                if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                                    echo 'Disetujui';
                                                } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                                    echo 'Ditolak';
                                                } else {
                                                    echo 'Proses';
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                            ?>
                                                <a class="btn btn-success btn-sm" href="../mahasiswa/suket-cetak.php?nodata=<?= $nodata; ?>" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php
                                            } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                            ?>
                                                <a class="btn btn-danger btn-sm" onclick="return alert('<?= $keterangan; ?>')">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Dalam proses verifikasi')">
                                                    <i class="fas fa-spinner"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /Surat Keterangan -->

                                <!-- SKPI -->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM skpi WHERE verifikator1='$nip' OR verifikator2='$nip' OR verifikator3='$nip' GROUP BY nim ORDER BY jurusan");
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $nim = $data['nim'];
                                    $prodi = $data['jurusan'];
                                    $nama = $data['nama'];
                                    $surat = 'SKPI';
                                    $verifikasi1 = $data['verifikasi1'];
                                    $verifikasi2 = $data['verifikasi2'];
                                    $verifikasi3 = $data['verifikasi3'];
                                    $keterangan = $data['keterangan'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td> <?php
                                                if ($verifikasi1 == 1 and $verifikasi2 == 1 and $verifikasi2 == 1) {
                                                    echo 'Disetujui';
                                                } elseif ($verifikasi1 == 2 or $verifikasi2 == 2 or $verifikasi2 == 2) {
                                                    echo 'Ditolak';
                                                } else {
                                                    echo 'Proses';
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($validasi1 == 1 and $validasi2 == 1 and $validasi3 == 1) {
                                            ?>
                                                <a class="btn btn-success btn-sm" href="../staf/skpi-tampil.php?nodata=<?= $nodata; ?>" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php
                                            } elseif ($validasi1 == 2 or $validasi2 == 2 or $validasi3 == 2) {
                                            ?>
                                                <a class="btn btn-danger btn-sm" onclick="return alert('<?= $keterangan; ?>')">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Dalam proses verifikasi')">
                                                    <i class="fas fa-spinner"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /SKPI -->
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
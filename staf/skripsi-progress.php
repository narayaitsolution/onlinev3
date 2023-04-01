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
if ($_SESSION['jabatan'] != "kasubag-akademik") {
    header("location:../deauth.php");
}
$no = 1;
$tahun = date('Y');
date_default_timezone_set('Asia/Jakarta');
$tglhariini = date('Y-m-d');
$tahunlalu = date('Y-m-d', strtotime('-1 year'));
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
                            <h3>Progress Skripsi Mahasiswa</h3>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- data progress mahasiswa -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Data Progress Mahasiswa</h3>
                        </div>
                        <div class="card-body">
                            <form action="skripsi-progress-export.php" method="post">
                                <div class="row">
                                    <div class="col">
                                        <label>Program Studi</label>
                                        <select name="prodi" class="form-control">
                                            <option value="semua">Semua</option>
                                            <?php
                                            $qprodi = mysqli_query($dbsurat, "SELECT DISTINCT namaprodi FROM prodi ORDER BY namaprodi");
                                            while ($dprodi = mysqli_fetch_array($qprodi)) {
                                                $prodi = $dprodi['namaprodi'];
                                            ?>
                                                <option value="<?= $prodi; ?>"><?= $prodi; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label>Tanggal Awal</label>
                                        <input type="date" class="form-control" value="<?= $tahunlalu; ?>" name="tglawal">
                                    </div>
                                    <div class="col">
                                        <label>Tanggal Akhir</label>
                                        <input type="date" class="form-control" value="<?= $tglhariini; ?>" name="tglakhir">
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-success btn-block btn-lg">Print</button>
                                </div>
                            </form>
                            <hr>
                            <table id="example1" class="table table-bordered text-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Program Studi</th>
                                        <th class="text-center">Tahapan</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">NIM</th>
                                        <th class="text-center">Tanggal Ujian</th>
                                        <th class="text-center">Pembimbing 1</th>
                                        <th class="text-center">Pembimbing 2</th>
                                        <th class="text-center">Penguji 1</th>
                                        <th class="text-center">Penguji 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    //sempro
                                    $qprestasi = mysqli_query($dbsurat, "SELECT * FROM sempro ORDER BY tglujian DESC, nim ASC");
                                    while ($data = mysqli_fetch_array($qprestasi)) {
                                        $nodata = $data[0];
                                        $nim = $data['nim'];
                                        $prodi = $data['prodi'];
                                        $pembimbing1 = $data['pembimbing1'];
                                        $pembimbing2 = $data['pembimbing2'];
                                        $penguji1 = $data['penguji1'];
                                        $penguji2 = $data['penguji2'];
                                        $tglujian = $data['tglujian'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $prodi; ?></td>
                                            <td>Seminar Proposal</td>
                                            <td><?= namadosen($dbsurat, $nim); ?></td>
                                            <td><?= $nim; ?></td>
                                            <td><?= tgl_indo($tglujian); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji1); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji2); ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                    <?php
                                    //kompre
                                    $qprestasi = mysqli_query($dbsurat, "SELECT * FROM kompre ORDER BY tglujian DESC, nim ASC");
                                    while ($data = mysqli_fetch_array($qprestasi)) {
                                        $nodata = $data[0];
                                        $nim = $data['nim'];
                                        $prodi = $data['prodi'];
                                        $pembimbing1 = $data['pembimbing1'];
                                        $pembimbing2 = $data['pembimbing2'];
                                        $penguji1 = $data['penguji1'];
                                        $penguji2 = $data['penguji2'];
                                        $tglujian = $data['tglujian'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $prodi; ?></td>
                                            <td>Ujian Komprehensif</td>
                                            <td><?= namadosen($dbsurat, $nim); ?></td>
                                            <td><?= $nim; ?></td>
                                            <td><?= tgl_indo($tglujian); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji1); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji2); ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                    <?php
                                    //semhas
                                    $qprestasi = mysqli_query($dbsurat, "SELECT * FROM semhas ORDER BY tglujian DESC, nim ASC");
                                    while ($data = mysqli_fetch_array($qprestasi)) {
                                        $nodata = $data[0];
                                        $nim = $data['nim'];
                                        $prodi = $data['prodi'];
                                        $pembimbing1 = $data['pembimbing1'];
                                        $pembimbing2 = $data['pembimbing2'];
                                        $penguji1 = $data['penguji1'];
                                        $penguji2 = $data['penguji2'];
                                        $tglujian = $data['tglujian'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $prodi; ?></td>
                                            <td>Seminar Hasil</td>
                                            <td><?= namadosen($dbsurat, $nim); ?></td>
                                            <td><?= $nim; ?></td>
                                            <td><?= tgl_indo($tglujian); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji1); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji2); ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                    <?php
                                    //skripsi
                                    $qprestasi = mysqli_query($dbsurat, "SELECT * FROM skripsi ORDER BY tglujian DESC, nim ASC");
                                    while ($data = mysqli_fetch_array($qprestasi)) {
                                        $nodata = $data[0];
                                        $nim = $data['nim'];
                                        $prodi = $data['prodi'];
                                        $pembimbing1 = $data['pembimbing1'];
                                        $pembimbing2 = $data['pembimbing2'];
                                        $penguji1 = $data['penguji1'];
                                        $penguji2 = $data['penguji2'];
                                        $tglujian = $data['tglujian'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $prodi; ?></td>
                                            <td>Ujian Skripsi</td>
                                            <td><?= namadosen($dbsurat, $nim); ?></td>
                                            <td><?= $nim; ?></td>
                                            <td><?= tgl_indo($tglujian); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji1); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji2); ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <br />
                        </div>
                    </div>
                </div>
            </section>

        </div>

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
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": true,
                "responsive": true,
                "buttons": ["excel", "pdf", "print"]
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
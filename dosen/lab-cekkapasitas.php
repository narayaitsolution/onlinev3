<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['nip'] != "198312132019031004") {
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
                            <h1>Dashboard</h1>
                        </div>
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
                                    <h3 class="card-title">Laboratorium</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-striped" width="80%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="5%">No</th>
                                                    <th class="text-center" width="20%">Program Studi</th>
                                                    <th class="text-center" width="20%">Laboratorium</th>
                                                    <th class="text-center" width="5%">Kapasitas</th>
                                                    <th class="text-center" width="40%">Kepala Lab.</th>
                                                    <th class="text-center" width="10%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM laboratorium ORDER BY jurusan");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $jurusan = $data['jurusan'];
                                                    $namalab = $data['namalab'];
                                                    $kalab = $data['kalab'];
                                                    $kapasitas = $data['kapasitas'];
                                                ?>
                                                    <tr>
                                                        <form method="POST" action="lab-cekkapasitas-ubah.php">
                                                            <td><?= $no; ?></td>
                                                            <td><?= $jurusan; ?></td>
                                                            <td><?= $namalab; ?></td>
                                                            <td><input type="number" class="form-control" name="kapasitas" value="<?= $kapasitas; ?>"></td>
                                                            <td>
                                                                <select name="dosen" class="form-control">
                                                                    <option value="<?= $kalab; ?>" selected><?= namadosen($dbsurat, $kalab); ?></option>
                                                                    <?php
                                                                    $qdosen = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE prodi like '%$jurusan' and hakakses='dosen' ORDER BY nama");
                                                                    while ($ddosen = mysqli_fetch_array($qdosen)) {
                                                                        $nama = $ddosen['nama'];
                                                                    ?>
                                                                        <option value="<?= $nama; ?>"><?= $nama; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <!--
                                                                <div class="search-box">
                                                                    <input type="text" autocomplete="off" class="form-control" placeholder="cari dosen" name="dosen" value="<?= namadosen($dbsurat, $kalab); ?>" required>
                                                                    <div class="result"></div>
                                                                </div>
                                                                -->
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="nodata" value="<?php echo $nodata; ?>" />
                                                                <button type="submit" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Ubah</button>
                                                            </td>
                                                        </form>
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
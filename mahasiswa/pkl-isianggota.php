<?php
session_start();
$user = $_SESSION['user'];
$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "mahasiswa") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');

$nodata = $_GET['nodata'];

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

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pengajuan Izin PKL / Magang</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form role="form" method="post" action="pkl-anggotatambah.php">
                                            <div class="form-group row">
                                                <label for="nimanggota" class="col-sm-2 col-form-label">NIM Anggota</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="nimanggota" name="nimanggota">
                                                    <input type="hidden" name="nodata" value="<?= $nodata; ?>" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- anggota pkl -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Anggota PKL</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form role="form" method="post" action="pkl-anggotatambah.php">
                                            <table id="example2" class="table table-bordered table-hover text-sm">
                                                <thead>
                                                    <th width="5%">No.</th>
                                                    <th>NIM</th>
                                                    <th>NAMA</th>
                                                    <th width="5%">Aksi</th>
                                                </thead>
                                                <tbody>
                                                    <!--baca status -->
                                                    <?php
                                                    if (isset($_GET['ket'])) {
                                                        $ket = mysqli_real_escape_string($dbsurat, $_GET['ket']);
                                                        if ($ket == 'notfound') {
                                                    ?>
                                                            <div class="alert alert-danger alert-dismissible fade show">
                                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                                <strong>ERROR!</strong> Data tidak ditemukan.
                                                            </div>
                                                        <?php
                                                        } elseif ($ket == 'used') {
                                                        ?>
                                                            <div class="alert alert-danger alert-dismissible fade show">
                                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                                <strong>ERROR!</strong> Anggota sudah terdaftar pada kelompok lain.
                                                            </div>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                    <!-- memasukkan pengusul -->
                                                    <?php
                                                    $qcari = mysqli_query($dbsurat, "SELECT * FROM pklanggota WHERE nimanggota = '$nim'");
                                                    $data = mysqli_num_rows($qcari);
                                                    if ($data == 0) {
                                                        $qtambah = "INSERT INTO pklanggota (nodata,nimketua, nimanggota, nama) 
																		values('$nodata','$nim','$nim','$nama')";
                                                        $sql =  mysqli_query($dbsurat, $qtambah);
                                                    }
                                                    ?>

                                                    <?php
                                                    $dataanggota = mysqli_query($dbsurat, "SELECT * FROM pklanggota WHERE nimketua='$nim'");
                                                    $no = 1;
                                                    while ($q = mysqli_fetch_array($dataanggota)) {
                                                        $id = $q['id'];
                                                        $nimanggota = $q['nimanggota'];
                                                        $nama = $q['nama'];
                                                        $telepon = $q['telepon'];
                                                    ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= $nimanggota; ?></td>
                                                            <td><?= $nama; ?></td>
                                                            <td>
                                                                <form action="pkl-anggotahapus.php" method="POST">
                                                                    <input type="hidden" name="id" value="<?= $id; ?>">
                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm ('Yakin menghapus anggota ini ?');"><i class="fa fa-trash"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="pkl-isilampiran.php?nodata=<?= $nodata; ?>" class="btn btn-success btn-block" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fa fa-file"></i> Isi Lampiran <i class="fa fa-arrow-right"></i></a>
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
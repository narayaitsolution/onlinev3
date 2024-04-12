<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
$user = $_SESSION['user'];
$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "mahasiswa") {
    header("location:../deauth.php");
}

$token = $_GET['token'];

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
                            <h1>Pengajuan SK Narasumber</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- alert -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col">

                            <?php
                            if (isset($_GET['hasil'])) {
                                if ($_GET['hasil'] == 'ok') {
                            ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        Penambahan narasumber berhasil
                                    </div>
                                <?php
                                } elseif ($_GET['hasil'] == 'notok') {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>ERROR!</strong> Penambahan narasumber gagal!!
                                    </div>
                            <?php
                                }
                            }
                            ?>
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
                                    <h3 class="card-title">Input Data Narasumber</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form role="form" method="post" id="my-form">
                                            <div class="form-group row">
                                                <label for="nimanggota" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="namanarsum" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nimanggota" class="col-sm-2 col-form-label">Materi</label>
                                                <div class="col">
                                                    <textarea class="form-control" name="materi" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nimanggota" class="col-sm-2 col-form-label">Jadwal</label>
                                                <div class="col">
                                                    <input type="datetime-local" class="form-control" name="jadwal" required>
                                                </div>
                                            </div>
                                            <input type="hidden" name="token" value="<?= $token; ?>" />
                                            <button type="submit" id="btn-submit" class="btn btn-info btn-lg btn-block" formaction="narasumber-data-simpan.php"><i class=" fa fa-plus"></i> Tambah</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- narasumber -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Narasumber</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form role="form" method="post" action="narasumber-data-simpan.php">
                                            <table id="example2" class="table table-bordered table-hover text-sm">
                                                <thead>
                                                    <th width="5%" style="text-align: center;">No.</th>
                                                    <th width="20%" style="text-align: center;">Nama</th>
                                                    <th style="text-align: center;">Materi</th>
                                                    <th style="text-align: center;">Jadwal</th>
                                                    <th width="5%" style="text-align: center;">Aksi</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $dataanggota = mysqli_query($dbsurat, "SELECT * FROM sknarsum WHERE token='$token'");
                                                    while ($q = mysqli_fetch_array($dataanggota)) {
                                                        $nama = $q['nama'];
                                                        $materi = $q['materi'];
                                                        $jadwal = $q['jadwal'];
                                                        $token = $q['token'];
                                                    ?>
                                                        <tr>
                                                            <td><?= $no; ?></td>
                                                            <td><?= $nama; ?></td>
                                                            <td><?= $materi; ?></td>
                                                            <td><?= tgljam_indo($jadwal); ?></td>
                                                            <td>
                                                                <form action="narasumber-data-hapus.php" method="POST" id="my-form">
                                                                    <input type="hidden" name="token" value="<?= $token; ?>">
                                                                    <input type="hidden" name="namanarsum" value="<?= $nama; ?>">
                                                                    <button type="submit" id="btn-submit" class="btn btn-danger btn-sm" onclick="return confirm ('Yakin menghapus narasumber ini ?');"><i class="fa fa-trash"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        $no++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <form action="narasumber-ajukan.php" method="POST" id="my-form">
                                                <input type="hidden" name="token" value="<?= $token; ?>">
                                                <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fa fa-upload"></i> AJUKAN SK</a>
                                            </form>
                                        </form>
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
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
                            <h1>Pengajuan SK Panitia</h1>
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
                            if (isset($_GET['ket'])) {
                                if ($_GET['ket'] == 'novaksin') {
                            ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>ERROR!</strong> Anggota belum upload bukti vaksin!!
                                    </div>
                                <?php
                                } elseif ($_GET['ket'] == 'notfound') {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>ERROR!</strong> data tidak ditemukan!!
                                    </div>
                                <?php
                                } elseif ($_GET['ket'] == 'notok') {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>ERROR!</strong> penambahan anggota gagal!!
                                    </div>
                                <?php
                                } elseif ($_GET['ket'] == 'ok') {
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>SUKSES</strong> penambahan anggota berhasil
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
                                    <h3 class="card-title">Input Data Panitia</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form role="form" method="post" action="skpanitia-data-simpan.php" id="my-form">
                                            <div class="form-group row">
                                                <label for="nimanggota" class="col-sm-2 col-form-label">NIM</label>
                                                <div class="col">
                                                    <input type="number" class="form-control" id="nimanggota" name="nimanggota" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="namaanggota" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" id="namaanggota" name="namaanggota" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="siepanitia" class="col-sm-2 col-form-label">Jabatan Kepanitiaan</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" id="siepanitia" name="siepanitia" required>
                                                    <small style="color: red;">Jabatan Kepanitiaan ditulis lengkap (contoh : Seksi Konsumsi)</small>
                                                </div>
                                            </div>
                                            <input type="hidden" name="token" value="<?= $token; ?>" />
                                            <button type="submit" id="btn-submit" class="btn btn-success btn-lg btn-block"> <i class="fa fa-users"></i> Tambah Panitia</button>
                                        </form>
                                        <hr>
                                        <form role="form" method="post" action="skpanitia-data-upload.php" enctype="multipart/form-data" id="my-form">
                                            <div class="form-group row">
                                                <label for="filepanitia" class="col-sm-2 col-form-label">Upload File</label>
                                                <div class="col-sm-8">
                                                    <input type="file" class="form-control" id="filepanitia" name="filepanitia" accept=".csv">
                                                    <small style="color: red;">Gunakan File Template (File CSV)</small>
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="../system/templatepanitia.csv" class="btn btn-info btn-block"><i class="fa fa-download"></i> Template File</a>
                                                </div>
                                            </div>
                                            <input type="hidden" name="token" value="<?= $token; ?>" />
                                            <button type="submit" id="btn-submit" class="btn btn-success btn-lg btn-block" onclick="return confirm ('Data Panitia akan dihapus dan diganti dengan data di file ini')"><i class="fa fa-upload"></i> Upload Daftar Panitia</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Panitia -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Panitia</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <th width="5%" style="text-align: center;">No.</th>
                                                <th width="20%" style="text-align: center;">Nama</th>
                                                <th style="text-align: center;">NIM</th>
                                                <th style="text-align: center;">Seksi Kepanitiaan</th>
                                                <th width="5%" style="text-align: center;">Aksi</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $datapanitia = mysqli_query($dbsurat, "SELECT * FROM skpanitia WHERE token='$token'");
                                                $jpanitia = mysqli_num_rows($datapanitia);
                                                $no = 1;
                                                while ($q = mysqli_fetch_array($datapanitia)) {
                                                    $nodata = $q['no'];
                                                    $nimpanitia = $q['nim'];
                                                    $namapanitia = $q['nama'];
                                                    $siepanitia = $q['siepanitia'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $namapanitia; ?></td>
                                                        <td><?= $nimpanitia; ?></td>
                                                        <td><?= $siepanitia; ?></td>
                                                        <td>
                                                            <form action="skpanitia-data-hapus.php" method="POST" id="my-form">
                                                                <input type="hidden" name="nodata" value="<?= $nodata; ?>">
                                                                <input type="hidden" name="token" value="<?= $token; ?>">
                                                                <button type="submit" id="btn-submit" class="btn btn-danger btn-sm" onclick="return confirm ('Yakin menghapus panitia ini ?');"><i class="fa fa-trash"></i></button>
                                                            </form>
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
                            <?php
                            if ($jpanitia > 0) {
                            ?>
                                <a href="skpanitia-ajukan.php?token=<?= $token; ?>" class="btn btn-success btn-block btn-lg" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fa fa-upload"></i> AJUKAN</a>
                            <?php
                            } else {
                            ?>
                                <a href="" class="btn btn-secondary btn-block btn-lg" onclick="alert ('Data panitia belum terisi!!')"> <i class="fa fa-upload"></i> AJUKAN</a>
                            <?php
                            }
                            ?>
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
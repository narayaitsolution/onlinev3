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
                    <div class="alert alert-warning alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>KETERANGAN : </strong><br />
                        <li><b>Pakta Integritas (<a href="../doc/paktaintegritaspkl.docx">klik disini </a>) di-upload oleh ketua kelompok</b></li>
                        <li>Pastikan seluruh anggota kelompok telah <b>meng-upload bukti vaksin terakhir melalui menu Profile User</b></li>
                    </div>
                </div>
            </section>

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if (isset($_GET['pesan'])) {
                                if ($_GET['pesan'] == "gagal") {
                            ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>ERROR!</strong> Upload file gagal
                                    </div>
                                <?php
                                } else if ($_GET['pesan'] == "filesize") {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>ERROR! </strong> ukuran file terlalu besar
                                    </div>
                                <?php
                                } else if ($_GET['pesan'] == "extention") {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>ERROR! </strong> format file harus JPG/JPEG
                                    </div>
                                <?php
                                } else if ($_GET['pesan'] == "registered") {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>ERROR!</strong> Anda telah terdaftar<br />
                                        Klik Lupa Password apabila anda lupa password
                                    </div>
                                <?php
                                } else if ($_GET['pesan'] == "success") {
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>BERHASIL! </strong> upload file berhasil
                                    </div>
                                <?php
                                } else if ($_GET['pesan'] == "noaccess") {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>ERROR! </strong> Anda tidak memiliki akses
                                    </div>
                                <?php
                                } else if ($_GET['pesan'] == "antibot") {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>ERROR! </strong> penjumlahan salah
                                    </div>
                            <?php
                                }
                            }
                            ?>
                            <?php
                            $no = 1;
                            $statussurat = 0;
                            ?>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Upload Lampiran </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped" id="example2">
                                        <thead>
                                            <tr>
                                                <th width="5%" style="text-align:center">No</th>
                                                <th style="text-align:center">Ketua Kelompok</th>
                                                <th style="text-align:center">Dokumen</th>
                                                <th style="text-align:center">Lampiran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE no='$nodata'");
                                            $dsql = mysqli_fetch_array($sql);
                                            $lampiran = $dsql['lampiran'];
                                            $nama = $dsql['nama'];
                                            $jenispkl = $dsql['jenispkl'];
                                            ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $nama; ?></td>
                                                <?php
                                                if ($lampiran == '') {
                                                    $namafile = '../system/noimage.gif';
                                                } else {
                                                    $statussurat = $statussurat + 1;
                                                    $namafile = $lampiran;
                                                }
                                                ?>
                                                <td align="center">
                                                    <a href="<?= $namafile; ?>" target="_blank"><img src="<?= $namafile; ?>" class="img-fluid" width="200px"></img></a>
                                                    <br />
                                                    <form action="pkl-isilampiran-upload.php" enctype="multipart/form-data" class="form-horizontal" method="post">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input type="file" name="fileToUpload" class="form-control" accept=".jpg,.jpeg">
                                                            </div>
                                                            <div class="col">
                                                                <button class="btn btn-block btn-primary btn-upload" name="fileToUpload" value="fileToUpload"><i class="fa fa-file-upload"></i> Upload </button>
                                                            </div>
                                                        </div>
                                                        <small style="color:blue"><i>*) Ukuran file maksimal 1MB format JPEG / JPG</i></small>
                                                        <input type="hidden" name="nodata" value="<?= $nodata; ?>">
                                                    </form>
                                                </td>
                                                <td>Pakta Integritas</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                    <?php
                                    if ($lampiran <> '') {
                                    ?>
                                        <a href="pkl-ajukan.php?nodata=<?= $nodata; ?>" class="btn btn-success btn-block" onclick="return confirm ('Saya menyatakan kebenaran data yang saya kirimkan')"><i class="fa fa-file-upload "></i> Ajukan Pengantar PKL </a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="#" class="btn btn-success btn-lg btn-block disabled"><i class="fa fa-check"></i> Ajukan Surat Pengantar </a>
                                    <?php
                                    }
                                    ?>
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
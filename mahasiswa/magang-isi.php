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
$tahun = date('Y');
$no = 1;

//jika sudah ijin magang tidak boleh ijin lagi
$qmagang = mysqli_query($dbsurat, "SELECT * FROM maganganggota WHERE nimanggota='$nim'");
$jmagang = mysqli_num_rows($qmagang);
if ($jmagang > 0) {
    header("location:index.php");
}
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

            <!-- alert bukti vaksin -->
            <?php
            $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip=$nim");
            $qdata = mysqli_fetch_array($quser);
            $buktivaksin = $qdata['buktivaksin'];
            if (empty($buktivaksin)) {
                echo "<script>alert('Segera upload bukti vaksin terakhir pada profil pengguna!!')</script>";
            }
            ?>

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pengajuan Izin Magang</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form action="magang-isitempat-simpan.php" method="POST" id="my-form">
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">Instansi Tujuan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="instansi" name="instansi" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tempatmagang" class="col-sm-2 col-form-label">Unit / Bagian</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tempatmagang" name="tempatmagang" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tglmulai" class="col-sm-2 col-form-label">Tgl. Mulai</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="tglmulai" name="tglmulai" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tglselesai" class="col-sm-2 col-form-label">Tgl. Selesai</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="tglselesai" name="tglselesai" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="magangmagang" class="col-sm-2 col-form-label">agang</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="magangmagang" name="magangmagang">
                                                        <option value="magang" selected>magang</option>
                                                        <option value="Magang">Magang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jenismagang" class="col-sm-2 col-form-label">Luring / Daring</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="jenismagang" name="jenismagang">
                                                        <option value="Offline">Luring / Offline</option>
                                                        <option value="Online" selected>Daring / Online</option>
                                                    </select>
                                                    <small style="color:red">
                                                        <li>Upload <b>Pakta Integritas (<a href="../doc/paktaintegritasmagang.docx">klik disini </a>) oleh ketua kelompok</b><br /></li>
                                                        <li>Pastikan seluruh peserta magang sudah meng-upload bukti vaksin pada <b>Profile pengguna</b></li>
                                                    </small>
                                                </div>
                                            </div>
                                            <hr>
                                            <button type="submit" id="btn-submit" class="btn btn-success btn-block" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fa fa-users"></i> Anggota Kelompok <i class="fa fa-arrow-right"></i></button>
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
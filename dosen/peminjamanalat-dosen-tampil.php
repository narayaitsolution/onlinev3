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
if ($_SESSION['hakakses'] != "dosen") {
    header("location:../deauth.php");
}

$tglsekarang = date('Y-m-d');
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

            <?php
            $token = mysqli_real_escape_string($dbsurat, $_GET['token']);
            $sql = mysqli_query($dbsurat, "SELECT * FROM peminjamanalat WHERE token='$token'");
            $dsql = mysqli_fetch_array($sql);
            $tanggal = $dsql['tanggal'];
            $nim = $dsql['nim'];
            $nama = $dsql['nama'];
            $prodi = $dsql['prodi'];
            $judulskripsi = $dsql['judulskripsi'];
            $dosen = $dsql['dosen'];
            $pimpinaninstansi = $dsql['pimpinaninstansi'];
            $instansi = $dsql['instansi'];
            $alamat = $dsql['alamat'];
            $namaalat = $dsql['namaalat'];
            $jumlahalat = $dsql['jumlahalat'];
            $tglmulai = $dsql['tglmulai'];
            $tglselesai = $dsql['tglselesai'];

            //cari bukti vaksin
            $qvaksin = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
            $dvaksin = mysqli_fetch_array($qvaksin);
            $buktivaksin = $dvaksin['buktivaksin'];
            ?>
            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Peminjaman Alat</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form action="peminjamanalat-simpan.php" method="POST" id="my-form">
                                            <div class="form-group row">
                                                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Pengajuan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= tgljam_indo($tanggal); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="judulskripsi" class="col-sm-2 col-form-label">Judul Skripsi / Penelitian</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="judulskripsi" name="judulskripsi" value="<?= $judulskripsi; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="dosen" class="col-sm-2 col-form-label">Dosen Pembimbing</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="dosen" name="dosen" value="<?= $dosen; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pimpinaninstansi" class="col-sm-2 col-form-label">Nama Pimpinan Instansi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="pimpinaninstansi" name="pimpinaninstansi" value="<?= $pimpinaninstansi; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">Instansi Tujuan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="instansi" name="instansi" value="<?= $instansi; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $alamat; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="namaalat" class="col-sm-2 col-form-label">Nama & Spesifikasi Alat</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="namaalat" name="namaalat" value="<?= $namaalat; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jumlahalat" class="col-sm-2 col-form-label">Jumlah Alat</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="jumlahalat" name="jumlahalat" value="<?= $jumlahalat; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tglmulai" class="col-sm-2 col-form-label">Tanggal mulai penelitian</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tglmulai" name="tglmulai" value="<?= tgl_indo($tglmulai); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tglselesai" class="col-sm-2 col-form-label">Tanggal selesai penelitian</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tglselesai" name="tglselesai" value="<?= tgl_indo($tglselesai); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tglselesai" class="col-sm-2 col-form-label">Bukti Vaksin</label>
                                                <div class="col-sm-10">
                                                    <a href="<?= $buktivaksin; ?>" target="_blank"><img src="<?= $buktivaksin; ?>" width="50%"></a>
                                                </div>
                                            </div>
                                            <hr>
                                            <form role="form" method="POST" id="my-form">
                                                <input type="hidden" name="token" value="<?= $token; ?>"></input>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button name="aksi" id="btn-submit" value="setujui" type="submit" formaction="peminjamanalat-dosen-setujui.php" class="btn btn-success btn-block btn-lg" onclick="return confirm('Apakah anda menyetujui pengajuan ini ?')"> <i class="fa fa-check"></i> Setujui</button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button name="aksi" value="tolak" type="button" data-toggle="modal" data-target="#modal-tolak" class="btn btn-danger btn-block btn-lg"> <i class="fa fa-times"></i> Tolak</button>
                                                    </div>
                                                </div>
                                                <!-- modal tolak -->
                                                <div class="modal fade" id="modal-tolak">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Alasan Penolakan</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <textarea class="form-control" rows="3" name="keterangan"></textarea>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                                <button name="aksi" value="tolak" type="submit" formaction="peminjamanalat-dosen-tolak.php" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menolak pengajuan ini ?')"> <i class="fa fa-times"></i> Tolak</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- ./modal tolak-->
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
    //require('footer.php');
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
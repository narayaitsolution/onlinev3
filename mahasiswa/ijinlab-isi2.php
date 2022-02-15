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
$tglsekarang = date('Y-m-d');
$tahun = date('Y');
$no = 1;

$token = $_GET['token'];

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
            <!-- ambil data -->
            <?php
            $qlampiran = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE token='$token'");
            $dlampiran = mysqli_fetch_array($qlampiran);
            $lampiran1 = $dlampiran['lamp1'];
            $lampiran4 = $dlampiran['lamp4'];
            $lampiran5 = $dlampiran['lamp5'];
            $lampiran7 = $dlampiran['lamp7'];
            $lampiran8 = $dlampiran['lamp8'];
            ?>
            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Upload Lampiran</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="instansi" class="col-sm-6 col-form-label">Screenshot <br />Hasil Pemeriksaan Screening Bebas COVID-19</label>
                                <div class="col-sm-6 text-center">
                                    <?php
                                    if (empty($lampiran1)) {
                                    ?>
                                        <img src="../system/noimage.gif" class="img-fluid img-thumbnail" width="50%">
                                    <?php
                                    } else {
                                    ?>
                                        <a href="<?= $lampiran1; ?>" target="_blank"><img src="<?= $lampiran1; ?>" class="img-fluid img-thumbnail" width="50%"></a>
                                    <?php
                                    }
                                    ?>
                                    <form method="POST" action="ijinlab-isi2-simpan.php" enctype="multipart/form-data" id="my-form">
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="file" name="filescreening" class="form-control" accept=".jpg,.jpeg">
                                            </div>
                                            <div class="col-4">
                                                <input type="hidden" name="lampiranke" value="1">
                                                <input type="hidden" name="token" value="<?= $token; ?>">
                                                <button type="submit" id="btn-submit" class="btn btn-primary btn-block" onclick="return confirm ('Dengan ini saya menyatakan kebenaran file yang saya upload')"><i class="fa-solid fa-file-arrow-up"></i> Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                    <small style="color:blue">Ukuran file maksimal 1MB format JPEG / JPG</small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="instansi" class="col-sm-6 col-form-label">Lampiran 4 <br />Surat pernyataan melaksanakan karantina mandiri</label>
                                <div class="col-sm-6 text-center">
                                    <?php
                                    if (empty($lampiran4)) {
                                    ?>
                                        <img src="../system/noimage.gif" class="img-fluid img-thumbnail" width="50%">
                                    <?php
                                    } else {
                                    ?>
                                        <a href="<?= $lampiran4; ?>" target="_blank"><img src="<?= $lampiran4; ?>" class="img-fluid img-thumbnail" width="50%"></a>
                                    <?php
                                    }
                                    ?>
                                    <form method="POST" action="ijinlab-isi2-simpan.php" enctype="multipart/form-data" id="my-form">
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="file" name="filescreening" class="form-control" accept=".jpg,.jpeg">
                                            </div>
                                            <div class="col-4">
                                                <input type="hidden" name="lampiranke" value="4">
                                                <input type="hidden" name="token" value="<?= $token; ?>">
                                                <button type="submit" id="btn-submit" class="btn btn-primary btn-block" onclick="return confirm ('Dengan ini saya menyatakan kebenaran file yang saya upload')"><i class="fa-solid fa-file-arrow-up"></i> Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                    <small style="color:blue">Ukuran file maksimal 1MB format JPEG / JPG</small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="instansi" class="col-sm-6 col-form-label">Lampiran 5 <br /> Surat pernyataan kesanggupan menerapkan protokol kesehatan</label>
                                <div class="col-sm-6 text-center">
                                    <?php
                                    if (empty($lampiran5)) {
                                    ?>
                                        <img src="../system/noimage.gif" class="img-fluid img-thumbnail" width="50%">
                                    <?php
                                    } else {
                                    ?>
                                        <a href="<?= $lampiran5; ?>" target="_blank"><img src="<?= $lampiran5; ?>" class="img-fluid img-thumbnail" width="50%"></a>
                                    <?php
                                    }
                                    ?>
                                    <form method="POST" action="ijinlab-isi2-simpan.php" enctype="multipart/form-data" id="my-form">
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="file" name="filescreening" class="form-control" accept=".jpg,.jpeg">
                                            </div>
                                            <div class="col-4">
                                                <input type="hidden" name="lampiranke" value="5">
                                                <input type="hidden" name="token" value="<?= $token; ?>">
                                                <button type="submit" id="btn-submit" class="btn btn-primary btn-block" onclick="return confirm ('Dengan ini saya menyatakan kebenaran file yang saya upload')"><i class="fa-solid fa-file-arrow-up"></i> Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                    <small style="color:blue">Ukuran file maksimal 1MB format JPEG / JPG</small>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group row">
                                <label for="instansi" class="col-sm-6 col-form-label">Lampiran 7 <br />Form kesediaan karantina mandiri selama 14 hari di Malang</label>
                                <div class="col-sm-6 text-center">
                                    <?php
                                    if (empty($lampiran7)) {
                                    ?>
                                        <img src="../system/noimage.gif" class="img-fluid img-thumbnail" width="50%">
                                    <?php
                                    } else {
                                    ?>
                                        <a href="<?= $lampiran7; ?>" target="_blank"><img src="<?= $lampiran7; ?>" class="img-fluid img-thumbnail" width="50%"></a>
                                    <?php
                                    }
                                    ?>
                                    <form method="POST" action="ijinlab-isi2-simpan.php" enctype="multipart/form-data" id="my-form">
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="file" name="filescreening" class="form-control" accept=".jpg,.jpeg">
                                            </div>
                                            <div class="col-4">
                                                <input type="hidden" name="lampiranke" value="7">
                                                <input type="hidden" name="token" value="<?= $token; ?>">
                                                <button type="submit" id="btn-submit" class="btn btn-primary btn-block" onclick="return confirm ('Dengan ini saya menyatakan kebenaran file yang saya upload')"><i class="fa-solid fa-file-arrow-up"></i> Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                    <small style="color:blue">Ukuran file maksimal 1MB format JPEG / JPG</small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="instansi" class="col-sm-6 col-form-label">Lampiran 8 <br />Surat persetujuan orang tua bermaterai</label>
                                <div class="col-sm-6 text-center">
                                    <?php
                                    if (empty($lampiran8)) {
                                    ?>
                                        <img src="../system/noimage.gif" class="img-fluid img-thumbnail" width="50%">
                                    <?php
                                    } else {
                                    ?>
                                        <a href="<?= $lampiran8; ?>" target="_blank"><img src="<?= $lampiran8; ?>" class="img-fluid img-thumbnail" width="50%"></a>
                                    <?php
                                    }
                                    ?>
                                    <form method="POST" action="ijinlab-isi2-simpan.php" enctype="multipart/form-data" id="my-form">
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="file" name="filescreening" class="form-control" accept=".jpg,.jpeg">
                                            </div>
                                            <div class="col-4">
                                                <input type="hidden" name="lampiranke" value="8">
                                                <input type="hidden" name="token" value="<?= $token; ?>">
                                                <button type="submit" id="btn-submit" class="btn btn-primary btn-block" onclick="return confirm ('Dengan ini saya menyatakan kebenaran file yang saya upload')"><i class="fa-solid fa-file-arrow-up"></i> Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                    <small style="color:blue">Ukuran file maksimal 1MB format JPEG / JPG</small>
                                </div>
                            </div>
                            <hr>
                            <form action="ijinlab-ajukan.php" method="POST" id="my-form">
                                <input type="hidden" name="token" value="<?= $token; ?>">
                                <?php
                                if (empty($lampiran1) or empty($lampiran4) or empty($lampiran5) or empty($lampiran7) or empty($lampiran8)) {
                                ?>
                                    <button type="submit" id="btn-submit" class="btn btn-lg btn-block btn-primary" disabled><i class="fa-solid fa-file-arrow-up"></i> Ajukan</button>
                                <?php
                                } else {
                                ?>
                                    <button type="submit" id="btn-submit" class="btn btn-lg btn-block btn-primary" id="btn-submit" onclick="return confirm ('Dengan ini saya menyatakan kebenaran file yang saya upload')"><i class="fa-solid fa-file-arrow-up"></i> Ajukan</button>
                                <?php
                                }
                                ?>
                            </form>
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
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
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
if ($_SESSION['jabatan'] != "bagumum") {
    header("location:../deauth.php");
}
$tglsekarang = date('Y-m-d');
$tahun = date('Y');
$bulan = date('m');
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        table,
        th,
        td {
            border: none;
            font-family: Cambria,
                'MyCambria',
                serif;

        }

        @font-face {
            font-family: 'MyCambria';
            src: url('../system/cambria.ttf') format('truetype');
        }
    </style>
</head>

<body class="hold-transition sidebar-mini text-sm">
    <div class="wrapper">
        <?php
        require('navbar.php');
        require('sidebar.php');
        ?>

        <div class="content-wrapper">
            <!-- ambil data SK dari database -->
            <?php
            $token = mysqli_real_escape_string($dbsurat, $_GET['token']);
            $qsk = mysqli_query($dbsurat, "SELECT * FROM sk WHERE token='$token'");
            $dsk = mysqli_fetch_array($qsk);
            $tanggal = $dsk['tanggal'];
            $prodi = $dsk['prodi'];
            $nimmhs = $dsk['nim'];
            $jenissk = $dsk['jenissk'];
            $namakegiatan = strtoupper($dsk['namakegiatan']);
            $ormas = $dsk['ormas'];
            $tema = $dsk['tema'];
            $nosurat = $dsk['nosurat'];
            $pembiayaan = $dsk['pembiayaan'];
            $verifikator1 = $dsk['verifikator1'];
            $verifikasi1 = $dsk['verifikasi1'];
            $tglverifikasi1 = $dsk['tglverifikasi1'];
            $keterangan = $dsk['keterangan'];
            $token = $dsk['token'];
            ?>

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <!--alert-->
                <?php
                if (isset($_GET['pesan'])) {
                    $pesan = $_GET['pesan'];
                    $hasil = $_GET['hasil'];
                    if ($hasil = 'ok') {
                ?>
                        <script>
                            swal('BERHASIL!', '<?= $pesan; ?>', 'success');
                        </script>

                    <?php
                    } else {
                    ?>
                        <script>
                            swal('ERROR!', '<?= $pesan; ?>', 'error');
                        </script>
                <?php
                    }
                }
                ?>
                <!-- Pengajuan Surat Mahasiswa -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Upload SK TTE</h3>
                    </div>
                    <div class="card-body">
                        <form action="sknarsum-bagumum-upload.php" method="post" enctype="multipart/form-data" id="my-form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">No. SK</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nosk" value="<?= $keterangan; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Program Studi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="prodi" value="<?= $prodi; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">ORMAWA</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="ormawa" value="<?= $ormas; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama Kegiatan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="kegiatan" value="<?= $namakegiatan; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tema</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="kegiatan" rows="2" readonly><?= $tema; ?></textarea>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Download SK</label>
                                <div class="col-sm-10">
                                    <a href="skpeserta-bagumum-cetak.php?token=<?= $token; ?>" class="btn btn-lg btn-success" target="_blank"><i class="fas fa-download"></i> Download</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">File SK TTE</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="sktte" accept=".pdf" required>
                                    <small style="color: red;">File SK yang telah ditanda tangani secara elektronik</small>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="<?= $token; ?>">
                            <div class="row">
                                <div class="col-2">
                                    <a href="index.php" class="btn btn-lg btn-block btn-secondary"><i class="fas fa-backward"></i> Kembali</a>
                                </div>
                                <div class="col-10">
                                    <button type="submit" class="btn btn-lg btn-block btn-success" onclick="return confirm('Yakin mengunggah file ini ?')"><i class="fas fa-file-upload"></i> UPLOAD</button>
                                </div>
                            </div>
                        </form>
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
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <!-- disable button once it clicked -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#my-form").submit(function(e) {
                $("#btn-submit").attr("disabled", true);
                return true;
            });
        });
    </script>
</body>

</html>
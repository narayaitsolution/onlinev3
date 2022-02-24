<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "dosen") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');
$tahun = date('Y');
$no = 1;

$nim = mysqli_real_escape_string($dbsurat, "$_GET[nim]");
$qmhs = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE nim='$nim' AND verifikator1='$nip'");
$data = mysqli_fetch_array($qmhs);
$nosurat = $data['no'];
$namamhs = $data['nama'];
$nimmhs = $data['nim'];
$prodimhs = $data['prodi'];

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
                                    <h3 class="card-title">Pengajuan Surat Keterangan Pendamping Ijazah</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $namamhs; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nim" name="nim" value="<?= $nimmhs; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="prodi" class="col-sm-2 col-form-label">Program Studi</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="prodi" name="prodi" value="<?= $prodi; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="golongan" class="col-sm-2 col-form-label">Sertifikat Diajukan</label>
                                            <div class="col-sm-10">
                                                <table id="example2" class="table table-striped text-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Aktivitas</th>
                                                            <th>Indonesia</th>
                                                            <th>English</th>
                                                            <th>Bukti</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;

                                                        $qprestasi = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE nim='$nim' ORDER BY aktivitas ASC, indonesia ASC");
                                                        while ($data = mysqli_fetch_array($qprestasi)) {
                                                            $nodata = $data[0];
                                                            $aktivitas = $data['aktivitas'];
                                                            $bukti = $data['bukti'];
                                                            if (!is_null($aktivitas)) {
                                                        ?>
                                                                <tr>
                                                                    <form role="form" method="POST">
                                                                        <td><?= $no; ?></td>
                                                                        <td><?= $data['aktivitas']; ?></td>
                                                                        <td><?= $data['indonesia']; ?></td>
                                                                        <td><i><?= $data['english']; ?></i></td>
                                                                        <td> <a href="<?= $bukti; ?>" target="_blank">
                                                                                <img src="<?= $bukti; ?>" width="100px"></img>
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if ($data['verifikasi1'] == 1) {
                                                                            ?>
                                                                                <b>DISETUJUI</b>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <input type="hidden" name="nim" value="<?php echo $nim; ?>"></input>
                                                                                <input type="hidden" name="nodata" value="<?php echo $nodata; ?>" />
                                                                                <button name="aksi" value="setujui" type="submit" formaction="skpi-sertifikat-setujui.php" class="btn btn-sm btn-success" onclick="return confirm('Menyetujui sertifikat ini ?')"> <i class="fa fa-check"></i> Setujui</button>
                                                                                <button name="aksi" value="tolak" type="submit" onclick="return confirm('Menolak Sertifikat <?= $data['indonesia']; ?> ?')" formaction="skpi-sertifikat-tolak.php" class="btn btn-sm btn-danger" onclick="return confirm('Menolak sertifikat ini ?')"> <i class="fa fa-times"></i> Tolak</button>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </form>
                                                                </tr>
                                                        <?php
                                                            }
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
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pengajuan Surat Keterangan Pendamping Ijazah</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body text-sm">
                                        <form role="form" id="my-form" method="POST" action="skpi-setujui.php">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title"><label>Capaian Pembelajaran</label></h3>
                                                </div>
                                                <div class="card-body">
                                                    <b>Kemampuan Kerja</b><br />
                                                    <?php
                                                    $qcpl = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE jurusan='$prodimhs' AND cpl='Kemampuan Kerja' ORDER BY indonesia");
                                                    while ($cpl = mysqli_fetch_array($qcpl)) {
                                                        $nodata = $cpl[0];
                                                        $kemampuankerja = $cpl[3];
                                                        $def = $cpl[5];

                                                    ?>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <?php
                                                                    if ($def == 0) {
                                                                    ?>
                                                                        <input class="form-check-input" type="checkbox" name="kemampuankerja[]" value="<?= $nodata; ?>">

                                                                    <?php
                                                                    } elseif ($def == 1) {
                                                                    ?>
                                                                        <input class="form-check-input" type="checkbox" name="kemampuankerja[]" value="<?= $nodata; ?>" checked>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <input class="form-check-input" type="checkbox" name="kemampuankerja[]" value="<?= $nodata; ?>" onclick="return false;" checked>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <label class="form-check-label"><?= $kemampuankerja; ?></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <br />
                                                    <b>Penguasaan Pengetahuan</b>
                                                    <?php
                                                    $qcpl2 = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE jurusan='$prodimhs' AND cpl='Penguasaan Pengetahuan' ORDER BY indonesia");
                                                    while ($cpl2 = mysqli_fetch_array($qcpl2)) {
                                                        $nodata = $cpl2[0];
                                                        $penguasaanpengetahuan = $cpl2[3];
                                                        $def = $cpl2[5];
                                                    ?>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <?php
                                                                    if ($def == 0) {
                                                                    ?>
                                                                        <input class="form-check-input" type="checkbox" name="penguasaanpengetahuan[]" value="<?= $nodata; ?>">

                                                                    <?php
                                                                    } elseif ($def == 1) {
                                                                    ?>
                                                                        <input class="form-check-input" type="checkbox" name="penguasaanpengetahuan[]" value="<?= $nodata; ?>" checked>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <input class="form-check-input" type="checkbox" name="penguasaanpengetahuan[]" value="<?= $nodata; ?>" onclick="return false;" checked>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <label class="form-check-label"><?= $penguasaanpengetahuan; ?></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <br />
                                                    <b>Sikap Khusus</b>
                                                    <?php
                                                    $qcpl3 = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE jurusan='$prodimhs' AND cpl='Sikap Khusus' ORDER BY indonesia");
                                                    while ($cpl3 = mysqli_fetch_array($qcpl3)) {
                                                        $nodata = $cpl3[0];
                                                        $SikapKhusus = $cpl3[3];
                                                        $def = $cpl3[5];
                                                    ?>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <?php
                                                                    if ($def == 0) {
                                                                    ?>
                                                                        <input class="form-check-input" type="checkbox" name="SikapKhusus[]" value="<?= $nodata; ?>">

                                                                    <?php
                                                                    } elseif ($def == 1) {
                                                                    ?>
                                                                        <input class="form-check-input" type="checkbox" name="SikapKhusus[]" value="<?= $nodata; ?>" checked>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <input class="form-check-input" type="checkbox" name="SikapKhusus[]" value="<?= $nodata; ?>" onclick="return false;" checked>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <label class="form-check-label"><?= $SikapKhusus; ?></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <br />
                                                </div>
                                            </div>
                                            <hr />
                                            <input type="hidden" name="nosurat" value="<?= $nosurat; ?>" />
                                            <input type="hidden" name="nama" value="<?= $namamhs; ?>" />
                                            <input type="hidden" name="nim" value="<?= $nim; ?>" />
                                            <input type="hidden" name="prodi" value="<?= $prodimhs; ?>" />
                                            <input type="hidden" name="nodata" value="<?= $nodata; ?>">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <button name="aksi" id="btn-submit" value="setujui" type="submit" formaction="skpi-dosen-setujui.php" class="btn btn-success btn-block" onclick="return confirm('Apakah anda menyetujui pengajuan ini ?')"> <i class="fa fa-check"></i> Setujui</button>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button name="aksi" id="btn-submit" value="tolak" type="button" data-toggle="modal" data-target="#modal-tolak" class="btn btn-danger btn-block"> <i class="fa fa-times"></i> Tolak</button>
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
                                                            <button name="aksi" value="tolak" type="submit" formaction="skpi-dosen-tolak.php" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menolak pengajuan ini ?')"> <i class="fa fa-times"></i> Tolak</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ./modal tolak-->
                                            <br />
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
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
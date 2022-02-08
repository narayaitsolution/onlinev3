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

            <!-- ambil data -->
            <?php
            $token = mysqli_real_escape_string($dbsurat, $_GET['token']);

            $stmt = $dbsurat->prepare("SELECT * FROM pkl WHERE token=?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $dpkl = $result->fetch_assoc();
            $nodata = $dpkl['no'];
            $namamhs = $dpkl['nama'];
            $nimmhs = $dpkl['nim'];
            $instansi = $dpkl['instansi'];
            $tempatpkl = $dpkl['tempatpkl'];
            $alamat = $dpkl['alamat'];
            $tglmulai = $dpkl['tglmulai'];
            $tglselesai = $dpkl['tglselesai'];
            $pklmagang = $dpkl['pklmagang'];
            $jenispkl = $dpkl['jenispkl'];
            $lampiran = $dpkl['lampiran'];
            $validator1 = $dpkl['validator1'];
            $tglvalidasi1 = $dpkl['tglvalidasi1'];
            $validasi1 = $dpkl['validasi1'];
            $validator2 = $dpkl['validator2'];
            $tglvalidasi2 = $dpkl['tglvalidasi2'];
            $validasi2 = $dpkl['validasi2'];

            ?>

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
                                        <div class="form-group row">
                                            <label for="instansi" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $namamhs; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instansi" class="col-sm-2 col-form-label">NIM</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nim" name="nim" value="<?= $nimmhs; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instansi" class="col-sm-2 col-form-label">Instansi Tujuan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="instansi" name="instansi" value="<?= $instansi; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tempatpkl" class="col-sm-2 col-form-label">Unit / Bagian</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tempatpkl" name="tempatpkl" value="<?= $tempatpkl; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $alamat; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tglmulai" class="col-sm-2 col-form-label">Tgl. Mulai</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tglmulai" name="tglmulai" value="<?= tgl_indo($tglmulai); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tglselesai" class="col-sm-2 col-form-label">Tgl. Selesai</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tglselesai" name="tglselesai" value="<?= tgl_indo($tglselesai); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pklmagang" class="col-sm-2 col-form-label">PKL / Magang</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="pklmagang" name="pklmagang" value="<?= $pklmagang; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jenispkl" class="col-sm-2 col-form-label">Luring / Daring</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="jenispkl" name="jenispkl" value="<?= $jenispkl; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="paktaintegritas" class="col-sm-2 col-form-label">Pakta Integritas</label>
                                            <div class="col-sm-10">
                                                <img src="<?= $lampiran; ?>" width="50%">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="paktaintegritas" class="col-sm-2 col-form-label">Anggota PKL</label>
                                            <div class="col-sm-10">
                                                <table id="example2" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" style="text-align: center;">No</th>
                                                            <th style="text-align: center;">Nama</th>
                                                            <th width="20%" style="text-align: center;">NIM</th>
                                                            <th width="20%" style="text-align: center;">Bukti Vaksin</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $stmt = $dbsurat->prepare("SELECT * FROM pklanggota WHERE nodata=?");
                                                        $stmt->bind_param("s", $nodata);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        while ($dpkl = $result->fetch_assoc()) {
                                                            $nimanggota = $dpkl['nimanggota'];
                                                            $namaanggota = $dpkl['nama'];
                                                            $buktivaksin = $dpkl['buktivaksin'];
                                                        ?>
                                                            <tr>
                                                                <td><?= $no; ?></td>
                                                                <td><?= $namaanggota; ?></td>
                                                                <td><?= $nimanggota; ?></td>
                                                                <td style="text-align: center;"><img src="<?= $buktivaksin; ?>" width="30%"></td>
                                                            </tr>
                                                        <?php
                                                            $no++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-group row">
                                            <label for="paktaintegritas" class="col-sm-2 col-form-label">Verifikator</label>
                                            <div class="col-sm-10">
                                                <table id="example3" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" style="text-align: center;">No</th>
                                                            <th style="text-align: center;">Nama</th>
                                                            <th style="text-align: center;">Jabatan</th>
                                                            <th style="text-align: center;">Status</th>
                                                            <th style="text-align: center;">Tgl. Verifikasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td><?= namadosen($dbsurat, $validator1); ?></td>
                                                            <td>Koordinator PKL</td>
                                                            <td><?php if ($validasi1 == 1) {
                                                                    echo 'Disetujui';
                                                                } elseif ($validasi1 == 2) {
                                                                    echo 'Ditolak';
                                                                } else {
                                                                    'Belum Disetujui';
                                                                } ?></td>
                                                            <td><?= tgljam_indo($tglvalidasi1); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td><?= namadosen($dbsurat, $validator2); ?></td>
                                                            <td>Kaprodi</td>
                                                            <td><?php if ($validasi2 == 1) {
                                                                    echo 'Disetujui';
                                                                } elseif ($validasi2 == 2) {
                                                                    echo 'Ditolak';
                                                                } else {
                                                                    'Belum Disetujui';
                                                                } ?></td>
                                                            <td><?= tgljam_indo($tglvalidasi2); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <hr>
                                        <form role="form" method="POST">
                                            <input type="hidden" name="token" value="<?= $token; ?>"></input>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <button name="aksi" value="setujui" type="submit" formaction="pkl-wd-setujui.php" class="btn btn-success btn-block btn-lg" onclick="return confirm('Apakah anda menyetujui pengajuan ini ?')"> <i class="fa fa-check"></i> Setujui</button>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
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
                                                            <button name="aksi" value="tolak" type="submit" formaction="pkl-wd-tolak.php" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menolak pengajuan ini ?')"> <i class="fa fa-times"></i> Tolak</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ./modal tolak-->
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
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            $('#example3').DataTable({
                "paging": false,
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
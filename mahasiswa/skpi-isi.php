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

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col">
                            <?php
                            $pesan = $_GET['pesan'];
                            ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>ERROR!!</strong> <?= $pesan; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Pengajuan Surat Keterangan Pendamping Ijazah</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <button name="aksi" value="tolak" type="button" data-toggle="modal" data-target="#modal-tambah" class="btn btn-warning btn-sm"> <i class="fa fa-plus"></i> Tambah Sertifikat</button>
                                <!-- modal tambah -->
                                <div class="modal fade" id="modal-tambah">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tambah Sertifikat</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label>Aktivitas Prestasi & Penghargaan</label>
                                                <select id="aktivitas" name="aktivitas" class="form-control">
                                                    <option>Sertifikat Profesional</option>
                                                    <option>Pelatihan & Workshop</option>
                                                </select>
                                                <br />
                                                <label>Kegiatan (Bahasa Indonesia)</label><br />
                                                <input type="text" class="form-control" name="indonesia" required>
                                                <label>Activity (in English)</label><br />
                                                <input type="text" class="form-control" name="english" required>
                                                <label>File Sertifikat</label><br />
                                                <input type="file" name="fileToUpload" class="form-control" accept=".jpg,.jpeg" required>
                                                <small style="color:blue"><i>*) Ukuran file maksimal 1MB format JPEG / JPG</i></small>
                                                <br />
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" value="simpan" formaction="skpi-upload.php"> <i class="fa fa-file-upload"></i> Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="example2" class="table table-bordered text-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Aktivitas</th>
                                        <th class="text-center">Indonesia</th>
                                        <th class="text-center">English</th>
                                        <th class="text-center">Bukti</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;

                                    $qprestasi = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE nim='$nim' ORDER BY aktivitas ASC, indonesia ASC");
                                    while ($data = mysqli_fetch_array($qprestasi)) {
                                        $nodata = $data[0];
                                        $aktivitas = $data['aktivitas'];
                                        $indonesia = $data['indonesia'];
                                        $english = $data['english'];
                                        $bukti = $data['bukti'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $aktivitas; ?></td>
                                            <td><?= $indonesia; ?></td>
                                            <td><i><?= $english; ?></i></td>
                                            <td> <a href="<?= $bukti; ?>" target="_blank"><img src="<?= $bukti; ?>" width="100px"></img></a> </td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Menghapus data <?= $indonesia; ?> ?')" href="skpi-isihapus.php?nodata=<?= $nodata; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <hr>
                            <form method="POST" action="skpi-simpanajukan.php">
                                <label>Dosen Wali </label>
                                <small><i>(pilih dari nama dosen yang tampil)</i></small><br />
                                <div class="form-group">
                                    <select name="dosen" class="form-control">
                                        <?php
                                        $qdosen = mysqli_query($dbsurat, "SELECT nama FROM pengguna WHERE hakakses='dosen' and prodi='$prodi' order by nama");
                                        while ($ddosen = mysqli_fetch_array($qdosen)) {
                                            $namadosen = $ddosen['nama'];
                                        ?>
                                            <option value="<?= $namadosen; ?>"><?= $namadosen; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-success btn-block" value="ajukan" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fas fa-graduation-cap"></i> Ajukan</button>
                            </form>
                            <small style="color:red">Apabila tidak memiliki sertifikat keahlian / workshop, pengajuan SKPI tetap dapat dilakukan dengan langsung klik tombol Ajukan</small>
                            <br />
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
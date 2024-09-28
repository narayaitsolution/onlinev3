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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

            <!-- alert -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col">

                            <!-- alert -->
                        <?php
                        if (isset($_GET['pesan'])) {
                            $pesan = $_GET['pesan'];
                            $hasil = $_GET['hasil'];
                            if ($hasil == 'ok') {
                        ?>
                                <script>
                                    swal('BERHASIL!!', '<?= $pesan; ?>', 'success');
                                </script>
                            <?php
                            } elseif ($hasil == 'notok') {
                            ?>
                                <script>
                                    swal('ERROR!', '<?= $pesan; ?>', 'error');
                                </script>
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
                                    <h3 class="card-title">Pengajuan Izin Magang</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form role="form" method="post" action="magang-anggotatambah.php" id="my-form">
                                            <div class="form-group row">
                                                <label for="nimanggota" class="col-sm-2 col-form-label">NIM Anggota</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="nimanggota" name="nimanggota">
                                                    <input type="hidden" name="nodata" value="<?= $nodata; ?>" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" id="btn-submit" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- anggota pkl -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Anggota Magang</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form role="form" method="post" action="magang-anggotatambah.php">
                                            <table id="example2" class="table table-bordered table-hover text-sm">
                                                <thead>
                                                    <th width="5%" style="text-align: center;">No.</th>
                                                    <th width="20%" style="text-align: center;">Nama</th>
                                                    <th style="text-align: center;">NIM</th>
                                                    <th style="text-align: center;">Bukti Vaksin</th>
                                                    <th width="5%" style="text-align: center;">Aksi</th>
                                                </thead>
                                                <tbody>
                                                    <!-- memasukkan pengusul -->
                                                    <?php
                                                    $qcari = mysqli_query($dbsurat, "SELECT * FROM maganganggota WHERE nimanggota ='$nim' AND nodata='$nodata'");
                                                    $jhasil = mysqli_num_rows($qcari);
                                                    if ($jhasil == 0) {
                                                        $qpengguna = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip=$nim");
                                                        $dhasil = mysqli_fetch_array($qpengguna);
                                                        $nimketua = $dhasil['nip'];
                                                        $nimanggota = $dhasil['nip'];
                                                        $namaanggota = $dhasil['nama'];
                                                        $buktivaksin = $dhasil['buktivaksin'];
                                                        $nohp = $dhasil['nohp'];

                                                        $qtambah = "INSERT INTO maganganggota (nodata,nimketua, nimanggota, nama,telepon, buktivaksin) 
																		values('$nodata','$nimketua','$nimanggota','$namaanggota','$nohp','$buktivaksin')";
                                                        $sql =  mysqli_query($dbsurat, $qtambah);
                                                    }
                                                    ?>

                                                    <?php
                                                    $dataanggota = mysqli_query($dbsurat, "SELECT * FROM maganganggota WHERE nimketua='$nim' and nodata='$nodata'");
                                                    $no = 1;
                                                    while ($q = mysqli_fetch_array($dataanggota)) {
                                                        $id = $q['id'];
                                                        $nimanggota = $q['nimanggota'];
                                                        $nama = $q['nama'];
                                                        $telepon = $q['telepon'];
                                                        $buktivaksin = $q['buktivaksin'];
                                                    ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= $nama; ?></td>
                                                            <td><?= $nimanggota; ?></td>
                                                            <td><a href="<?= $buktivaksin; ?>" target="_blank"><img src="<?= $buktivaksin; ?>" width="20%"></a></td>
                                                            <td>
                                                                <form action="magang-anggotahapus.php" method="POST" id="my-form">
                                                                    <input type="hidden" name="id" value="<?= $id; ?>">
                                                                    <input type="hidden" name="nodata" value="<?= $nodata; ?>">
                                                                    <button type="submit" id="btn-submit" class="btn btn-danger btn-sm" onclick="return confirm ('Yakin menghapus anggota ini ?');"><i class="fa fa-trash"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="magang-isilampiran.php?nodata=<?= $nodata; ?>" class="btn btn-success btn-block" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fa fa-file"></i> Isi Lampiran <i class="fa fa-arrow-right"></i></a>
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
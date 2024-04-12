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
if ($nip != "198312132019031004") {
    header("location:../deauth.php");
}
$no = 1;
$tahun = date('Y');
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
        <!-- ./Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3>Dashboard</h3>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col">
                            <?php
                            if (isset($_GET['pesan'])) {
                                if ($_GET['pesan'] == "success") {
                            ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>SUKSES</strong> Aksi Sukses!!
                                    </div>
                                <?php
                                } elseif ($_GET['pesan'] == "gagal") {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>ERROR!</strong> Aksi GAGAL!!
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- data pengunjung fakultas -->
            <section class="content text-sm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Pejabat Prodi & Fakultas</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>

                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <button name="tambah" value="tambah" type="button" data-toggle="modal" data-target="#modal-tolak" class="btn btn-warning btn-lg"> <i class="fa fa-plus"></i> Tambah</button>
                                        <div class="modal fade" id="modal-tolak">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tambah Pimpinan</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST">
                                                            <div class="form-group row">
                                                                <label for="matakuliah" class="col-sm-2 col-form-label">Program Studi</label>
                                                                <div class="col-sm-10">
                                                                    <select name="prodi" class="form-control">
                                                                        <?php
                                                                        $qprodi = mysqli_query($dbsurat, "SELECT DISTINCT (namaprodi) FROM prodi ORDER BY namaprodi");
                                                                        while ($dprodi = mysqli_fetch_array($qprodi)) {
                                                                            $prodi = $dprodi['namaprodi'];
                                                                        ?>
                                                                            <option value="<?= $prodi; ?>"><?= $prodi; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="matakuliah" class="col-sm-2 col-form-label">Nama</label>
                                                                <div class="col-sm-10">
                                                                    <select name="dosen" class="form-control">
                                                                        <?php
                                                                        $qdosen = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE hakakses='dosen' OR hakakses='tendik' order by nama");
                                                                        while ($ddosen = mysqli_fetch_array($qdosen)) {
                                                                            $namadosen = $ddosen['nama'];
                                                                        ?>
                                                                            <option value="<?= $namadosen; ?>"><?= $namadosen; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="matakuliah" class="col-sm-2 col-form-label">Jabatan</label>
                                                                <div class="col-sm-10">
                                                                    <select name="kdjabatan" class="form-control">
                                                                        <?php
                                                                        $qkdjabatan = mysqli_query($dbsurat, "SELECT DISTINCT (kdjabatan) FROM pejabat ORDER BY kdjabatan");
                                                                        while ($dkdjabatan = mysqli_fetch_array($qkdjabatan)) {
                                                                            $kdjab = $dkdjabatan['kdjabatan'];
                                                                        ?>
                                                                            <option value="<?= $kdjab; ?>"><?= $kdjab; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                        <button name="aksi" value="tolak" type="submit" formaction="pejabat-simpan.php" class="btn btn-primary btn-sm" onclick="return confirm('Apakah anda yakin akan menyimpan ini ?')"> <i class="fa fa-save"></i> SIMPAN</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                        <table id="example1" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Prodi</th>
                                                    <th>Nama</th>
                                                    <th>NIP</th>
                                                    <th>Jabatan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM pejabat ORDER BY prodi, kdjabatan");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $prodi = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $nip = $data['nip'];
                                                    $kdjabatan = $data['kdjabatan'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $prodi; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $nip; ?></td>
                                                        <td><select name="kdjabatan" class="form-control">
                                                                <option value="<?= $kdjabatan; ?>"><?= $kdjabatan; ?></option>
                                                                <?php
                                                                $qkdjabatan = mysqli_query($dbsurat, "SELECT DISTINCT (kdjabatan) FROM pejabat ORDER BY kdjabatan");
                                                                while ($dkdjabatan = mysqli_fetch_array($qkdjabatan)) {
                                                                    $kdjab = $dkdjabatan['kdjabatan'];
                                                                ?>
                                                                    <option value="<?= $kdjab; ?>"><?= $kdjab; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-sm btn-danger" href="pejabat-hapus.php?no=<?= $nodata; ?>" onclick="return confirm ('Hapus ?')">Delete</a>
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
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- footer -->
        <?php
        //include('footerdsn.php');
        ?>
        <!-- /.footer -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
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
                "buttons": ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
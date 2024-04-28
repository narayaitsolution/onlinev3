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
if ($_SESSION['hakakses'] != "subsatker") {
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
                            <h1>Data Pengguna</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- notifications -->


            <!-- tabel pengajuan mahasiswa -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Pengajuan Mahasiswa -->
                        <div class="col-sm">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Data Pengguna</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body">
                                    <?php
                                    $token = $_GET['token'];
                                    $qpengguna = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE token='$token'");
                                    $dpengguna = mysqli_fetch_array($qpengguna);
                                    $nip = $dpengguna['nip'];
                                    $nama = $dpengguna['nama'];
                                    $golongan = $dpengguna['golongan'];
                                    $pangkat = $dpengguna['pangkat'];
                                    $jafung = $dpengguna['jafung'];
                                    $nohp = $dpengguna['nohp'];
                                    $email = $dpengguna['email'];
                                    $prodi = $dpengguna['prodi'];
                                    $hakaksespengguna = $dpengguna['hakakses'];
                                    $token = $dpengguna['token'];
                                    ?>
                                    <form action="pengguna-update.php" method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nama" value="<?= $nama; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">NIP</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="nip" value="<?= $nip; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Program Studi</label>
                                            <div class="col-sm-10">
                                                <select name="prodi" class="form-control">
                                                    <option value="<?= $prodi; ?>"><?= $prodi; ?></option>
                                                    <?php
                                                    $qprodi = mysqli_query($dbsurat, "SELECT DISTINCT (namaprodi) FROM prodi ORDER BY namaprodi");
                                                    while ($dprodi = mysqli_fetch_array($qprodi)) {
                                                        $namaprodi = $dprodi['namaprodi'];
                                                    ?>
                                                        <option value="<?= $namaprodi; ?>"><?= $namaprodi; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Pangkat</label>
                                            <div class="col-sm-10">
                                                <select name="pangkat" class="form-control">
                                                    <option value="<?= $pangkat; ?>"><?= $pangkat; ?></option>
                                                    <option value="I/a">I/a</option>
                                                    <option value="I/b">I/b</option>
                                                    <option value="I/c">I/c</option>
                                                    <option value="I/d">I/d</option>
                                                    <option value="II/a">II/a</option>
                                                    <option value="II/b">II/b</option>
                                                    <option value="II/c">II/c</option>
                                                    <option value="II/d">II/d</option>
                                                    <option value="III/a">III/a</option>
                                                    <option value="III/b">III/b</option>
                                                    <option value="III/c">III/c</option>
                                                    <option value="III/d">III/d</option>
                                                    <option value="IV/a">IV/a</option>
                                                    <option value="IV/b">IV/b</option>
                                                    <option value="IV/c">IV/c</option>
                                                    <option value="IV/d">IV/d</option>
                                                    <option value="IV/e">IV/e</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Golongan</label>
                                            <div class="col-sm-10">
                                                <select name="golongan" class="form-control">
                                                    <option value="<?= $golongan; ?>"><?= $golongan; ?></option>
                                                    <option value="Juru Muda">Juru Muda</option>
                                                    <option value="Juru Muda Tingkat ">Juru Muda Tingkat </option>
                                                    <option value="Juru">Juru</option>
                                                    <option value="Juru Tingkat I">Juru Tingkat I</option>
                                                    <option value="Pengatur Muda">Pengatur Muda</option>
                                                    <option value="Pengatur Muda Tingkat I">Pengatur Muda Tingkat I</option>
                                                    <option value="Pengatur">Pengatur</option>
                                                    <option value="Pengatur Tingkat I">Pengatur Tingkat I</option>
                                                    <option value="Penata Muda">Penata Muda</option>
                                                    <option value="Penata Muda Tingkat I">Penata Muda Tingkat I</option>
                                                    <option value="Penata">Penata</option>
                                                    <option value="Penata Tingkat I">Penata Tingkat I</option>
                                                    <option value="Pembina">Pembina</option>
                                                    <option value="Pembina Tingkat I">Pembina Tingkat I</option>
                                                    <option value="Pembina Utama Muda">Pembina Utama Muda</option>
                                                    <option value="Pembina Utama Madya">Pembina Utama Madya</option>
                                                    <option value="Pembina Utama">Pembina Utama</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Jabatan Fungsional</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if ($hakaksespengguna == 'dosen') {
                                                ?>
                                                    <select name="jafung" class="form-control">
                                                        <option value="<?= $jafung; ?>"><?= $jafung; ?></option>
                                                        <option value="Asisten Ahli">Asisten Ahli</option>
                                                        <option value="Lektor">Lektor</option>
                                                        <option value="Lektor Kepala">Lektor Kepala</option>
                                                        <option value="Guru Besar">Guru Besar</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" class="form-control" name="jafung">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">No. HP</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="nohp" value="<?= $nohp; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">E-Mail</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" value="<?= $email; ?>" required>
                                            </div>
                                        </div>
                                        <hr>
                                        <input type="hidden" name="token" value="<?= $token; ?>">
                                        <button type="submit" class="btn btn-block btn-success btn-lg" onclick="return confirm('Apakah anda yakin meyimpan perubahan data ini ?')"><i class="fas fa-save"></i> SIMPAN DATA</button>
                                    </form>
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
                "buttons": ["excel", "pdf", "print"]
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
            $('#example3').DataTable({
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
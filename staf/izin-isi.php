<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "tendik") {
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

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            if (isset($_GET['pesan'])) {
                                if ($_GET['pesan'] == "over") {
                            ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>ERROR!</strong> lama izin melebihi sisa cuti
                                    </div>
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
                                    <h3 class="card-title">Pengajuan Izin Tidak Masuk Kerja</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form action="izin-simpan.php" method="POST" id="my-form">
                                            <div class="form-group row">
                                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $_SESSION['nama']; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nip" name="nip" value="<?= $_SESSION['nip']; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pangkat" class="col-sm-2 col-form-label">Pangkat / Golongan</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col">
                                                            <select class="form-control" name="pangkat">
                                                                <option value="Juru Muda">Juru Muda</option>
                                                                <option value="Juru Muda Tk. 1">Juru Muda Tk. 1</option>
                                                                <option value="Juru">Juru</option>
                                                                <option value="Juru Tk. 1">Juru Tk. 1</option>
                                                                <option value="Pengatur Muda">Pengatur Muda</option>
                                                                <option value="Pengatur Muda Tk. 1">Pengatur Muda Tk. 1</option>
                                                                <option value="Pengatur">Pengatur</option>
                                                                <option value="Pengatur Tk. 1" selected>Pengatur Tk. 1</option>
                                                                <option value="Penata Muda">Penata Muda</option>
                                                                <option value="Penata Muda Tk. 1">Penata Muda Tk. 1</option>
                                                                <option value="Penata">Penata</option>
                                                                <option value="Penata Tk. 1">Penata Tk. 1</option>
                                                                <option value="Pembina">Pembina</option>
                                                                <option value="Pembina Tk. 1">Pembina Tk. 1</option>
                                                                <option value="Pembina Utama Muda">Pembina Utama Muda</option>
                                                                <option value="Pembina Utama Madya">Pembina Utama Madya</option>
                                                                <option value="Pembina Utama">Pembina Utama</option>
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <select class="form-control" name="golongan">
                                                                <option value="IV/d">IV/d</option>
                                                                <option value="IV/c">IV/c</option>
                                                                <option value="IV/b">IV/b</option>
                                                                <option value="IV/a">IV/a</option>
                                                                <option value="III/d">III/d</option>
                                                                <option value="III/c">III/c</option>
                                                                <option value="III/b" selected>III/b</option>
                                                                <option value="III/a">III/a</option>
                                                                <option value="II/d">II/d</option>
                                                                <option value="II/c">II/c</option>
                                                                <option value="II/b">II/b</option>
                                                                <option value="II/a">II/a</option>
                                                                <option value="I/d">I/d</option>
                                                                <option value="I/c">I/c</option>
                                                                <option value="I/b">I/b</option>
                                                                <option value="I/a">I/a</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- cari jabatan -->
                                            <?php
                                            $qjabatan = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$nip'");
                                            $jjabatan = mysqli_num_rows($qjabatan);
                                            if ($jjabatan > 0) {
                                                $djabatan = mysqli_fetch_array($qjabatan);
                                                $jabatan = $djabatan['jabatan'];
                                            } else {
                                                $qjabatan = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nip'");
                                                $djabatan = mysqli_fetch_array($qjabatan);
                                                $djbtn = $djabatan['hakakses'];
                                                if ($djbtn == 'dosen') {
                                                    $jabatan == 'DOSEN';
                                                } elseif ($djbtn == 'tendik') {
                                                    $jabatan == 'TENAGA KEPENDIDIKAN';
                                                }
                                            }
                                            ?>
                                            <div class="form-group row">
                                                <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= strtoupper($_SESSION['jabatan']); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">Awal Izin</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="tgl1" name="tgl1" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">Akhir Izin</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="tgl2" name="tgl2">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jenisizin" class="col-sm-2 col-form-label">Jenis Izin</label>
                                                <div class="col-sm-10">
                                                    <select name="jenisizin" class="form-control">
                                                        <option value="Tidak hadir" selected>Tidak hadir</option>
                                                        <option value="Terlambat masuk kerja">Terlambat masuk kerja</option>
                                                        <option value="Pulang sebelum waktunya">Pulang sebelum waktunya</option>
                                                        <option value="Tidak berada di tempat tugas">Tidak berada di tempat tugas</option>
                                                        <option value="Tidak mengisi daftar hadir">Tidak mengisi daftar hadir</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alasan" class="col-sm-2 col-form-label">Alasan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="alasan" required>
                                                </div>
                                            </div>
                                            <hr>
                                            <button type="submit" id="btn-submit" class="btn btn-primary btn-block btn-lg" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fa fa-upload"></i> Ajukan</button>
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
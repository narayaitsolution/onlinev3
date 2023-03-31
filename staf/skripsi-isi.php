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
                            <h3>Progress Skripsi Mahasiswa</h3>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <?php
            if (isset($_GET['pesan'])) {
                $pesan = $_GET['pesan'];
                if ($pesan == "success") {
            ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>UPDATE</strong> data berhasil
                    </div>
                <?php
                } elseif ($pesan == "exist") {
                ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>ERROR!!</strong> data sudah ada!!
                    </div>
            <?php
                }
            }
            ?>
            <!-- rekap progress -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <?php
                                    $qsempro = mysqli_query($dbsurat, "SELECT * FROM sempro WHERE prodi='$prodi' and status='1'");
                                    $jsempro = mysqli_num_rows($qsempro);
                                    ?>
                                    <span class="info-box-text">Seminar Proposal</span>
                                    <span class="info-box-number"><?= $jsempro; ?><small> orang</small></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fa-solid fa-book"></i></span>
                                <div class="info-box-content">
                                    <?php
                                    $qkompre = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE prodi='$prodi' and status='1'");
                                    $jkompre = mysqli_num_rows($qkompre);
                                    ?>
                                    <span class="info-box-text">Ujian Komprehensif</span>
                                    <span class="info-box-number"><?= $jkompre; ?><small> orang</small></span>
                                </div>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <?php
                                $qsemhas = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE prodi='$prodi' and status='1'");
                                $jsemhas = mysqli_num_rows($qsemhas);
                                ?>
                                <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-square-poll-vertical"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Seminar Hasil</span>
                                    <span class="info-box-number"><?= $jsemhas; ?><small> orang</small></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <?php
                                $qskripsi = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE prodi='$prodi' and status='1'");
                                $jskripsi = mysqli_num_rows($qskripsi);
                                ?>
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-graduation-cap"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Ujian Skripsi</span>
                                    <span class="info-box-number"><?= $jskripsi; ?><small> orang</small></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                </div>
            </section>

            <!-- data skripsi-->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Data Progress Skripsi Mahasiswa <?= $prodi; ?></h3>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <button name="aksi" value="tolak" type="button" data-toggle="modal" data-target="#modal-tambah" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah Data</button>
                                <?php
                                if ($prodi == 'Fisika') {
                                ?>
                                    <a href="#" class="btn btn-warning"><i class="fa fa-refresh"></i> Tarik Data</a>
                                <?php
                                }
                                ?>
                                <!-- modal tambah -->
                                <div class="modal fade" id="modal-tambah">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Data</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label>Tahapan</label>
                                                <select id="tahapan" name="tahapan" class="form-control">
                                                    <option value="sempro">Seminar Proposal</option>
                                                    <option value="kompre">Ujian Komprehensif</option>
                                                    <option value="semhas">Seminar Hasil</option>
                                                    <option value="skripsi">Skripsi</option>
                                                </select>
                                                <label>Mahasiswa</label><br />
                                                <select name="nim" class="form-control">
                                                    <?php
                                                    $qmhs = mysqli_query($dbsurat, "SELECT nama,nip FROM pengguna WHERE hakakses='mahasiswa' and prodi='$prodi' order by nama, nip");
                                                    while ($dmhs = mysqli_fetch_array($qmhs)) {
                                                        $namamhs = $dmhs['nama'];
                                                        $nip = $dmhs['nip'];
                                                    ?>
                                                        <option value="<?= $nip; ?>"><?= $namamhs; ?> (<?= $nip; ?>)</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Pembimbing 1</label><br />
                                                        <select name="pembimbing1" class="form-control">
                                                            <?php
                                                            $qdosen = mysqli_query($dbsurat, "SELECT nama,nip FROM pengguna WHERE hakakses='dosen' and prodi='$prodi' order by nama");
                                                            while ($ddosen = mysqli_fetch_array($qdosen)) {
                                                                $namadosen = $ddosen['nama'];
                                                                $nip = $ddosen['nip'];
                                                            ?>
                                                                <option value="<?= $nip; ?>"><?= $namadosen; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label>Pembimbing 2</label><br />
                                                        <select name="pembimbing2" class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $qdosen = mysqli_query($dbsurat, "SELECT nama,nip FROM pengguna WHERE hakakses='dosen' and prodi='$prodi' order by nama");
                                                            while ($ddosen = mysqli_fetch_array($qdosen)) {
                                                                $namadosen = $ddosen['nama'];
                                                                $nip = $ddosen['nip'];
                                                            ?>
                                                                <option value="<?= $nip; ?>"><?= $namadosen; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Penguji 1</label><br />
                                                        <select name="penguji1" class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $qdosen = mysqli_query($dbsurat, "SELECT nama,nip FROM pengguna WHERE hakakses='dosen' and prodi='$prodi' order by nama");
                                                            while ($ddosen = mysqli_fetch_array($qdosen)) {
                                                                $namadosen = $ddosen['nama'];
                                                                $nip = $ddosen['nip'];
                                                            ?>
                                                                <option value="<?= $nip; ?>"><?= $namadosen; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label>Penguji 2</label><br />
                                                        <select name="penguji2" class="form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $qdosen = mysqli_query($dbsurat, "SELECT nama,nip FROM pengguna WHERE hakakses='dosen' and prodi='$prodi' order by nama");
                                                            while ($ddosen = mysqli_fetch_array($qdosen)) {
                                                                $namadosen = $ddosen['nama'];
                                                                $nip = $ddosen['nip'];
                                                            ?>
                                                                <option value="<?= $nip; ?>"><?= $namadosen; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <label>Tanggal Ujian</label><br />
                                                <input type="date" class="form-control" id="tglujian" name="tglujian" required>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                                                <button type="submit" class="btn btn-success" value="simpan" formaction="skripsi-simpan.php"> <i class="fa fa-save"></i> SIMPAN</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="example1" class="table table-bordered text-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Tahapan</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">NIM</th>
                                        <th class="text-center">Tanggal Ujian</th>
                                        <th class="text-center">Pembimbing 1</th>
                                        <th class="text-center">Pembimbing 2</th>
                                        <th class="text-center">Penguji 1</th>
                                        <th class="text-center">Penguji 2</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    //sempro
                                    $qprestasi = mysqli_query($dbsurat, "SELECT * FROM sempro WHERE prodi='$prodi' ORDER BY tglujian DESC, nim ASC");
                                    while ($data = mysqli_fetch_array($qprestasi)) {
                                        $nodata = $data[0];
                                        $nim = $data['nim'];
                                        $pembimbing1 = $data['pembimbing1'];
                                        $pembimbing2 = $data['pembimbing2'];
                                        $penguji1 = $data['penguji1'];
                                        $penguji2 = $data['penguji2'];
                                        $tglujian = $data['tglujian'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td>Seminar Proposal</td>
                                            <td><?= namadosen($dbsurat, $nim); ?></td>
                                            <td><?= $nim; ?></td>
                                            <td><?= tgl_indo($tglujian); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji1); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji2); ?></td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Menghapus data ini ?')" href="skripsi-semprohapus.php?nodata=<?= $nodata; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                    <?php
                                    //kompre
                                    $qprestasi = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE prodi='$prodi' ORDER BY tglujian DESC, nim ASC");
                                    while ($data = mysqli_fetch_array($qprestasi)) {
                                        $nodata = $data[0];
                                        $nim = $data['nim'];
                                        $pembimbing1 = $data['pembimbing1'];
                                        $pembimbing2 = $data['pembimbing2'];
                                        $penguji1 = $data['penguji1'];
                                        $penguji2 = $data['penguji2'];
                                        $tglujian = $data['tglujian'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td>Ujian Komprehensif</td>
                                            <td><?= namadosen($dbsurat, $nim); ?></td>
                                            <td><?= $nim; ?></td>
                                            <td><?= tgl_indo($tglujian); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji1); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji2); ?></td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Menghapus data ini ?')" href="skripsi-komprehapus.php?nodata=<?= $nodata; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                    <?php
                                    //semhas
                                    $qprestasi = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE prodi='$prodi' ORDER BY tglujian DESC, nim ASC");
                                    while ($data = mysqli_fetch_array($qprestasi)) {
                                        $nodata = $data[0];
                                        $nim = $data['nim'];
                                        $pembimbing1 = $data['pembimbing1'];
                                        $pembimbing2 = $data['pembimbing2'];
                                        $penguji1 = $data['penguji1'];
                                        $penguji2 = $data['penguji2'];
                                        $tglujian = $data['tglujian'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td>Seminar Hasil</td>
                                            <td><?= namadosen($dbsurat, $nim); ?></td>
                                            <td><?= $nim; ?></td>
                                            <td><?= tgl_indo($tglujian); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji1); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji2); ?></td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Menghapus data ini ?')" href="skripsi-semhashapus.php?nodata=<?= $nodata; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                    <?php
                                    //skripsi
                                    $qprestasi = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE prodi='$prodi' ORDER BY tglujian DESC, nim ASC");
                                    while ($data = mysqli_fetch_array($qprestasi)) {
                                        $nodata = $data[0];
                                        $nim = $data['nim'];
                                        $pembimbing1 = $data['pembimbing1'];
                                        $pembimbing2 = $data['pembimbing2'];
                                        $penguji1 = $data['penguji1'];
                                        $penguji2 = $data['penguji2'];
                                        $tglujian = $data['tglujian'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td>Ujian Skripsi</td>
                                            <td><?= namadosen($dbsurat, $nim); ?></td>
                                            <td><?= $nim; ?></td>
                                            <td><?= tgl_indo($tglujian); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing1); ?></td>
                                            <td><?= namadosen($dbsurat, $pembimbing2); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji1); ?></td>
                                            <td><?= namadosen($dbsurat, $penguji2); ?></td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Menghapus data ini ?')" href="skripsi-skripsihapus.php?nodata=<?= $nodata; ?>">
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
                            <br />
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
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "buttons": ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true
            });
        });
    </script>
</body>

</html>
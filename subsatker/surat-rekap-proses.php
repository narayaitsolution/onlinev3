<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($hakakses != "subsatker") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');
$no = 1;
$tahun = date('Y');
$tahunlalu = date('Y', strtotime('-1 year'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAINTEK e-Office</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="../template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
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
                            <a href="index.php" class="btn btn-primary"><i class="nav-icon fas fa-arrow-left"></i> KEMBALI</a>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- cards -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- ijin pkl -->
                        <?php
                        $qpkl = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE statussurat= 0 AND year(tanggal)=$tahun");
                        $jpkl = mysqli_num_rows($qpkl);
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $jpkl; ?> <sup style="font-size: 20px">Ijin PKL</sup></h3>
                                    <p>Dalam proses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Ijin PKL dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- ijin magang -->
                        <?php
                        $qmagang = mysqli_query($dbsurat, "SELECT * FROM magang WHERE statussurat= 0 AND year(tanggal)=$tahun");
                        $jmagang = mysqli_num_rows($qmagang);
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $jmagang; ?> <sup style="font-size: 20px">Ijin Magang</sup></h3>
                                    <p>Dalam proses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Ijin Magang dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Delegasi -->
                        <?php
                        $qdelegasi = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE statussurat= 0 AND year(tanggal)=$tahun");
                        $jdelegasi = mysqli_num_rows($qdelegasi);
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $jdelegasi; ?> <sup style="font-size: 20px">Ijin Delegasi</sup></h3>
                                    <p>Dalam proses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Ijin Delegasi dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Surat Keterangan -->
                        <?php
                        $qsuket = mysqli_query($dbsurat, "SELECT * FROM suket WHERE statussurat= 0 AND year(tanggal)=$tahun");
                        $jsuket = mysqli_num_rows($qsuket);
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?= $jsuket; ?> <sup style="font-size: 20px">Ijin Suket</sup></h3>
                                    <p>Dalam proses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Ijin Surat Keterangan dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- Pengambilan Data -->
                        <?php
                        $qdata = mysqli_query($dbsurat, "SELECT * FROM pengambilandata WHERE statussurat= 0 AND year(tanggal)=$tahun");
                        $jdata = mysqli_num_rows($qdata);
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= $jdata; ?> <sup style="font-size: 20px">Ijin Pengambilan Data</sup></h3>
                                    <p>Dalam proses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Ijin Pengambilan Data dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- ijin observasi -->
                        <?php
                        $qobservasi = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE statussurat= 0 AND year(tanggal)=$tahun");
                        $jobservasi = mysqli_num_rows($qobservasi);
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3><?= $jobservasi; ?> <sup style="font-size: 20px">Ijin Observasi</sup></h3>
                                    <p>Dalam proses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Ijin Observasi dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Penelitian -->
                        <?php
                        $qpenelitian = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE statussurat= 0 AND year(tanggal)=$tahun");
                        $jpenelitian = mysqli_num_rows($qpenelitian);
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $jpenelitian; ?> <sup style="font-size: 20px">Ijin Penelitian</sup></h3>
                                    <p>Dalam proses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Surat Penelitian dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Surat Ijin lab -->
                        <?php
                        $qlab = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE statuspengajuan= 0 AND year(tanggal)=$tahun");
                        $jlab = mysqli_num_rows($qlab);
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $jlab; ?> <sup style="font-size: 20px">Ijin Lab.</sup></h3>
                                    <p>Dalam proses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Surat Ijin Lab dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Pengajuan SK -->
                        <?php
                        $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE statussurat= 0 AND year(tanggal)=$tahun");
                        $jnarsum = mysqli_num_rows($qnarsum);
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $jnarsum; ?> <sup style="font-size: 20px">SK</sup></h3>
                                    <p>Dalam proses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-text"></i>
                                </div>
                                <a href="#" class="small-box-footer" onclick="alert('Jumlah Pengajuan SK Narasumber dalam proses')">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Pengajuan Surat Mahasiswa -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Surat Mahasiswa Dalam Proses Tahun <?= $tahun; ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped text-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No.</th>
                                    <th style="text-align: center;">Surat</th>
                                    <th style="text-align: center;">Tgl. Pengajuan</th>
                                    <th style="text-align: center;">Nama</th>
                                    <th style="text-align: center;">NIM</th>
                                    <th style="text-align: center;">Prodi</th>
                                    <th style="text-align: center;">Verifikator 1</th>
                                    <th style="text-align: center;">Verifikator 2</th>
                                    <th style="text-align: center;">Verifikator 3</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>

                                <!-- PKL-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Ijin PKL';
                                    $validasi1 = $data['validasi1'];
                                    $validator1 = $data['validator1'];
                                    $validasi2 = $data['validasi2'];
                                    $validator2 = $data['validator2'];
                                    $validasi3 = $data['validasi3'];
                                    $validator3 = $data['validator3'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $validator1); ?>
                                            <?php if ($validasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator2); ?>
                                            <?php if ($validasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator3); ?>
                                            <?php if ($validasi3 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- PKL-->

                                <!-- Magang-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM magang WHERE statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Ijin Magang';
                                    $validasi1 = $data['validasi1'];
                                    $validator1 = $data['validator1'];
                                    $validasi2 = $data['validasi2'];
                                    $validator2 = $data['validator2'];
                                    $validasi3 = $data['validasi3'];
                                    $validator3 = $data['validator3'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $validator1); ?>
                                            <?php if ($validasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator2); ?>
                                            <?php if ($validasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator3); ?>
                                            <?php if ($validasi3 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- Magang -->

                                <!-- Delegasi-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Delegasi';
                                    $validasi1 = $data['validasi1'];
                                    $validator1 = $data['validator1'];
                                    $validasi2 = $data['validasi2'];
                                    $validator2 = $data['validator2'];
                                    $validasi3 = $data['validasi3'];
                                    $validator3 = $data['validator3'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $validator1); ?>
                                            <?php if ($validasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator2); ?>
                                            <?php if ($validasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator3); ?>
                                            <?php if ($validasi3 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- delegasi -->

                                <!-- Suket-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM suket WHERE statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Surat Keterangan';
                                    $validasi1 = $data['validasi1'];
                                    $validator1 = $data['validator1'];
                                    $validasi2 = $data['validasi2'];
                                    $validator2 = $data['validator2'];
                                    $validasi3 = $data['validasi3'];
                                    $validator3 = $data['validator3'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $validator1); ?>
                                            <?php if ($validasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator2); ?>
                                            <?php if ($validasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator3); ?>
                                            <?php if ($validasi3 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- Suket -->

                                <!-- Pengambilan Data-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM pengambilandata WHERE statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Pengambilan Data';
                                    $validasi1 = $data['validasi1'];
                                    $validator1 = $data['validator1'];
                                    $validasi2 = $data['validasi2'];
                                    $validator2 = $data['validator2'];
                                    $validasi3 = $data['validasi3'];
                                    $validator3 = $data['validator3'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $validator1); ?>
                                            <?php if ($validasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator2); ?>
                                            <?php if ($validasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator3); ?>
                                            <?php if ($validasi3 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- Pengambilan Data -->

                                <!-- Observasi-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Observasi';
                                    $validasi1 = $data['validasi1'];
                                    $validator1 = $data['validator1'];
                                    $validasi2 = $data['validasi2'];
                                    $validator2 = $data['validator2'];
                                    $validasi3 = $data['validasi3'];
                                    $validator3 = $data['validator3'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $validator1); ?>
                                            <?php if ($validasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator2); ?>
                                            <?php if ($validasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator3); ?>
                                            <?php if ($validasi3 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- Observasi -->

                                <!-- Ijin Penelitian-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Ijinn Penelitian';
                                    $validasi1 = $data['validasi1'];
                                    $validator1 = $data['validator1'];
                                    $validasi2 = $data['validasi2'];
                                    $validator2 = $data['validator2'];
                                    $validasi3 = $data['validasi3'];
                                    $validator3 = $data['validator3'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $validator1); ?>
                                            <?php if ($validasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator2); ?>
                                            <?php if ($validasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator3); ?>
                                            <?php if ($validasi3 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- Ijin Penelitian -->

                                <!-- Ijin Lab.-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE statuspengajuan= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $nama = $data['nama'];
                                    $prodi = $data['prodi'];
                                    $surat = 'Ijin Lab.';
                                    $validasi1 = $data['validasi1'];
                                    $validator1 = $data['validator1'];
                                    $validasi2 = $data['validasi2'];
                                    $validator2 = $data['validator2'];
                                    $validasi3 = $data['validasi3'];
                                    $validator3 = $data['validator3'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $validator1); ?>
                                            <?php if ($validasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator2); ?>
                                            <?php if ($validasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $validator3); ?>
                                            <?php if ($validasi3 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- Ijin Lab. -->

                                <!-- SK Narsum-->
                                <?php
                                $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='narasumber' AND statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($qnarsum);
                                while ($data = mysqli_fetch_array($qnarsum)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $prodi = $data['prodi'];
                                    $surat = 'SK Narasumber';
                                    $verifikasi1 = $data['verifikasi1'];
                                    $verifikator1 = $data['verifikator1'];
                                    $verifikasi2 = $data['verifikasi2'];
                                    $verifikator2 = $data['verifikator2'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= namadosen($dbsurat, $nim); ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $verifikator1); ?>
                                            <?php if ($verifikasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $verifikator2); ?>
                                            <?php if ($verifikasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- SK Narsum -->

                                <!-- SK Panitia-->
                                <?php
                                $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='panitia' AND statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($qnarsum);
                                while ($data = mysqli_fetch_array($qnarsum)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $prodi = $data['prodi'];
                                    $surat = 'SK Panitia';
                                    $verifikasi1 = $data['verifikasi1'];
                                    $verifikator1 = $data['verifikator1'];
                                    $verifikasi2 = $data['verifikasi2'];
                                    $verifikator2 = $data['verifikator2'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= namadosen($dbsurat, $nim); ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $verifikator1); ?>
                                            <?php if ($verifikasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $verifikator2); ?>
                                            <?php if ($verifikasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- SK Panitia -->

                                <!-- SK Peserta-->
                                <?php
                                $qnarsum = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='peserta' AND statussurat= 0 AND year(tanggal)=$tahun ORDER BY prodi ASC, tanggal DESC");
                                $jmldata = mysqli_num_rows($qnarsum);
                                while ($data = mysqli_fetch_array($qnarsum)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $nim = $data['nim'];
                                    $prodi = $data['prodi'];
                                    $surat = 'SK Panitia';
                                    $verifikasi1 = $data['verifikasi1'];
                                    $verifikator1 = $data['verifikator1'];
                                    $verifikasi2 = $data['verifikasi2'];
                                    $verifikator2 = $data['verifikator2'];
                                    $keterangan = $data['keterangan'];
                                    $token = $data['token'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td><?= namadosen($dbsurat, $nim); ?></td>
                                        <td><?= $nim; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= namadosen($dbsurat, $verifikator1); ?>
                                            <?php if ($verifikasi1 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td><?= namadosen($dbsurat, $verifikator2); ?>
                                            <?php if ($verifikasi2 == 1) {
                                                echo "&#9989;";
                                            } else {
                                                echo "&#10067;";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- SK Peserta -->


                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <?php
        require('footer.php');
        ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /.control-sidebar -->
    </div>

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
                "buttons": ["excel", "print"]
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
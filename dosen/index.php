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
if ($_SESSION['hakakses'] != "dosen") {
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

            <!-- notifications -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!--
                        <div class="col-lg col-6">
                            <a href="pengajuanmhs-tampil.php">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>150 <sup style="font-size: 20px">surat</sup></h3>
                                        <p>Surat Mahasiswa <br /> menunggu verifikasi</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-email"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
-->
                        <!-- pengajuan bawahan -->
                        <!--
                        <?php
                        if ($jabatan == 'dekan' or $jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
                            $qwfh = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE verifikatorprodi='$nip' AND verifikasiprodi = 0 and verifikasifakultas=0");
                            $jwfh = mysqli_num_rows($qwfh);
                            $qst = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE verifikatorprodi='$nip' AND verifikasiprodi = 0 and verifikasifakultas=0");
                            $jst = mysqli_num_rows($qst);
                            $tbawahan = $jwfh + $jst;

                        ?>
                            <div class="col-lg col-6">
                                <a href="pengajuanbawahan-tampil.php">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><?= $tbawahan; ?> <sup style="font-size: 20px">surat</sup></h3>
                                            <p>Bawahan <br /> menunggu verifikasi</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-email"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                        -->
                        <!-- ./col -->
                        <!--
                        <div class="col-lg col-6">
                            <a href="#">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>2 <sup style="font-size: 20px">surat</sup></h3>
                                        <p>Disposisi <br />masuk</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-android-mail"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    -->
                        <!--
                        <?php
                        if ($jabatan == 'wadek3' or $jabatan == 'wadek2') {
                        ?>
                            <div class="col-lg col-6">
                                <a href="#">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>60 <sup style="font-size: 20px">orang</sup></h3>
                                            <p>Pengunjung Fakultas <br />masuk</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-ios-people"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                        -->
                    </div>
                </div>
            </section>

            <!-- laporan -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        if ($jabatan == 'dekan' or $jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1') {
                        ?>
                            <!-- LAPORAN -->
                            <div class="col-sm">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Laporan</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <?php $no = 1; ?>
                                    <div class="card-body">
                                        <table id="example4" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center">No</th>
                                                    <th style="text-align:center">Tgl. Laporan</th>
                                                    <th style="text-align:center">Laporan</th>
                                                    <th style="text-align:center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- laporan keluhan -->
                                                <?php
                                                $qlaporan = mysqli_query($dbsurat, "SELECT * FROM laporkan WHERE status=0");
                                                while ($dlaporkan = mysqli_fetch_array($qlaporan)) {
                                                    $nodata = $dlaporkan['no'];
                                                    $tanggal = $dlaporkan['tanggal'];
                                                    $unitterkait = $dlaporkan['unitterkait'];
                                                    $keluhan = $dlaporkan['keluhan'];
                                                    $kode = $dlaporkan['kode'];
                                                    $laporan = 'Laporan Keluhan';
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                        <td><?= $laporan; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="laporan-keluhan-tampil.php?token=<?= $kode; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>

                                                <!-- laporan gratifikasi -->
                                                <?php
                                                $qlaporan = mysqli_query($dbsurat, "SELECT * FROM gratifikasi WHERE status=0");
                                                while ($dlaporkan = mysqli_fetch_array($qlaporan)) {
                                                    $nodata = $dlaporkan['no'];
                                                    $tanggal = $dlaporkan['tanggal'];
                                                    $laporan = 'Laporan Gratifikasi';
                                                    $kode = $dlaporkan['kode'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                        <td><?= $laporan; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="laporan-gratifikasi-tampil.php?kode=<?= $kode; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
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
                            <div class="col-sm-4">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Hasil Survey</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <?php
                                    $pelayanan = 0;
                                    $kecepatan = 0;
                                    $kejelasan = 0;
                                    $qnilai = mysqli_query($dbsurat, "SELECT * FROM penilaianlayanan");
                                    $jnilai = mysqli_num_rows($qnilai);
                                    while ($dnilai = mysqli_fetch_array($qnilai)) {
                                        $pelayanan = $pelayanan + $dnilai['pelayanan'];
                                        $kecepatan = $kecepatan + $dnilai['kecepatan'];
                                        $kejelasan = $kejelasan + $dnilai['kejelasan'];
                                    }
                                    $totalpelayanan = $jnilai * 5;
                                    $totalkecepatan = $jnilai * 5;
                                    $totalkejelasan = $jnilai * 5;

                                    $nilaipelayanan = ($pelayanan / $totalpelayanan) * 100;
                                    $nilaikecepatan = ($kecepatan / $totalkecepatan) * 100;
                                    $nilaikejelasan = ($kejelasan / $totalkejelasan) * 100;
                                    ?>
                                    <div class="card-body">
                                        <p class="text-center">
                                            <strong>Hasil Survey</strong>
                                        </p>
                                        <div class="progress-group">
                                            Keramahan Pelayanan
                                            <span class="float-right"><?= round($nilaipelayanan); ?>%</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-primary" style="width: <?= round($nilaipelayanan); ?>%"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->

                                        <div class="progress-group">
                                            Kecepatan Pelayanan
                                            <span class="float-right"><?= round($nilaikecepatan); ?>%</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-danger" style="width: <?= round($nilaikecepatan); ?>%"></div>
                                            </div>
                                        </div>

                                        <!-- /.progress-group -->
                                        <div class="progress-group">
                                            <span class="progress-text">Kejelasan Prosedur Pelayanan</span>
                                            <span class="float-right"><?= round($nilaikejelasan); ?>%</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success" style="width: <?= round($nilaikejelasan); ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- tabel pengajuan bawahan & mahasiswa -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- Pengajuan Mahasiswa -->
                        <div class="col">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Pengajuan Surat Mahasiswa</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover text-sm">
                                        <thead>
                                            <tr>
                                                <td style="text-align:center">No</td>
                                                <td style="text-align:center">Surat</td>
                                                <td style="text-align:center">Nama</td>
                                                <td style="text-align:center">PRODI</td>
                                                <td style="text-align:center">Aksi</td>
                                                <td style="text-align:center">Tgl. Pengajuan</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- PKL Koordinator-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE validator1='$nip' AND validasi1 = 0");
                                            $jmldata = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = $data['pklmagang'];
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= 'Surat Pengantar ' . $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="pkl-koor-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /. PKL koordinator-->

                                            <!-- PKL as Kaprodi-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE validator2='$nip' AND validasi2 = 0 AND validasi1=1");
                                            $jmldata = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = $data['pklmagang'];
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= 'Surat Pengantar ' . $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="pkl-kaprodi-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /. PKL as kaprodi-->

                                            <!-- PKL as WD-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            $jmldata = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = $data['pklmagang'];
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= 'Surat Pengantar ' . $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="pkl-wd-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /. PKL as WD-->

                                            <!-- ijin lab sebagai dosbing-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE validator0='$nip' AND validasi0 = 0");
                                            $jmldata = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Penggunaan Laboratorium';
                                                $verifikasi0 = $data['validasi0'];
                                                $verifikasi1 = $data['validasi1'];
                                                $verifikasi2 = $data['validasi2'];
                                                $verifikasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($verifikasi0 == 0) {
                                                        ?>
                                                            <a class="btn btn-info btn-sm" href="ijinlab-dosbing-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        <?php
                                                        };
                                                        ?>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin lab sebagai dosbing -->

                                            <!-- ijin lab sebagai kalab-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE validator1='$nip' AND validasi1 = 0 AND validasi0 = 1");
                                            $jmldata = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Penggunaan Laboratorium';
                                                $verifikasi1 = $data['validasi1'];
                                                $verifikasi2 = $data['validasi2'];
                                                $verifikasi3 = $data['validasi3'];
                                                $token = $data['token'];

                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($verifikasi1 == 0) {
                                                        ?>
                                                            <a class="btn btn-info btn-sm" href="ijinlab-kalab-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        <?php
                                                        };
                                                        ?>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin lab sebagai kalab -->

                                            <!-- ijin lab sebagai kaprodi-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE validator2='$nip' AND validasi2 = 0 AND validasi1=1");
                                            $jmldata = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Penggunaan Laboratorium';
                                                $verifikasi1 = $data['validasi1'];
                                                $verifikasi2 = $data['validasi2'];
                                                $verifikasi3 = $data['validasi3'];
                                                $token = $data['token'];

                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($verifikasi2 == 0) {
                                                        ?>
                                                            <a class="btn btn-info btn-sm" href="ijinlab-kaprodi-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        <?php
                                                        };
                                                        ?>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin lab sebagai kaprodi -->

                                            <!-- ijin lab sebagai WD-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            $jmldata = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Penggunaan Laboratorium';
                                                $verifikasi1 = $data['validasi1'];
                                                $verifikasi2 = $data['validasi2'];
                                                $verifikasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($verifikasi3 == 0) {
                                                        ?>
                                                            <a class="btn btn-info btn-sm" href="ijinlab-wd-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        <?php
                                                        };
                                                        ?>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin lab sebagai WD -->

                                            <!-- ijin penelitian as dosbing-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE validator1='$nip' AND validasi1 = 0");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Penelitian';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinpenelitian-dosen-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin penelitian as dosbing-->

                                            <!-- ijin penelitian as kaprodi-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE validator2='$nip' AND validasi2 = 0 AND validasi1=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Penelitian';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinpenelitian-kaprodi-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin penelitian as kaprodi-->

                                            <!-- ijin penelitian as WD-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Penelitian';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinpenelitian-wd-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin penelitian as WD-->

                                            <!-- ijin ujian offline as dosbing-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinujian WHERE validator1='$nip' AND validasi1 = 0");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Ujian Skripsi Offline';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinujian-dosen-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin ujian offline as dosbing-->

                                            <!-- ijin ujian offline as kaprodi-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinujian WHERE validator2='$nip' AND validasi2 = 0 AND validasi1=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Ujian Skripsi Offline';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinujian-kaprodi-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin ujian offline as kaprodi-->

                                            <!-- ijin ujian offline as WD-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinujian WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Ujian Skripsi Offline';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinujian-wd-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin ujian offline as WD-->

                                            <!-- ijin bimbingan offline as dosbing-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinbimbingan WHERE validator1='$nip' AND validasi1 = 0");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Bimbingan Offline';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinbimbingan-dosen-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin bimbingan offline as dosbing-->

                                            <!-- ijin bimbingan offline as kaprodi-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinbimbingan WHERE validator2='$nip' AND validasi2 = 0 AND validasi1=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Bimbingan Offline';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinbimbingan-kaprodi-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin bimbingan offline as kaprodi-->

                                            <!-- ijin bimbingan offline as WD-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinbimbingan WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Bimbingan Offline';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="ijinbimbingan-wd-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.ijin bimbingan offline as WD-->

                                            <!-- peminjaman alat as dosen-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM peminjamanalat WHERE validator1='$nip' AND validasi1 = 0");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Peminjaman Alat';
                                                $verifikasi1 = $data['validasi1'];
                                                $verifikasi2 = $data['validasi2'];
                                                $verifikasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="peminjamanalat-dosen-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /peminjaman alat as dosen-->

                                            <!-- peminjaman alat as kaprodi-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM peminjamanalat WHERE validator2='$nip' AND validasi2 = 0 AND validasi1=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Peminjaman Alat';
                                                $verifikasi1 = $data['validasi1'];
                                                $verifikasi2 = $data['validasi2'];
                                                $verifikasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="peminjamanalat-kaprodi-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /peminjaman alat as kaprodi-->

                                            <!-- peminjaman alat as wd-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM peminjamanalat WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Peminjaman Alat';
                                                $verifikasi1 = $data['validasi1'];
                                                $verifikasi2 = $data['validasi2'];
                                                $verifikasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="peminjamanalat-wd-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /peminjaman alat as wd-->

                                            <!-- Observasi as dosen-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE validator1='$nip' AND validasi1 = 0");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Observasi';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodi; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="observasi-dosen-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /Observasi as dosen-->

                                            <!-- Observasi as kaprodi-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE validator2='$nip' AND validasi2 = 0 AND validasi1=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Observasi';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="observasi-kaprodi-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /Observasi as kaprodi-->

                                            <!-- Observasi as WD-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Observasi';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="observasi-wd-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /Observasi as dosen-->

                                            <!-- pengambilan data as dosen -->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM pengambilandata WHERE validator1='$nip' AND validasi1 = 0");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Pengambilan Data';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="pengambilandata-dosen-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /pengambilandata -->

                                            <!-- pengambilan data as kajur -->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM pengambilandata WHERE validator2='$nip' AND validasi2 = 0 AND validasi1=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Pengambilan Data';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="pengambilandata-kaprodi-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /pengambilan data as kajur -->

                                            <!-- pengambilan data as wd -->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM pengambilandata WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Ijin Pengambilan Data';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="pengambilandata-wd-tampil.php?token=<?= $token; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /pengambilan data as wd -->

                                            <!-- Surat Keterangan as dosen wali-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM suket WHERE validator1='$nip' AND validasi1 = 0");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $$tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = $data['jenissurat'];
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="suket-dosen-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /Surat Keterangan as dosen wali-->

                                            <!-- Surat Keterangan as kaprodi-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM suket WHERE validator2='$nip' AND validasi2 = 0");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = $data['jenissurat'];
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="suket-kaprodi-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /Surat Keterangan as kaprodi-->

                                            <!-- Surat Keterangan as WD-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM suket WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = $data['jenissurat'];
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="suket-wd-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /Surat Keterangan as WD-->

                                            <!-- SKPI as Dosen PA -->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE verifikator1='$nip' AND verifikasi1='0'");
                                            $jdata = mysqli_num_rows($query);
                                            if ($jdata > 0) {
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tanggal'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $nim = $data['nim'];
                                                    $surat = "Surat Keterangan Pendamping Ijazah";
                                                    $verifikasi1 = $data['verifikasi1'];
                                                    $verifikasi2 = $data['verifikasi2'];
                                                    $verifikasi3 = $data['verifikasi3'];
                                            ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="skpi-dosen-tampil.php?nim=<?= mysqli_real_escape_string($dbsurat, $nim); ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                            <?php
                                                    $no++;
                                                }
                                            }
                                            ?>
                                            <!-- /SKPI as Dosen PA -->

                                            <!-- SKPI as kaprodi -->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE verifikator2='$nip'AND verifikasi2=0 AND verifikasi1=1");
                                            $jdata = mysqli_num_rows($query);
                                            if ($jdata > 0) {
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tanggal'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $nim = $data['nim'];
                                                    $surat = "Surat Keterangan Pendamping Ijazah";
                                                    $verifikasi1 = $data['verifikasi1'];
                                                    $verifikasi2 = $data['verifikasi2'];
                                                    $verifikasi3 = $data['verifikasi3'];
                                            ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="skpi-kaprodi-tampil.php?nim=<?= mysqli_real_escape_string($dbsurat, $nim); ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                            <?php
                                                    $no++;
                                                }
                                            }
                                            ?>
                                            <!-- /SKPI as kaprodi -->

                                            <!-- SKPI as WD -->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE verifikator3='$nip'AND verifikasi3=0 AND verifikasi2=1");
                                            $jdata = mysqli_num_rows($query);
                                            if ($jdata > 0) {
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tanggal'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $nim = $data['nim'];
                                                    $surat = "Surat Keterangan Pendamping Ijazah";
                                                    $verifikasi1 = $data['verifikasi1'];
                                                    $verifikasi2 = $data['verifikasi2'];
                                                    $verifikasi3 = $data['verifikasi3'];
                                            ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="skpi-wd-tampil.php?nim=<?= mysqli_real_escape_string($dbsurat, $nim); ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                            <?php
                                                    $no++;
                                                }
                                            }
                                            ?>
                                            <!-- /SKPI as WD -->

                                            <!-- cetak KHS as kajur-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM cetakkhs WHERE validator2='$nip' AND validasi2 = 0");
                                            $jmldata = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Permohonan Cetak KHS';
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="cetakkhs-kaprodi-tampil.php?nodata=<?= $nodata; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.Cetak KHS as kajur-->

                                            <!-- cetak KHS as WD-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM cetakkhs WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            $jmldata = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $prodi = $data['prodi'];
                                                $surat = 'Permohonan Cetak KHS';
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="cetakkhs-wd-tampil.php?nodata=<?= $nodata; ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /.Cetak KHS as wd-->

                                            <!-- penghargaan as kaprodi-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE validator2='$nip' AND validasi2 = 0");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Penghargaan';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="penghargaan-kaprodi-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /penghargaan as kaprodi-->

                                            <!-- penghargaan as WD-->
                                            <?php
                                            $query = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nodata = $data['no'];
                                                $tanggal = $data['tanggal'];
                                                $prodimhs = $data['prodi'];
                                                $nama = $data['nama'];
                                                $surat = 'Penghargaan';
                                                $validasi1 = $data['validasi1'];
                                                $validasi2 = $data['validasi2'];
                                                $validasi3 = $data['validasi3'];
                                                $token = $data['token'];
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $surat; ?></td>
                                                    <td><?= $nama; ?></td>
                                                    <td><?= $prodimhs; ?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="penghargaan-wd-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><?= tgl_indo($tanggal); ?></td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                            <!-- /penghargaan as WD-->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- pengajuan bawahan -->
                        <?php
                        if ($jabatan == 'dekan' or $jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
                        ?>
                            <!-- Pengajuan Bawahan -->
                            <div class="col">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan Surat Bawahan</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <?php $no = 1; ?>
                                    <div class="card-body">
                                        <table id="example3" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <td style="text-align:center">No</td>
                                                    <td style="text-align:center">Surat</td>
                                                    <td style="text-align:center">Nama</td>
                                                    <td style="text-align:center">PRODI</td>
                                                    <td style="text-align:center">Aksi</td>
                                                    <td style="text-align:center">Tgl. Pengajuan</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- WFH as kaprodi -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE verifikatorprodi='$nip' AND verifikasiprodi = 0 and verifikasifakultas=0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Izin WFH';
                                                    $verifikasiprodi = $data['verifikasiprodi'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="wfh-atasan-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. WFH as kaprodi-->

                                                <!-- WFH as WD -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE verifikatorfakultas='$nip' AND verifikasiprodi=1 and verifikasifakultas = 0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Izin WFH';
                                                    $verifikasifakultas = $data['verifikasifakultas'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="wfh-wd-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. WFH as WD-->

                                                <!-- Surattugas as kaprodi -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE validator1='$nip' AND validasi1 = 0 and validasi2=0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Tugas';
                                                    $validasi1 = $data['validasi1'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="surattugas-atasan-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. surat tugas as kaprodi-->

                                                <!-- surat tugas as WD -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE validator2='$nip' AND validasi1=1 and validasi2 = 0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Tugas';
                                                    $validasi2 = $data['validasi2'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="surattugas-dekan-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. surat tugas as WD-->

                                                <!-- izin as kaprodi -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM izin WHERE validator1='$nip' AND validasi1 = 0 and validasi2=0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Izin';
                                                    $validasi1 = $data['validasi1'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="izin-kaprodi-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. izin as kaprodi-->

                                                <!-- cuti as kaprodi -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE validator1='$nip' AND validasi1 = 0 and validasi2=0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Izin';
                                                    $validasi1 = $data['validasi1'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="cuti-kaprodi-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. izin as kaprodi-->

                                                <!-- cuti as dekan -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE validator2='$nip' AND validasi1 = 1 and validasi2=0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Izin';
                                                    $validasi1 = $data['validasi1'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="cuti-dekan-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. izin as kaprodi-->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- tabel disposisi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- Pengajuan Pribadi -->
                        <div class="col-sm">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Pengajuan Surat Pribadi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <table id="example5" class="table table-bordered table-hover text-sm">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">No</th>
                                                    <th style="text-align: center;">Jenis Surat</th>
                                                    <th style="text-align: center;">Status Surat</th>
                                                    <th style="text-align: center;">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- surat tugas-->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE nip='$nip' ORDER BY tglsurat DESC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $jenissurat = 'Surat Tugas';
                                                    $keterangan = $data['keterangan'];
                                                    $validasi1 = $data['validasi1'];
                                                    $validator1 = $data['validator1'];
                                                    $validasi2 = $data['validasi2'];
                                                    $validator2 = $data['validator2'];
                                                    $statussurat = $data['statussurat'];
                                                    $keterangan = $data['keterangan'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $jenissurat; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($validasi1 == 0) {
                                                                echo 'menunggu verifikasi ' . namadosen($dbsurat, $validator1);
                                                            } elseif ($validasi1 == 1) {
                                                                echo 'telah disetujui ' . namadosen($dbsurat, $validator1);
                                                            } elseif ($validasi1 == 2) {
                                                                echo 'ditolak oleh ' . namadosen($dbsurat, $validator1) . 'dengan alasan <b>' . $keterangan . '</b>';
                                                            }
                                                            ?>
                                                            <br />
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                                echo 'menunggu verifikasi ' . namadosen($dbsurat, $validator2);
                                                            } elseif ($validasi2 == 1) {
                                                                echo 'telah disetujui ' . namadosen($dbsurat, $validator2);
                                                            } elseif ($validasi2 == 2) {
                                                                echo 'ditolak oleh ' . namadosen($dbsurat, $validator2) . 'dengan alasan <b>' . $keterangan . '</b>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 2 or $statussurat == 0) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="surattugas-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="surattugas-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                                <a class="btn btn-primary btn-sm" href="surattugas-bukti.php?token=<?= $token; ?>">
                                                                    <i class="fa fa-upload" aria-hidden="true"></i> Upload Bukti
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 3) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="surattugas-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>

                                                <!-- Izin-->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM izin WHERE nip='$nip' ORDER BY tglizin1 DESC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $jenissurat = 'Surat Izin';
                                                    $keterangan = $data['keterangan'];
                                                    $validasi1 = $data['validasi1'];
                                                    $validator1 = $data['validator1'];
                                                    $validasi2 = $data['validasi2'];
                                                    $validator2 = $data['validator2'];
                                                    $statussurat = $data['statussurat'];
                                                    $keterangan = $data['keterangan'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $jenissurat; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($validasi1 == 0) {
                                                                echo 'menunggu verifikasi ' . namadosen($dbsurat, $validator1);
                                                            } elseif ($validasi1 == 1) {
                                                                echo 'telah disetujui ' . namadosen($dbsurat, $validator1);
                                                            } elseif ($validasi1 == 2) {
                                                                echo 'ditolak oleh ' . namadosen($dbsurat, $validator1) . 'dengan alasan <b>' . $keterangan . '</b>';
                                                            }
                                                            ?>
                                                            <br />
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                                echo 'menunggu verifikasi ' . namadosen($dbsurat, $validator2);
                                                            } elseif ($validasi2 == 1) {
                                                                echo 'telah disetujui ' . namadosen($dbsurat, $validator2);
                                                            } elseif ($validasi2 == 2) {
                                                                echo 'ditolak oleh ' . namadosen($dbsurat, $validator2) . 'dengan alasan <b>' . $keterangan . '</b>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 2 or $statussurat == 0) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="izin-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="izin-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- Izin-->

                                                <!-- cuti as dosen -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE nip='$nip' ORDER BY tglizin1 DESC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $jenissurat = 'Surat Izin Cuti';
                                                    $keterangan = $data['keterangan'];
                                                    $validasi1 = $data['validasi1'];
                                                    $validator1 = $data['validator1'];
                                                    $validasi2 = $data['validasi2'];
                                                    $validator2 = $data['validator2'];
                                                    $statussurat = $data['statussurat'];
                                                    $keterangan = $data['keterangan'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $jenissurat; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($validasi1 == 0) {
                                                                echo 'menunggu verifikasi ' . namadosen($dbsurat, $validator1);
                                                            } elseif ($validasi1 == 1) {
                                                                echo 'telah disetujui ' . namadosen($dbsurat, $validator1);
                                                            } elseif ($validasi1 == 2) {
                                                                echo 'ditolak oleh ' . namadosen($dbsurat, $validator1) . 'dengan alasan <b>' . $keterangan . '</b>';
                                                            }
                                                            ?>
                                                            <br />
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                                echo 'menunggu verifikasi ' . namadosen($dbsurat, $validator2);
                                                            } elseif ($validasi2 == 1) {
                                                                echo 'telah disetujui ' . namadosen($dbsurat, $validator2);
                                                            } elseif ($validasi2 == 2) {
                                                                echo 'ditolak oleh ' . namadosen($dbsurat, $validator2) . 'dengan alasan <b>' . $keterangan . '</b>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 2 or $statussurat == 0) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="cuti-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="cuti-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>

                                                <!-- pengajuan WFH-->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE nip='$nip' and year(tglsurat) = $tahun ORDER BY tglwfh1 DESC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tglwfh1 = $data['tglwfh1'];
                                                    $tglwfh2 = $data['tglwfh2'];
                                                    $tglwfh3 = $data['tglwfh3'];
                                                    $tglwfh4 = $data['tglwfh4'];
                                                    $tglwfh5 = $data['tglwfh5'];
                                                    $verifikasiprodi = $data['verifikasiprodi'];
                                                    $verifikatorprodi = $data['verifikatorprodi'];
                                                    $verifikasifakultas = $data['verifikasifakultas'];
                                                    $verifikatorfakultas = $data['verifikatorfakultas'];
                                                    $jenissurat = 'Izin WFH';
                                                    $keterangan = $data['keterangan'];
                                                    $token = $data['token'];
                                                    if (date($tglwfh5) != 0) {
                                                        $wfhselesai = $tglwfh5;
                                                    } else {
                                                        if (date($tglwfh4) != 0) {
                                                            $wfhselesai = $tglwfh4;
                                                        } else {
                                                            if (date($tglwfh3) != 0) {
                                                                $wfhselesai = $tglwfh3;
                                                            } else {
                                                                if (date($tglwfh2) != 0) {
                                                                    $wfhselesai = $tglwfh2;
                                                                }
                                                            }
                                                        }
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $jenissurat; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($verifikasiprodi == 0) {
                                                            ?>
                                                                Menunggu verifikasi <?= namadosen($dbsurat, $verifikatorprodi); ?>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasiprodi == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="wfh-cetakrk.php?nodata=<?= $nodata; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak Rencana Kerja
                                                                </a>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasiprodi == 2) {
                                                            ?>
                                                                Ditolak oleh <?= namadosen($dbsurat, $verifikatorprodi); ?>
                                                            <?php
                                                            };
                                                            ?>
                                                            <br />
                                                            <?php
                                                            if ($verifikasifakultas == 0) {
                                                            ?>
                                                                Menunggu verifikasi <?= namadosen($dbsurat, $verifikatorfakultas); ?>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasifakultas == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="wfh-cetakst.php?nodata=<?= $nodata; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak Surat Tugas
                                                                </a>
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasifakultas == 2) {
                                                            ?>
                                                                Ditolak oleh <?= namadosen($dbsurat, $verifikatorfakultas); ?>
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?= $keterangan; ?>
                                                            <br />
                                                            <?php
                                                            if ($verifikasifakultas <> 1) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="wfh-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            };
                                                            ?>
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
            $('#example4').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            $('#example5').DataTable({
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
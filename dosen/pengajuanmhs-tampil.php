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

            <!-- Main content -->
            <section class="content">

                <!-- Pengajuan Surat Mahasiswa -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Pengajuan Surat Mahasiswa</h3>
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
                        <table id="example2" class="table table-bordered table-hover text-sm">
                            <thead>
                                <tr>
                                    <td style="text-align:center">No</td>
                                    <td style="text-align:center">Surat</td>
                                    <td style="text-align:center">Nama</td>
                                    <td style="text-align:center">PRODI</td>
                                    <td style="text-align:center">Tgl. Pengajuan</td>
                                    <td style="text-align:center">Aksi</td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= 'Surat Pengantar ' . $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="pkl-koor-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= 'Surat Pengantar ' . $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="pkl-kaprodi-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= 'Surat Pengantar ' . $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="pkl-wd-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <?php
                                            if ($verifikasi0 == 0) {
                                            ?>
                                                <a class="btn btn-info btn-sm" href="ijinlab-dosbing-tampil.php?nodata=<?= $nodata; ?>">
                                                    <i class="fas fa-eye"></i> Lihat
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <?php
                                            if ($verifikasi1 == 0) {
                                            ?>
                                                <a class="btn btn-info btn-sm" href="ijinlab-kalab-tampil.php?nodata=<?php echo $nodata; ?>">
                                                    <i class="fas fa-eye"></i> Lihat
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <?php
                                            if ($verifikasi2 == 0) {
                                            ?>
                                                <a class="btn btn-info btn-sm" href="ijinlab-kaprodi-tampil.php?nodata=<?php echo $nodata; ?>">
                                                    <i class="fas fa-eye"></i> Lihat
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <?php
                                            if ($verifikasi3 == 0) {
                                            ?>
                                                <a class="btn btn-info btn-sm" href="ijinlab-wd-tampil.php?nodata=<?php echo $nodata; ?>">
                                                    <i class="fas fa-eye"></i> Lihat
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="ijinpenelitian-dosen-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="ijinpenelitian-kaprodi-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="ijinpenelitian-wd-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="ijinujian-dosen-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="ijinujian-kaprodi-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="ijinujian-wd-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="ijinbimbingan-dosen-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="ijinbimbingan-kaprodi-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="ijinbimbingan-wd-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="peminjamanalat-dosen-tampil.php?nodata=<?= $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="peminjamanalat-kaprodi-tampil.php?nodata=<?= $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="peminjamanalat-wd-tampil.php?nodata=<?= $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodi; ?></td>
                                        <td><?= tgl_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="observasi-dosen-tampil.php?nodata=<?php echo mysqli_real_escape_string($dbsurat, $nodata); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                    $tanggal = ['tanggal'];
                                    $prodimhs = $data['prodi'];
                                    $nama = $data['nama'];
                                    $surat = 'Ijin Observasi';
                                    $validasi1 = $data['validasi1'];
                                    $validasi2 = $data['validasi2'];
                                    $validasi3 = $data['validasi3'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgl_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="observasi-kaprodi-tampil.php?nodata=<?php echo mysqli_real_escape_string($dbsurat, $nodata); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgl_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="observasi-wd-tampil.php?nodata=<?php echo mysqli_real_escape_string($dbsurat, $nodata); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="pengambilandata-dosen-tampil.php?nodata=<?php echo mysqli_real_escape_string($dbsurat, $nodata); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="pengambilandata-kaprodi-tampil.php?nodata=<?php echo mysqli_real_escape_string($dbsurat, $nodata); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="pengambilandata-wd-tampil.php?nodata=<?php echo mysqli_real_escape_string($dbsurat, $nodata); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="suket-dosen-tampil.php?nodata=<?php echo mysqli_real_escape_string($dbsurat, $nodata); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="suket-kaprodi-tampil.php?nodata=<?php echo mysqli_real_escape_string($dbsurat, $nodata); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $surat; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $prodimhs; ?></td>
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="suket-wd-tampil.php?nodata=<?php echo mysqli_real_escape_string($dbsurat, $nodata); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                            <td><?= tgljam_indo($tanggal); ?></td>
                                            <td>
                                                <a class="btn btn-info btn-sm" href="skpi-dosen-tampil.php?nim=<?= mysqli_real_escape_string($dbsurat, $nim); ?>">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
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
                                            <td><?= tgljam_indo($tanggal); ?></td>
                                            <td>
                                                <a class="btn btn-info btn-sm" href="skpi-kaprodi-tampil.php?nim=<?= mysqli_real_escape_string($dbsurat, $nim); ?>">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
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
                                            <td><?= tgljam_indo($tanggal); ?></td>
                                            <td>
                                                <a class="btn btn-info btn-sm" href="skpi-wd-tampil.php?nim=<?= mysqli_real_escape_string($dbsurat, $nim); ?>">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
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
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="cetakkhs-kaprodi-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
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
                                        <td><?= tgljam_indo($tanggal); ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="cetakkhs-wd-tampil.php?nodata=<?php echo $nodata; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /.Cetak KHS as wd-->
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

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
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

            <!-- notifications -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- pengajuan bawahan -->
                        <?php
                        if ($jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
                            $qwfh = mysqli_query($dbsurat, "SELECT * FROM wfh WHERE verifikatorprodi='$nip' AND verifikasiprodi = 0 and verifikasifakultas=0");
                            $jwfh = mysqli_num_rows($qwfh);
                            $qst = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE validator1='$nip' AND validasi1 = 0 and validasi2=0");
                            $jst = mysqli_num_rows($qst);
                            $tbawahan = $jwfh + $jst;

                        ?>
                            <!--
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
                        -->
                        <?php
                        }
                        ?>
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

                    </div>
                </div>
            </section>

            <!-- tabel pengajuan mahasiswa -->
            <?php
            if ($jabatan == 'bagumum') {
            ?>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Pengajuan Mahasiswa -->
                            <div class="col-sm">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan Surat Mahasiswa</h3>
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
                                                    <td style="text-align:center">Aksi</td>
                                                    <td style="text-align:center">PRODI</td>
                                                    <td style="text-align:center">Tgl. Pengajuan</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- SK Narsum-->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='narasumber' AND verifikator2='$nip' AND verifikasi2 = 0 AND verifikasi1 = 1");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tanggal'];
                                                    $nimmhs = $data['nim'];
                                                    $prodimhs = $data['prodi'];
                                                    $jenissk = $data['jenissk'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td>Pengajuan SK <?= $jenissk; ?></td>
                                                        <td><?= namadosen($dbsurat, $nimmhs); ?></td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-info btn-sm" href="sknarsum-bagumum-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /SK Narsum-->

                                                <!-- SK panitia-->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='panitia' AND verifikator2='$nip' AND verifikasi2 = 0 AND verifikasi1 = 1");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tanggal'];
                                                    $nimmhs = $data['nim'];
                                                    $prodimhs = $data['prodi'];
                                                    $jenissk = $data['jenissk'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td>Pengajuan SK <?= $jenissk; ?></td>
                                                        <td><?= namadosen($dbsurat, $nimmhs); ?></td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-info btn-sm" href="skpanitia-bagumum-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /SK panitia-->

                                                <!-- SK panitia-->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM sk WHERE jenissk='peserta' AND verifikator2='$nip' AND verifikasi2 = 0 AND verifikasi1 = 1");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tanggal'];
                                                    $nimmhs = $data['nim'];
                                                    $prodimhs = $data['prodi'];
                                                    $jenissk = $data['jenissk'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td>Pengajuan SK <?= $jenissk; ?></td>
                                                        <td><?= namadosen($dbsurat, $nimmhs); ?></td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-info btn-sm" href="skpeserta-bagumum-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td><?= tgl_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /SK panitia-->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php
            }
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        if ($jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
                        ?>
                            <!-- Pengajuan Bawahan -->
                            <div class="col-sm">
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
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. WFH as kaprodi-->

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
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. surat tugas as kaprodi-->

                                                <!-- izin as atasan -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM izin WHERE validator1='$nip' AND validasi1=0 and validasi2 = 0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Izin';
                                                    $validasi2 = $data['validasi2'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="izin-atasan-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. izin as atasan-->


                                                <!-- izin as kabag-tu -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM izin WHERE validator2='$nip' AND validasi1=1 and validasi2 = 0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Izin';
                                                    $validasi2 = $data['validasi2'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="izin-kabag-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. izin as kabag tu-->

                                                <!-- izin as atasan -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE validator1='$nip' AND validasi1=0 and validasi2 = 0 order by tglsurat desc");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tglsurat'];
                                                    $prodimhs = $data['prodi'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Surat Izin';
                                                    $validasi2 = $data['validasi2'];
                                                    $token = $data['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td><?= $nama; ?></td>
                                                        <td><?= $prodimhs; ?></td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="cuti-atasan-tampil.php?token=<?= $token; ?>">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                        <td><?= tgljam_indo($tanggal); ?></td>
                                                    </tr>
                                                <?php
                                                    $no++;
                                                }
                                                ?>
                                                <!-- /. izin as atasan-->

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

            <!-- Setting SKPI -->
            <?php
            $qoperatorskpi = mysqli_query($dbsurat, "SELECT * FROM skpi_operator WHERE kode='$nip'");
            $joperatorskpi = mysqli_num_rows($qoperatorskpi);
            if ($joperatorskpi > 0) {
            ?>

                <!-- tabel pengajuan SKPI -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan SKPI Mahasiswa</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <?php $no = 1; ?>
                                    <div class="card-body p-0">
                                        <div class="card-body">
                                            <table id="example2" class="table table-bordered table-hover text-sm">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" style="text-align: center;">No</th>
                                                        <th style="text-align: center;">Tgl. Pengajuan</th>
                                                        <th style="text-align: center;">Nama</th>
                                                        <th style="text-align: center;">NIM</th>
                                                        <th width="20%" style="text-align: center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = mysqli_query($dbsurat, "SELECT no, nim, nama FROM skpi_prestasipenghargaan WHERE verifikasi1='1' AND verifikasi2='1' AND verifikasi3='1' AND prodi='$prodi' AND year(tanggal)='$tahun' ORDER BY tanggal");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $nodata = $data['no'];
                                                        $tanggal = $data['tanggal'];
                                                        $nim = $data['nim'];
                                                        $nama = $data['nama'];
                                                    ?>
                                                        <tr>
                                                            <td><?= $no; ?></td>
                                                            <td><?= tgl_indo($tanggal); ?></td>
                                                            <td><?= $nama; ?></td>
                                                            <td><?= $nim; ?></td>
                                                            <td style="text-align: center;">
                                                                <a class="btn btn-info btn-sm" href="skpi-detail.php?nim=<?= $nim; ?>">
                                                                    <i class="fas fa-magnifying"></i> Detail
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
                            </div>
                        </div>
                    </div>
                </section>
            <?php
            }
            ?>

            <!-- tabel pengajuan pribadi -->
            <?php
            if ($hakakses == 'tendik' && $user <> 'bagianumum') {
            ?>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary">
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
                                            <table id="example2" class="table table-bordered table-hover text-sm">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" style="text-align: center;">No</th>
                                                        <th width="20%" style="text-align: center;">Jenis Surat</th>
                                                        <th style="text-align: center;">Status Surat</th>
                                                        <th width="20%" style="text-align: center;">Keterangan</th>
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
                                                    <!-- Cuti-->
                                                    <?php
                                                    $query = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE nip='$nip' ORDER BY tglizin1 DESC");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $nodata = $data['no'];
                                                        $jenissurat = 'Surat Cuti';
                                                        $keterangan = $data['keterangan'];
                                                        $validasi1 = $data['validasi1'];
                                                        $validator1 = $data['validator1'];
                                                        $validasi2 = $data['validasi2'];
                                                        $validator2 = $data['validator2'];
                                                        $keterangan = $data['keterangan'];
                                                        $token = $data['token'];
                                                        $statussurat = $data['statussurat'];
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
                                                        $keterangan = $data['keterangan'];
                                                        $token = $data['token'];
                                                        $statussurat = $data['statussurat'];
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
                                                                    <a class="btn btn-success btn-sm" href="wfh-cetakrk.php?nodata=<?php echo $nodata; ?>" target="_blank">
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
                                                                    <a class="btn btn-success btn-sm" href="wfh-cetakst.php?nodata=<?php echo $nodata; ?>" target="_blank">
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
            <?php
            }
            ?>

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
        });
    </script>
</body>

</html>
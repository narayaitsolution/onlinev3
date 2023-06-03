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

            <!-- Registrasi User baru -->
            <?php
            if ($nip == '198312132019031004') {
            ?>
                <div class="col">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Registrasi User Baru</h3>
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
                                        <td style="text-align:center">NIM</td>
                                        <td style="text-align:center">Nama</td>
                                        <td style="text-align:center">PRODI</td>
                                        <td style="text-align:center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE aktif=0");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $nodata = $data['no'];
                                        $nama = stripslashes($data['nama']);
                                        $nim = $data['nip'];
                                        $prodi = $data['prodi'];
                                        $token = $data['token'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $nim; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td><?= $prodi; ?></td>
                                            <td>
                                                <a class="btn btn-info btn-sm" href="daftar-aktifkan.php?token=<?= $token; ?>" onclick="return confirm('Apakah anda yakin mengaktifkan akun ini ?')">
                                                    <i class="fas fa-eye"></i> Aktifkan
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>


            <!-- pengajuan bawahan -->
            <?php
            if ($jabatan == 'dekan' or $jabatan == 'wadek3' or $jabatan == 'wadek2' or $jabatan == 'wadek1' or $jabatan == 'kaprodi' or $jabatan == 'kabag-tu') {
            ?>
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
                                        $nama = stripslashes($data['nama']);
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
                                        $nama = stripslashes($data['nama']);
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
                                        $nama = stripslashes($data['nama']);
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
                                        $nama = stripslashes($data['nama']);
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
                                        $nama = stripslashes($data['nama']);
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
                                        $nama = stripslashes($data['nama']);
                                        $surat = 'Pengajuan Cuti';
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
                                        $nama = stripslashes($data['nama']);
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

            <!-- tabel pengajuan bawahan & mahasiswa -->
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
                        <table id="example1" class="table table-bordered table-hover text-sm">
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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

                                <!-- magang as Kaprodi-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM magang WHERE validator2='$nip' AND validasi2 = 0");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $prodimhs = $data['prodi'];
                                    $nama = stripslashes($data['nama']);
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
                                            <a class="btn btn-info btn-sm" href="magang-kaprodi-tampil.php?token=<?= $token; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                        <td><?= tgl_indo($tanggal); ?></td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /. magang as kaprodi-->

                                <!-- magang as WD-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM magang WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $prodimhs = $data['prodi'];
                                    $nama = stripslashes($data['nama']);
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
                                            <a class="btn btn-info btn-sm" href="magang-wd-tampil.php?token=<?= $token; ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                        <td><?= tgl_indo($tanggal); ?></td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /. magang as WD-->

                                <!-- ijin lab sebagai dosbing-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE validator0='$nip' AND validasi0 = 0");
                                $jmldata = mysqli_num_rows($query);
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $prodimhs = $data['prodi'];
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                        $nama = stripslashes($data['nama']);
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
                                        $nama = stripslashes($data['nama']);
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
                                        $nim = $data['nim'];
                                        $tanggal = $data['tanggal'];
                                        $prodimhs = $data['prodi'];
                                        $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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
                                    $nama = stripslashes($data['nama']);
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

                                <!-- delegasi as kaprodi-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE validator1='$nip' AND validasi1 = 0");
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $prodimhs = $data['prodi'];
                                    $nama = stripslashes($data['nama']);
                                    $surat = 'Delegasi';
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
                                            <a class="btn btn-info btn-sm" href="delegasi-kaprodi-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                        <td><?= tgl_indo($tanggal); ?></td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /delegasi as kaprodi-->

                                <!-- delegasi as koorodinator-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE validator2='$nip' AND validasi2 = 0");
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $prodimhs = $data['prodi'];
                                    $nama = stripslashes($data['nama']);
                                    $surat = 'Delegasi';
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
                                            <a class="btn btn-info btn-sm" href="delegasi-koor-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                        <td><?= tgl_indo($tanggal); ?></td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /delegasi as kaprodi-->

                                <!-- delegasi as WD-->
                                <?php
                                $query = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE validator3='$nip' AND validasi3 = 0 AND validasi2=1");
                                while ($data = mysqli_fetch_array($query)) {
                                    $nodata = $data['no'];
                                    $tanggal = $data['tanggal'];
                                    $prodimhs = $data['prodi'];
                                    $nama = stripslashes($data['nama']);
                                    $surat = 'Delegasi';
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
                                            <a class="btn btn-info btn-sm" href="delegasi-wd-tampil.php?token=<?= mysqli_real_escape_string($dbsurat, $token); ?>">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                        <td><?= tgl_indo($tanggal); ?></td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                                <!-- /delegasi as WD-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pengajuan Pribadi -->
            <div class="col">
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
                                        $tglvalidasi1 = $data['tglvalidasi1'];
                                        $validator1 = $data['validator1'];
                                        $validasi2 = $data['validasi2'];
                                        $tglvalidasi2 = $data['tglvalidasi2'];
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
                                                    echo 'telah disetujui ' . namadosen($dbsurat, $validator1) . ' pada ' . tgl_indo($tglvalidasi1);
                                                } elseif ($validasi1 == 2) {
                                                    echo 'ditolak oleh ' . namadosen($dbsurat, $validator1) . 'dengan alasan <b>' . $keterangan . '</b>';
                                                }
                                                ?>
                                                <br />
                                                <?php
                                                if ($validasi2 == 0) {
                                                    echo 'menunggu verifikasi ' . namadosen($dbsurat, $validator2);
                                                } elseif ($validasi2 == 1) {
                                                    echo 'telah disetujui ' . namadosen($dbsurat, $validator2) . ' pada ' . tgl_indo($tglvalidasi1);;
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
                                        $jenissurat = 'Surat Cuti';
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
    <script type="text/javascript" src="DataTables/datatables.min.js"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": ["excel", "pdf", "print", "colvis"]
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
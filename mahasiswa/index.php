<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
$user = $_SESSION['user'];
$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "mahasiswa") {
    header("location:../deauth.php");
}
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

            <!-- alert bukti vaksin -->
            <?php
            $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip=$nim");
            $qdata = mysqli_fetch_array($quser);
            $buktivaksin = $qdata['buktivaksin'];
            if (empty($buktivaksin)) {
                echo "<script>alert('Segera upload bukti vaksin terakhir pada profil pengguna!!')</script>";
            }
            ?>

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pengajuan Surat Pribadi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
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
                                                    <th width="20%" style="text-align: center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- ijin lab -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE nim='$nim'");
                                                $jmldata = mysqli_num_rows($query);
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $nodata = $data['no'];
                                                    $tanggal = $data['tanggal'];
                                                    $nim = $data['nim'];
                                                    $nama = $data['nama'];
                                                    $surat = 'Ijin Penggunaan Laboratorium';
                                                    $validator0 = $data['validator0'];
                                                    $validasi0 = $data['validasi0'];
                                                    $tglvalidasi0 = tgl_indo($data['tglvalidasi0']);
                                                    $validator1 = $data['validator1'];
                                                    $validasi1 = $data['validasi1'];
                                                    $tglvalidasi1 = tgl_indo($data['tglvalidasi1']);
                                                    $validasi2 = $data['validasi2'];
                                                    $validator2 = $data['validator2'];
                                                    $tglvalidasi2 = tgl_indo($data['tglvalidasi2']);
                                                    $validasi3 = $data['validasi3'];
                                                    $validator3 = $data['validator3'];
                                                    $tglvalidasi3 = tgl_indo($data['tglvalidasi3']);
                                                    $keterangan = $data['keterangan'];
                                                    $statussurat = $data['statuspengajuan'];
                                                    $token = $data['token'];

                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $surat; ?></td>
                                                        <td>
                                                            <!-- data belum lengkap -->
                                                            <?php
                                                            if ($statussurat == -1) {
                                                            ?>
                                                                <p style="color:red">Data belum lengkap</p>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <!-- dosen pembimbing -->
                                                                <?php
                                                                if ($validasi0 == 0) {
                                                                ?>
                                                                    Menunggu verifikasi Dosen Pembimbing <?= namadosen($dbsurat, $validator0); ?><br />
                                                                <?php
                                                                } elseif ($validasi0 == 1) {
                                                                ?>
                                                                    Telah disetujui Dosen Pembimbing <?= namadosen($dbsurat, $validator0); ?> <br />
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    Ditolak Dosen Pembimbing <?= namadosen($dbsurat, $validator0); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b><br />
                                                                <?php
                                                                };
                                                                ?>
                                                                <!-- kepala lab -->
                                                                <?php
                                                                if ($validasi1 == 0) {
                                                                ?>
                                                                    Menunggu verifikasi Kepala Lab. <?= namadosen($dbsurat, $validator1); ?><br />
                                                                <?php
                                                                } elseif ($validasi1 == 1) {
                                                                ?>
                                                                    Telah disetujui Kepala Lab. <?= namadosen($dbsurat, $validator1); ?> <br />
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    Ditolak Kepala Lab. <?= namadosen($dbsurat, $validator1); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b><br />
                                                                <?php
                                                                };
                                                                ?>
                                                                <!-- ketua jurusan -->
                                                                <?php
                                                                if ($validasi2 == 0) {
                                                                ?>
                                                                    Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                                <?php
                                                                } elseif ($validasi2 == 1) {
                                                                ?>
                                                                    Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b><br />
                                                                <?php
                                                                };
                                                                ?>
                                                                <!-- WD-1 -->
                                                                <?php
                                                                if ($validasi3 == 0) {
                                                                ?>
                                                                    Menunggu verifikasi Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?><br />
                                                                <?php
                                                                } elseif ($validasi3 == 1) {
                                                                ?>
                                                                    Telah disetujui Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> <br />
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    Ditolak oleh Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b></b><br />
                                                            <?php
                                                                }
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == -1) {
                                                            ?>
                                                                <a class="btn btn-info btn-sm" href="ijinlab-isi2.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-file"></i>
                                                                    Lengkapi
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="ijinlab-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="ijinlab-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i>
                                                                    Cetak Surat Izin
                                                                </a>
                                                                <a class="btn btn-success btn-sm" href="ijinlab-cetakidcard.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i>
                                                                    Cetak ID Card
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 0) {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="ijinlab-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="ijinlab-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <!-- /ijin lab -->

                                                <?php
                                                    $no++;
                                                }
                                                ?>

                                                <!-- Ijin PKL -->
                                                <?php
                                                $query1 = mysqli_query($dbsurat, "SELECT * FROM pklanggota WHERE nimanggota = '$nim'");
                                                $jquery1 = mysqli_num_rows($query1);
                                                if ($jquery1 > 0) {
                                                    $dquery1 = mysqli_fetch_array($query1);
                                                    $nimketuapkl = $dquery1['nimketua'];
                                                } else {
                                                    $nimketuapkl = $nim;
                                                }

                                                $query2 = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE nim = '$nimketuapkl'");
                                                while ($q = mysqli_fetch_array($query2)) {
                                                    $nodata = $q['no'];
                                                    $nimketua = $q['nim'];
                                                    $namaketua =  $q['nama'];
                                                    $validasi1 = $q['validasi1'];
                                                    $validator1 = $q['validator1'];
                                                    $tglvalidasi1 = $q['tglvalidasi1'];
                                                    $validasi2 = $q['validasi2'];
                                                    $validator2 = $q['validator2'];
                                                    $tglvalidasi2 = $q['tglvalidasi2'];
                                                    $validasi3 = $q['validasi3'];
                                                    $validator3 = $q['validator3'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $keterangan = $q['keterangan'];
                                                    $statussurat = $q['statussurat'];
                                                    $pklmagang = $q['pklmagang'];
                                                    $token = $q['token'];
                                                ?>

                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td>Surat Pengantar <?= $pklmagang; ?> <br />
                                                            Ketua <?= $namaketua; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == -1) {
                                                            ?>
                                                                <p style="color:red">Data belum lengkap</p>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <!-- koordinator PKL -->
                                                                <?php
                                                                if ($validasi1 == 0) {
                                                                ?>
                                                                    Menunggu verifikasi Dosen Koordinator PKL <?= namadosen($dbsurat, $validator1); ?><br />
                                                                <?php
                                                                } elseif ($validasi1 == 1) {
                                                                ?>
                                                                    Telah disetujui Dosen Koordinator PKL <?= namadosen($dbsurat, $validator1); ?> <br />
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    Ditolak Dosen Koordinator PKL <?= namadosen($dbsurat, $validator1); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b><br />
                                                                <?php
                                                                };
                                                                ?>
                                                                <!-- ketua jurusan -->
                                                                <?php
                                                                if ($validasi2 == 0) {
                                                                ?>
                                                                    Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                                <?php
                                                                } elseif ($validasi2 == 1) {
                                                                ?>
                                                                    Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b><br />
                                                                <?php
                                                                };
                                                                ?>
                                                                <!-- WD-1 -->
                                                                <?php
                                                                if ($validasi3 == 0) {
                                                                ?>
                                                                    Menunggu verifikasi Wakil Dekan Bidang Kemahasiswaan <?= namadosen($dbsurat, $validator3); ?><br />
                                                                <?php
                                                                } elseif ($validasi3 == 1) {
                                                                ?>
                                                                    Telah disetujui Wakil Dekan Bidang Kemahasiswaan <?= namadosen($dbsurat, $validator3); ?> <br />
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    Ditolak oleh Wakil Dekan Bidang Kemahasiswaan <?= namadosen($dbsurat, $validator3); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b><br />
                                                            <?php
                                                                }
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == -1) {
                                                            ?>
                                                                <a class="btn btn-info btn-sm" href="pkl-isianggota.php?nodata=<?= $nodata; ?>">
                                                                    <i class="fas fa-file"></i> Lengkapi
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="pkl-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="pkl-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i>
                                                                    Cetak
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 0) {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="pkl-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="pkl-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- /Ijin PKL -->

                                                <!-- Surat Keterangan -->
                                                <?php
                                                $data = mysqli_query($dbsurat, "SELECT * FROM suket WHERE nim='$nim'");
                                                $cek = mysqli_num_rows($data);
                                                while ($q = mysqli_fetch_array($data)) {
                                                    $nodata = $q['no'];
                                                    $nim = $q['nim'];
                                                    $validasi1 = $q['validasi1'];
                                                    $validator1 = $q['validator1'];
                                                    $validasi2 = $q['validasi2'];
                                                    $validator2 = $q['validator2'];
                                                    $validasi3 = $q['validasi3'];
                                                    $validator3 = $q['validator3'];
                                                    $keterangan = $q['keterangan'];
                                                    $statussurat = $q['statussurat'];
                                                    $token = $q['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $q['jenissurat']; ?></td>
                                                        <td>
                                                            <!-- dosen wali -->
                                                            <?php
                                                            if ($validator1 <> '') {
                                                                if ($validasi1 == 0) {
                                                            ?>
                                                                    Menunggu verifikasi Dosen Wali <?= namadosen($dbsurat, $validator1); ?><br />
                                                                <?php
                                                                } elseif ($validasi1 == 1) {
                                                                ?>
                                                                    Telah disetujui Dosen Wali <?= namadosen($dbsurat, $validator1); ?> <br />
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    Ditolak oleh Dosen Wali <?= namadosen($dbsurat, $validator1); ?> dengan alasan <b style="color:red"> <?= $keterangan; ?></b><br />
                                                            <?php
                                                                }
                                                            };
                                                            ?>

                                                            <!-- ketua jurusan -->
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                            <?php
                                                            } elseif ($validasi2 == 1) {
                                                            ?>
                                                                Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <b style="color:red"> <?= $keterangan; ?></b><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- WD-3 -->
                                                            <?php
                                                            if ($validasi3 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Wakil Dekan Bidang Kemahasiswaan <?= namadosen($dbsurat, $validator3); ?><br />
                                                            <?php
                                                            } elseif ($validasi3 == 1) {
                                                            ?>
                                                                Telah disetujui Wakil Dekan Bidang Kemahasiswaan <?= namadosen($dbsurat, $validator3); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Wakil Dekan Bidang Kemahasiswaan <?= namadosen($dbsurat, $validator3); ?> dengan alasan <b style="color:red"> <?= $keterangan; ?></b><br />
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="suket-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="suket-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Harap menunggu proses verifikasi')" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="suket-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- /surat keterangan -->

                                                <!-- Permohonan Cetak KHS -->
                                                <?php
                                                $data = mysqli_query($dbsurat, "SELECT * FROM cetakkhs WHERE nim = '$nim'");
                                                $cek = mysqli_num_rows($data);
                                                while ($q = mysqli_fetch_array($data)) {
                                                    $nodata = $q['no'];
                                                    $validasi2 = $q['validasi2'];
                                                    $validator2 = $q['validator2'];
                                                    $tglvalidasi2 = $q['tglvalidasi2'];
                                                    $validasi3 = $q['validasi3'];
                                                    $validator3 = $q['validator3'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $statussurat = $q['statussurat'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= "Permohonan Cetak KHS"; ?></td>
                                                        <td>
                                                            <!-- ketua jurusan -->
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                            <?php
                                                            } elseif ($validasi2 == 1) {
                                                            ?>
                                                                Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- WD-1 -->
                                                            <?php
                                                            if ($validasi3 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?><br />
                                                            <?php
                                                            } elseif ($validasi3 == 1) {
                                                            ?>
                                                                Telah disetujui Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="cetakkhs-cetak.php?nodata='.$nodata.'" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="cetakkhs-hapus.php?nodata=<?= $nodata; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Harap menunggu proses verifikasi')" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="cetakkhs-hapus.php?nodata=<?= $nodata; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- /Permohonan Cetak KHS -->

                                                <!-- ijin penelitian -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE nim = '$nim'");
                                                $cek = mysqli_num_rows($query);
                                                while ($q = mysqli_fetch_array($query)) {
                                                    $nodata = $q['no'];
                                                    $validasi1 = $q['validasi1'];
                                                    $validator1 = $q['validator1'];
                                                    $tglvalidasi1 = $q['tglvalidasi1'];
                                                    $validasi2 = $q['validasi2'];
                                                    $validator2 = $q['validator2'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $validasi3 = $q['validasi3'];
                                                    $validator3 = $q['validator3'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $statussurat = $q['statussurat'];
                                                    $keterangan = $q['keterangan'];
                                                    $token = $q['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= "Permohonan Ijin Penelitian"; ?></td>
                                                        <td>
                                                            <!-- dosen pembimbing -->
                                                            <?php
                                                            if ($validasi1 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?><br />
                                                            <?php
                                                            } elseif ($validasi1 == 1) {
                                                            ?>
                                                                Telah disetujui Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> dengan alasan <b><?= $keterangan; ?></b><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- ketua jurusan -->
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                            <?php
                                                            } elseif ($validasi2 == 1) {
                                                            ?>
                                                                Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <b><?= $keterangan; ?></b><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- WD-1 -->
                                                            <?php
                                                            if ($validasi3 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?><br />
                                                            <?php
                                                            } elseif ($validasi3 == 1) {
                                                            ?>
                                                                Telah disetujui Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="ijinpenelitian-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="ijinpenelitian-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Harap menunggu proses verifikasi')" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="ijinpenelitian-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- /ijin penelitian -->

                                                <!-- ijin ujian offline -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM ijinujian WHERE nim = '$nim'");
                                                $cek = mysqli_num_rows($query);
                                                while ($q = mysqli_fetch_array($query)) {
                                                    $nodata = $q['no'];
                                                    $validasi1 = $q['validasi1'];
                                                    $validator1 = $q['validator1'];
                                                    $tglvalidasi1 = $q['tglvalidasi1'];
                                                    $validasi2 = $q['validasi2'];
                                                    $validator2 = $q['validator2'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $validasi3 = $q['validasi3'];
                                                    $validator3 = $q['validator3'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $statussurat = $q['statussurat'];
                                                    $keterangan = $q['keterangan'];
                                                    $token = $q['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= "Ijin Ujian Skripsi Offline"; ?></td>
                                                        <td>
                                                            <!-- dosen pembimbing -->
                                                            <?php
                                                            if ($validasi1 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?><br />
                                                            <?php
                                                            } elseif ($validasi1 == 1) {
                                                            ?>
                                                                Telah disetujui Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> dengan alasan <b><?= $keterangan; ?></b><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- ketua jurusan -->
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                            <?php
                                                            } elseif ($validasi2 == 1) {
                                                            ?>
                                                                Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <b><?= $keterangan; ?></b><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- WD-1 -->
                                                            <?php
                                                            if ($validasi3 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?><br />
                                                            <?php
                                                            } elseif ($validasi3 == 1) {
                                                            ?>
                                                                Telah disetujui Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="ijinujian-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="ijinujian-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Harap menunggu proses verifikasi')" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="ijinujian-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- /ijin ujian offline -->

                                                <!-- ijin bimbingan offline -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM ijinbimbingan WHERE nim = '$nim'");
                                                $cek = mysqli_num_rows($query);
                                                while ($q = mysqli_fetch_array($query)) {
                                                    $nodata = $q['no'];
                                                    $validasi1 = $q['validasi1'];
                                                    $validator1 = $q['validator1'];
                                                    $tglvalidasi1 = $q['tglvalidasi1'];
                                                    $validasi2 = $q['validasi2'];
                                                    $validator2 = $q['validator2'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $validasi3 = $q['validasi3'];
                                                    $validator3 = $q['validator3'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $statussurat = $q['statussurat'];
                                                    $keterangan = $q['keterangan'];
                                                    $token = $q['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= "Ijin Bimbingan Offline"; ?></td>
                                                        <td>
                                                            <!-- dosen pembimbing -->
                                                            <?php
                                                            if ($validasi1 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?><br />
                                                            <?php
                                                            } elseif ($validasi1 == 1) {
                                                            ?>
                                                                Telah disetujui Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> dengan alasan <b><?= $keterangan; ?></b><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- ketua jurusan -->
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                            <?php
                                                            } elseif ($validasi2 == 1) {
                                                            ?>
                                                                Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <b><?= $keterangan; ?></b><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- WD-1 -->
                                                            <?php
                                                            if ($validasi3 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?><br />
                                                            <?php
                                                            } elseif ($validasi3 == 1) {
                                                            ?>
                                                                Telah disetujui Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="ijinbimbingan-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="ijinbimbingan-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } elseif ($validator1 == null or $validator2 == null or $validator3 == null) {
                                                            ?>
                                                                <a class="btn btn-info btn-sm" href="ijinbimbingan-isi2.php?token=<?= $token; ?>"><i class="fas fa-lup"></i> Upload
                                                                </a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Harap menunggu proses verifikasi')" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="ijinbimbingan-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- /ijin ujian offline -->

                                                <!-- peminjaman alat -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM peminjamanalat WHERE nim = '$nim'");
                                                while ($q = mysqli_fetch_array($query)) {
                                                    $nodata = $q['no'];
                                                    $nim = $q['nim'];
                                                    $validasi1 = $q['validasi1'];
                                                    $validator1 = $q['validator1'];
                                                    $tglvalidasi1 = $q['tglvalidasi1'];
                                                    $validasi2 = $q['validasi2'];
                                                    $validator2 = $q['validator2'];
                                                    $tglvalidasi2 = $q['tglvalidasi2'];
                                                    $validasi3 = $q['validasi3'];
                                                    $validator3 = $q['validator3'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $keterangan = $q['keterangan'];
                                                    $statussurat = $q['statussurat'];
                                                    $token = $q['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= "Permohonan Peminjaman Alat"; ?></td>
                                                        <td>
                                                            <!-- dosen pembimbing -->
                                                            <?php
                                                            if ($validasi1 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?><br />
                                                            <?php
                                                            } elseif ($validasi1 == 1) {
                                                            ?>
                                                                Telah disetujui Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- ketua jurusan -->
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                            <?php
                                                            } elseif ($validasi2 == 1) {
                                                            ?>
                                                                Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- WD-1 -->
                                                            <?php
                                                            if ($validasi3 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?><br />
                                                            <?php
                                                            } elseif ($validasi3 == 1) {
                                                            ?>
                                                                Telah disetujui Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="peminjamanalat-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="peminjamanalat-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Harap menunggu proses verifikasi')" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="peminjamanalat-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- /peminjaman alat -->

                                                <!-- pengambilan data -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM pengambilandata WHERE nim = '$nim'");
                                                while ($q = mysqli_fetch_array($query)) {
                                                    $nodata = $q['no'];
                                                    $nim = $q['nim'];
                                                    $validasi1 = $q['validasi1'];
                                                    $validator1 = $q['validator1'];
                                                    $tglvalidasi1 = $q['tglvalidasi1'];
                                                    $validasi2 = $q['validasi2'];
                                                    $validator2 = $q['validator2'];
                                                    $tglvalidasi2 = $q['tglvalidasi2'];
                                                    $validasi3 = $q['validasi3'];
                                                    $validator3 = $q['validator3'];
                                                    $tglvalidasi3 = $q['tglvalidasi3'];
                                                    $statussurat = $q['statussurat'];
                                                    $token = $q['token'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= "Ijin Pengambilan Data"; ?></td>
                                                        <td>
                                                            <!-- dosen pembimbing -->
                                                            <?php
                                                            if ($validasi1 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?><br />
                                                            <?php
                                                            } elseif ($validasi1 == 1) {
                                                            ?>
                                                                Telah disetujui Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak Dosen Pembimbing <?= namadosen($dbsurat, $validator1); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- ketua jurusan -->
                                                            <?php
                                                            if ($validasi2 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                            <?php
                                                            } elseif ($validasi2 == 1) {
                                                            ?>
                                                                Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- WD-1 -->
                                                            <?php
                                                            if ($validasi3 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?><br />
                                                            <?php
                                                            } elseif ($validasi3 == 1) {
                                                            ?>
                                                                Telah disetujui Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $validator3); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($statussurat == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="pengambilandata-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                    <i class="fas fa-print"></i> Cetak
                                                                </a>
                                                            <?php
                                                            } elseif ($statussurat == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="pengambilandata-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" onclick="return alert('Harap menunggu proses verifikasi')" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="pengambilandata-hapus.php?token=<?= $token; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- /pengambilan data -->

                                                <!-- Ijin observasi -->
                                                <?php
                                                $query1 = mysqli_query($dbsurat, "SELECT * FROM observasianggota WHERE nimanggota = '$nim'");
                                                $jquery1 = mysqli_num_rows($query1);
                                                if ($jquery1 > 0) {
                                                    while ($dquery1 = mysqli_fetch_array($query1)) {
                                                        $nimketuaobservasi = $dquery1['nimketua'];
                                                        $query2 = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE nim = '$nimketuaobservasi'");
                                                        while ($q = mysqli_fetch_array($query2)) {
                                                            $nodata = $q['no'];
                                                            $nimketua = $q['nim'];
                                                            $namaketua =  $q['nama'];
                                                            $validasi1 = $q['validasi1'];
                                                            $validator1 = $q['validator1'];
                                                            $tglvalidasi1 = $q['tglvalidasi1'];
                                                            $validasi2 = $q['validasi2'];
                                                            $validator2 = $q['validator2'];
                                                            $tglvalidasi2 = $q['tglvalidasi2'];
                                                            $validasi3 = $q['validasi3'];
                                                            $validator3 = $q['validator3'];
                                                            $tglvalidasi3 = $q['tglvalidasi3'];
                                                            $keterangan = $q['keterangan'];
                                                            $statussurat = $q['statussurat'];
                                                            $token = $q['token'];
                                                ?>

                                                            <tr>
                                                                <td><?= $no++; ?></td>
                                                                <td>Surat Pengantar Observasi <br />
                                                                    Ketua <?= $namaketua; ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if ($statussurat == -1) {
                                                                    ?>
                                                                        <p style="color:red">Data belum lengkap</p>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <!-- dosen -->
                                                                        <?php
                                                                        if ($validasi1 == 0) {
                                                                        ?>
                                                                            Menunggu verifikasi Dosen Matakuliah <?= namadosen($dbsurat, $validator1); ?><br />
                                                                        <?php
                                                                        } elseif ($validasi1 == 1) {
                                                                        ?>
                                                                            Telah disetujui Dosen Matakuliah <?= namadosen($dbsurat, $validator1); ?> <br />
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            Ditolak Dosen Matakuliah <?= namadosen($dbsurat, $validatovalidator1rkoor); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b><br />
                                                                        <?php
                                                                        };
                                                                        ?>
                                                                        <!-- ketua jurusan -->
                                                                        <?php
                                                                        if ($validasi2 == 0) {
                                                                        ?>
                                                                            Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?><br />
                                                                        <?php
                                                                        } elseif ($validasi2 == 1) {
                                                                        ?>
                                                                            Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> <br />
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $validator2); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b><br />
                                                                        <?php
                                                                        };
                                                                        ?>
                                                                        <!-- WD-1 -->
                                                                        <?php
                                                                        if ($validasi3 == 0) {
                                                                        ?>
                                                                            Menunggu verifikasi Wakil Dekan Bidang Kemahasiswaan <?= namadosen($dbsurat, $validator3); ?><br />
                                                                        <?php
                                                                        } elseif ($validasi3 == 1) {
                                                                        ?>
                                                                            Telah disetujui Wakil Dekan Bidang Kemahasiswaan <?= namadosen($dbsurat, $validator3); ?> <br />
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            Ditolak oleh Wakil Dekan Bidang Kemahasiswaan <?= namadosen($dbsurat, $validator3); ?> dengan alasan <b style="color:red"><?= $keterangan; ?></b><br />
                                                                    <?php
                                                                        }
                                                                    };
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if ($statussurat == -1) {
                                                                    ?>
                                                                        <a class="btn btn-info btn-sm" href="observasi-isianggota.php?token=<?= $token; ?>">
                                                                            <i class="fas fa-file"></i>
                                                                            Lengkapi
                                                                        </a>
                                                                    <?php
                                                                    } elseif ($statussurat == 1) {
                                                                    ?>
                                                                        <a class="btn btn-success btn-sm" href="observasi-cetak.php?token=<?= $token; ?>" target="_blank">
                                                                            <i class="fas fa-print"></i>
                                                                            Cetak
                                                                        </a>
                                                                    <?php
                                                                    } elseif ($statussurat == 0) {
                                                                    ?>
                                                                        <a class="btn btn-secondary btn-sm" disabled>
                                                                            <i class="fas fa-spinner"></i> Proses
                                                                        </a>
                                                                        <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="observasi-hapus.php?token=<?= $token; ?>">
                                                                            <i class="fas fa-trash"></i> Batalkan
                                                                        </a>
                                                                    <?php
                                                                    } elseif ($statussurat == 2) {
                                                                    ?>
                                                                        <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="observasi-hapus.php?token=<?= $token; ?>">
                                                                            <i class="fas fa-trash"></i> Hapus
                                                                        </a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <!-- /Ijin observasi -->

                                                <!-- SKPI -->
                                                <?php
                                                $query = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE nim = '$nim'");
                                                while ($q = mysqli_fetch_array($query)) {
                                                    $nodata = $q['no'];
                                                    $verifikasi1 = $q['verifikasi1'];
                                                    $verifikator1 = $q['verifikator1'];
                                                    $tglverifikasi1 = $q['tglverifikasi1'];
                                                    $verifikasi2 = $q['verifikasi2'];
                                                    $verifikator2 = $q['verifikator2'];
                                                    $tglverifikasi2 = $q['tglverifikasi2'];
                                                    $verifikasi3 = $q['verifikasi3'];
                                                    $verifikator3 = $q['verifikator3'];
                                                    $tglverifikasi3 = $q['tglverifikasi3'];
                                                    $keterangan = $q['keterangan'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= "Surat Keterangan Pendamping Ijazah"; ?></td>
                                                        <td>
                                                            <!-- dosen pembimbing -->
                                                            <?php
                                                            if ($verifikasi1 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Dosen Pembimbing <?= namadosen($dbsurat, $verifikator1); ?><br />
                                                            <?php
                                                            } elseif ($verifikasi1 == 1) {
                                                            ?>
                                                                Telah disetujui Dosen Pembimbing <?= namadosen($dbsurat, $verifikator1); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak Dosen Pembimbing <?= namadosen($dbsurat, $verifikator1); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- ketua jurusan -->
                                                            <?php
                                                            if ($verifikasi2 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Ketua Program Studi <?= namadosen($dbsurat, $verifikator2); ?><br />
                                                            <?php
                                                            } elseif ($verifikasi2 == 1) {
                                                            ?>
                                                                Telah disetujui Ketua Program Studi <?= namadosen($dbsurat, $verifikator2); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Ketua Program Studi <?= namadosen($dbsurat, $verifikator2); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <!-- WD-1 -->
                                                            <?php
                                                            if ($verifikasi3 == 0) {
                                                            ?>
                                                                Menunggu verifikasi Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $verifikator3); ?><br />
                                                            <?php
                                                            } elseif ($verifikasi3 == 1) {
                                                            ?>
                                                                Telah disetujui Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $verifikator3); ?> <br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                Ditolak oleh Wakil Dekan Bidang Akademik <?= namadosen($dbsurat, $verifikator3); ?> dengan alasan <?= $keterangan; ?><br />
                                                            <?php
                                                            };
                                                            ?>
                                                            <?php
                                                            if ($verifikasi3 == 1) {
                                                            ?>
                                                                <b><i>Pengajuan SKPI anda telah disetujui dan akan di proses di SIAKAD. Silahkan hubungi administrasi Program Studi untuk informasi lebih lanjut. </i></b>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($verifikasi3 == 1) {
                                                            ?>
                                                                <a class="btn btn-success btn-sm" href="https://siakad.uin-malang.ac.id" target="_blank">
                                                                    <i class="fas fa-graduation-cap"></i>
                                                                    SIAKAD
                                                                </a>
                                                            <?php
                                                            } elseif ($verifikasi1 == 2 or $verifikasi2 == 2 or $verifikasi3 == 2) {
                                                            ?>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="skpi-hapus.php?nodata=<?= $nodata; ?>">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-secondary btn-sm" onclick="return alert('harap menunggu proses')" disabled>
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengajuan ini ?')" href="skpi-hapus.php?nodata=<?= $nodata; ?>">
                                                                    <i class="fas fa-trash"></i> Batalkan
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- /SKPI -->

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
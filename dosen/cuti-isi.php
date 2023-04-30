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
                            <h1>Pengajuan Cuti</h1>
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
                                    <h3 class="card-title">Pengajuan Izin Cuti</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form action="cuti-simpan.php" enctype="multipart/form-data" method="POST" id="my-form">
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
                                                    $jabatan == 'Dosen';
                                                } elseif ($djbtn == 'tendik') {
                                                    $jabatan == 'Tenaga Kependidikan';
                                                }
                                            }
                                            ?>
                                            <div class="form-group row">
                                                <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= strtoupper($_SESSION['jabatan']); ?>" readonly>
                                                </div>
                                            </div>
                                            <!-- cari masa kerja -->
                                            <?php
                                            $tahunini = date('Y');
                                            $bulanini = date('m');
                                            $tahunkerja = substr($nip, 8, 4);
                                            $bulankerja = substr($nip, 12, 2);
                                            $masakerjatahun = $tahunini - $tahunkerja;
                                            $masakerjabulan = $bulanini - $bulankerja;
                                            ?>
                                            <div class="form-group row">
                                                <label for="masakerja" class="col-sm-2 col-form-label">Masa Kerja</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="masakerja" name="masakerja" value="<?= $masakerjatahun; ?> Tahun <?= $masakerjabulan; ?> Bulan" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="unitkerja" class="col-sm-2 col-form-label">Unit Kerja</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="unitkerja" name="unitkerja" value="Program Studi <?= $prodi; ?> Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="cuti" class="col-sm-2 col-form-label">Jenis Cuti yang Diambil</label>
                                                <div class="col-sm-10">
                                                    <select name="cuti" class="form-control">
                                                        <option value="Cuti Tahunan">Cuti Tahunan</option>
                                                        <option value="Cuti Sakit">Cuti Sakit</option>
                                                        <option value="Cuti Karena Alasan Penting" selected>Cuti Karena Alasan Penting</option>
                                                        <option value="Cuti Besar">Cuti Besar</option>
                                                        <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                                        <option value="Cuti di Luar Tanggungan Negara">Cuti di Luar Tanggungan Negara</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alasan" class="col-sm-2 col-form-label">Alasan Cuti</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="alasan" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">Awal Cuti</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="tgl1" name="tgl1" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">Akhir Cuti</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="tgl2" name="tgl2">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">Catatan Cuti (hari)</label>
                                                <div class="col-sm-10">
                                                    <label>Cuti Tahunan <small style="color:red">Ket: Jumlah cuti tahunan maksimal 12 hari / tahun (termasuk cuti bersama)</small></label>
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- hitung cuti bersama pemerintah 2 thn lalu-->
                                                            <?php
                                                            //cuti pemerintah
                                                            $jcuti2 = 0;
                                                            $tahunlalu2 = $tahun - 2;
                                                            $qcuti2 = mysqli_query($dbsurat, "SELECT *  FROM liburnasional WHERE YEAR(tanggal) = '$tahunlalu2' AND SUBSTRING(keterangan,1,4) = 'Cuti'");
                                                            $jcuti2 = mysqli_num_rows($qcuti2);
                                                            //cuti tahunan
                                                            $jcutitahunan2 = 0;
                                                            $qcutitahunan2 = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE year(tglizin1) = '$tahunlalu2' AND jeniscuti = 'Cuti Tahunan' AND nip='$nip' AND statussurat='1'");
                                                            while ($dcutitahunan2 = mysqli_fetch_array($qcutitahunan2)) {
                                                                $jcutitahunan2 = $jcutitahunan2 + $dcutitahunan2['jmlizin'];
                                                            }
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    Tahun <?= $tahunlalu2; ?>
                                                                </div>
                                                                <div class="col">
                                                                    <input type="text" class="form-control" name="cutitahun2" value="<?= $jcuti2 + $jcutitahunan2; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- hitung cuti bersama pemerintah tahun lalu-->
                                                            <?php
                                                            //cuti pemerintah
                                                            $jcuti1 = 0;
                                                            $tahunlalu = $tahunini - 1;
                                                            $qcuti1 = mysqli_query($dbsurat, "SELECT *  FROM liburnasional WHERE YEAR(tanggal) = '$tahunlalu' AND SUBSTRING(keterangan,1,4) = 'Cuti'");
                                                            $jcuti1 = mysqli_num_rows($qcuti1);
                                                            //cuti tahunan
                                                            $jcutitahunan1 = 0;
                                                            $qcutitahunan1 = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE year(tglizin1) = '$tahunlalu' AND jeniscuti = 'Cuti Tahunan' AND nip='$nip' AND statussurat='1'");
                                                            while ($dcutitahunan1 = mysqli_fetch_array($qcutitahunan1)) {
                                                                $jcutitahunan1 = $jcutitahunan1 + $dcutitahunan1['jmlizin'];
                                                            }
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    Tahun <?= $tahunlalu; ?>
                                                                </div>
                                                                <div class="col">
                                                                    <input type="text" class="form-control" name="cutitahun1" value="<?= $jcuti1 + $jcutitahunan1; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- hitung cuti bersama pemerintah -->
                                                            <?php
                                                            //cuti pemerintah
                                                            $jcuti = 0;
                                                            $qcuti = mysqli_query($dbsurat, "SELECT *  FROM liburnasional WHERE YEAR(tanggal) = '$tahunini' AND SUBSTRING(keterangan,1,4) = 'Cuti'");
                                                            $jcuti = mysqli_num_rows($qcuti);
                                                            //cuti tahunan
                                                            $jcutitahunan = 0;
                                                            $qcutitahunan = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE year(tglizin1) = '$tahunini' AND jeniscuti = 'Cuti Tahunan' AND nip='$nip' AND statussurat='1'");
                                                            while ($dcutitahunan = mysqli_fetch_array($qcutitahunan)) {
                                                                $jcutitahunan = $jcutitahunan + $dcutitahunan['jmlizin'];
                                                            }
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    Tahun <?= $tahunini; ?>
                                                                </div>
                                                                <div class="col">
                                                                    <input type="text" class="form-control" name="cutitahunini" value="<?= $jcuti + $jcutitahunan; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label style="color: blue;">Sisa Cuti Tahunan</label>
                                                                </div>
                                                                <div class="col">
                                                                    <input type="text" class="form-control" name="sisacutitahunan" value="<?= 36 - (($jcuti + $jcutitahunan) + ($jcuti1 + $jcutitahunan1) + ($jcuti2 + $jcutitahunan2)); ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- cari data cuti besar -->
                                                    <?php
                                                    $jcutibesar = 0;
                                                    $qcutibesar = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE year(tglizin1) = '$tahunini' AND jeniscuti = 'Cuti Besar' AND nip='$nip' AND statussurat='1'");
                                                    while ($dcutibesar = mysqli_fetch_array($qcutibesar)) {
                                                        $jcutibesar = $jcutibesar + $dcutibesar['jmlizin'];
                                                    }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label>Cuti Besar</label>
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control" value="<?= $jcutibesar; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <!-- cari data cuti sakit -->
                                                    <?php
                                                    $jcutisakit = 0;
                                                    $qcutisakit = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE year(tglizin1) = '$tahunini' AND jeniscuti = 'Cuti Sakit' AND nip='$nip' AND statussurat='1'");
                                                    while ($dcutisakit = mysqli_fetch_array($qcutisakit)) {
                                                        $jcutisakit = $jcutisakit + $dcutisakit['jmlizin'];
                                                    }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label>Cuti Sakit</label>
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control" value="<?= $jcutisakit; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <!-- cari data cuti melahirkan -->
                                                    <?php
                                                    $jcutimelahirkan = 0;
                                                    $qcutimelahirkan = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE year(tglizin1) = '$tahunini' AND jeniscuti = 'Cuti Melahirkan' AND nip='$nip' AND statussurat='1'");
                                                    while ($dcutimelahirkan = mysqli_fetch_array($qcutimelahirkan)) {
                                                        $jcutimelahirkan = $jcutimelahirkan + $dcutimelahirkan['jmlizin'];
                                                    }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label>Cuti Melahirkan</label>
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control" value="<?= $jcutimelahirkan; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <!-- cari data cuti karena alasan penting -->
                                                    <?php
                                                    $jcutialasan = 0;
                                                    $qcutialasan = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE year(tglizin1) = '$tahunini' AND jeniscuti = 'Cuti Karena Alasan Penting' AND nip='$nip' AND statussurat='1'");
                                                    while ($dcutialasan = mysqli_fetch_array($qcutialasan)) {
                                                        $jcutialasan = $jcutialasan + $dcutialasan['jmlizin'];
                                                    }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label>Cuti Karena Alasan Penting</label>
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control" value="<?= $jcutialasan; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <!-- cari data cuti diluar tanggungan negara -->
                                                    <?php
                                                    $jcutiluar = 0;
                                                    $qcutiluar = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE year(tglizin1) = '$tahunini' AND jeniscuti = 'Cuti Diluar Tanggungan Negara' AND nip='$nip' AND statussurat='1'");
                                                    while ($dcutiluar = mysqli_fetch_array($qcutiluar)) {
                                                        $jcutiluar = $jcutiluar + $dcutiluar['jmlizin'];
                                                    }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label>Cuti Diluar Tanggungan Negara</label>
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control" value="<?= $jcutiluar; ?>" readonly>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="alamatcuti" class="col-sm-2 col-form-label">Alamat selama menjalankan cuti</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="alamatcuti" rows="5" required></textarea>
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group row">
                                                <label for="instansi" class="col-sm-2 col-form-label">Lampiran</label>
                                                <div class="col-sm-10">
                                                    <input type="file" class="form-control" name="lampiran" accept=".jpg,.jpeg">
                                                    <small style="color:red">Jenis File JPG/JPEG ukuran file maksimal 1MB</small>
                                                </div>
                                            </div>
                                        -->
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
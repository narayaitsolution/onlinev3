<?php
session_start();
$user = $_SESSION['user'];
$nim = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "mahasiswa") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');
$tglsekarang = date('Y-m-d');
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Upload Lampiran</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered text-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Lampiran</th>
                                        <th class="text-center">Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Screenshot Hasil Pemeriksaan Screening Bebas COVID-19 <br />
                                        </td>
                                        <td>

                                            <a href="https://kedokteran.uin-malang.ac.id/konsuldokter/formulir" target="_blank" class="btn btn-success btn-lg btn-block"><i class="fa-solid fa-magnifying-glass"></i> Periksa Disini</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td><b>Lampiran 4-</b>Surat pernyataan melaksanakan karantina mandiri<br />
                                        </td>
                                        <td>
                                            <a href="../doc/Lampiran4.docx" class="btn btn-success btn-lg btn-block"><i class="fa-solid fa-download"></i> Download Lampiran 4</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td><b>Lampiran 5-</b>Surat pernyataan kesanggupan menerapkan protokol kesehatan<br />
                                        </td>
                                        <td>
                                            <a href="../doc/Lampiran5.docx" class="btn btn-success btn-lg btn-block"><i class="fa-solid fa-download"></i> Download Lampiran 5</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td><b>Lampiran 7-</b>Form kesediaan karantina mandiri selama 14 hari di Malang sebelum bekerja di laboratorium<br />
                                        </td>
                                        <td>
                                            <a href="../doc/Lampiran7.docx" class="btn btn-success btn-lg btn-block"><i class="fa-solid fa-download"></i> Download Lampiran 7</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td><b>Lampiran 8-</b>Surat persetujuan orang tua bermaterai <br />
                                        </td>
                                        <td>
                                            <a href="../doc/Lampiran8.docx" class="btn btn-success btn-lg btn-block"><i class="fa-solid fa-download"></i> Download Lampiran 8</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr />
                            <a href="ijinlab-isi1.php" class="btn btn-lg btn-block btn-primary" onclick="return confirm ('Saya sudah menyiapkan dokumen - dokumen tersebut')">Lengkapi Data</a>
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
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
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

//cek kalo sudah mengisi data maka lanjut ke upload lampiran
$statuspengajuan = -1;
$stmt = $dbsurat->prepare("SELECT * FROM ijinlab WHERE nim=? AND statuspengajuan=?");
$stmt->bind_param("si", $nim, $statuspengajuan);
$stmt->execute();
$result = $stmt->get_result();
$jhasil = $result->num_rows;
if ($jhasil > 0) {
    $dhasil = $result->fetch_array();
    $nodata = $dhasil['no'];
    header("location:ijinlab-isi2.php?nodata=$nodata");
}
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

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pengajuan Izin Lab.</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <?php $no = 1; ?>
                                <div class="card-body p-0">
                                    <div class="card-body">
                                        <form action="ijinlab-isi1-simpan.php" method="POST" id="my-form">
                                            <div class="form-group row">
                                                <label for="alamatasal" class="col-sm-2 col-form-label">Alamat Asal</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="alamatasal" name="alamatasal" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alamatmalang" class="col-sm-2 col-form-label">Alamat di Malang</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="alamatmalang" name="alamatmalang" required>
                                                    <small style="color:red">tuliskan <b>TIDAK ADA</b> apabila tidak tinggal di Malang </small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nohportu" class="col-sm-2 col-form-label">No. HP / Telp. Orang Tua / Wali</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="nohportu" name="nohportu" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="riwayatpenyakit" class="col-sm-2 col-form-label">Riwayat Penyakit</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="riwayatpenyakit" name="riwayatpenyakit" required>
                                                    <small style="color:red">tuliskan <b>TIDAK ADA</b> apabila tidak memiliki riwayat peyakit </small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tglselesai" class="col-sm-2 col-form-label">Posisi Saat Mendaftar</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="posisi">
                                                        <option value="Alamat asal">Alamat Asal</option>
                                                        <option value="Alamat di Malang">Alamat di Malang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="namalab" class="col-sm-2 col-form-label">Nama Laboratorium</label>
                                                <div class="col-sm-10">
                                                    <select name="namalab" class="form-control">
                                                        <?php
                                                        $sql = mysqli_query($dbsurat, "SELECT * FROM laboratorium WHERE jurusan like '%$prodi'");
                                                        $jmldata = mysqli_num_rows($sql);
                                                        //echo "Jumlah data = ".$jmldata;
                                                        while ($data = mysqli_fetch_array($sql)) {
                                                            if ($data['kapasitas'] > 0) {
                                                        ?>
                                                                <option value="<?= $data['namalab']; ?>"><?= $data['namalab']; ?> [<?= $data['kapasitas']; ?>]</option>;
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <small style="color:red">
                                                        <li>Angka yang tampil adalah kapasitas lab. yang <b>masih kosong</b></li>
                                                        <li>Apabila nama lab. tidak tampil berarti kapasitas lab. sudah penuh</li>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="dosen" class="col-sm-2 col-form-label">Dosen Pembimbing</label>
                                                <div class="col-sm-10">
                                                    <select name="dosen" class="form-control">
                                                        <?php
                                                        $qdosen = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE prodi='$prodi' AND hakakses='dosen' ORDER BY nama");
                                                        while ($ddosen = mysqli_fetch_array($qdosen)) {
                                                            $namadosen = $ddosen['nama'];
                                                        ?>
                                                            <option value="<?= $namadosen; ?>"><?= $namadosen; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tglmulai" class="col-sm-2 col-form-label">Mulai penggunaan Lab.</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="tglmulai" name="tglmulai" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tglselesai" class="col-sm-2 col-form-label">Selesai penggunaan Lab.</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="tglselesai" name="tglselesai" required>
                                                    <small style="color:red">Penggunaan lab maksimal 1 bulan</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <button type="submit" id="btn-submit" class="btn btn-primary btn-block" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fa-solid fa-upload"></i> Upload Lampiran</button>
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
        });
    </script>
</body>

</html>
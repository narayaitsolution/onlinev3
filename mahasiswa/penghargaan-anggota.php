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
$tglsekarang = date('Y-m-d');
$tahun = date('Y');
$no = 1;
$token = $_GET['token'];
$qpenghargaan = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE token='$token'");
$dpenghargaan = mysqli_fetch_array($qpenghargaan);
$nimketua = $dpenghargaan['nim'];
$namaketua = $dpenghargaan['nama'];
$nodata = $dpenghargaan['no'];
$kegiatan = $dpenghargaan['kegiatan'];
$namakegiatan = $dpenghargaan['namakegiatan'];
$tingkat = $dpenghargaan['tingkat'];
$kategori = $dpenghargaan['kategori'];
$jeniskegiatan = $dpenghargaan['jeniskegiatan'];
$peringkat = $dpenghargaan['peringkat'];
$bukti = $dpenghargaan['bukti'];

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
              <h1>Anggota Kelompok</h1>
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
                  <h3 class="card-title">Pengajuan Penghargaan</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="card-body">
                    <form action="penghargaan-simpan.php" method="post" enctype="multipart/form-data" id="my-form">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Ketua</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="nama" name="nama" value="<?= $namaketua; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIM</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="nim" name="nim" value="<?= $nimketua; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kegiatan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="<?= $kegiatan; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Kegiatan / Media Publikasi</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="namakegiatan" name="namakegiatan" value="<?= $namakegiatan; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Level Kegiatan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="tingkat" name="tingkat" value="<?= $tingkat; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="kategori" name="kategori" value="<?= $kategori; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Kegiatan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="jeniskegiatan" name="jeniskegiatan" value="<?= $jeniskegiatan; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Peringkat</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="peringkat" name="peringkat" value="<?= $peringkat; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="keperluan" class="col-sm-3 col-form-label">Bukti</label>
                        <div class="col-sm-9">
                          <img src="<?= $bukti; ?>" class="img-fluid">
                        </div>
                      </div>
                      <hr>
                      ==============Anggota diisni ==============
                      <button type="submit" id="btn-submit" class="btn btn-primary btn-block" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya isi adalah benar')"> <i class="fa-solid fa-upload"></i> Ajukan</button>
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
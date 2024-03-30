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
$qdelegasi = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE token='$token'");
$ddelegasi = mysqli_fetch_array($qdelegasi);
$nimketua = $ddelegasi['nim'];
$namaketua = $ddelegasi['nama'];
$nodata = $ddelegasi['no'];
$kegiatan = $ddelegasi['kegiatan'];
$namakegiatan = $ddelegasi['namakegiatan'];
$tingkat = $ddelegasi['tingkat'];
$kategori = $ddelegasi['kategori'];
$jeniskegiatan = $ddelegasi['jeniskegiatan'];
$peringkat = $ddelegasi['peringkat'];
$bukti = $ddelegasi['bukti'];
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
              <h1>Anggota Delegasi</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- alert -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col">
              <?php
              if (isset($_GET['pesan'])) {
                $pesan = $_GET['pesan'];
                if ($pesan == 'succes') {
              ?>
                  <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Penambahan anggota <b>BERHASIL!!</b>
                  </div>
                <?php
                } elseif ($pesan == 'gagal') {
                ?>
                  <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Penambahan anggota <b>GAGAL!!</b>
                  </div>
                <?php
                } elseif ($pesan == 'hapusok') {
                ?>
                  <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Penghapusan anggota <b>BERHASIL!!</b>
                  </div>
              <?php
                }
              };
              ?>
            </div>
          </div>
        </div>
      </section>

      <!-- masukkan data ketua -->
      <?php
      $qdelegaasi = mysqli_query($dbsurat, "SELECT * FROM delegasianggota WHERE token='$token'");
      $jdelegaasi = mysqli_num_rows($qdelegaasi);
      if ($jdelegaasi == 0) {
        $qdelegasianggota = mysqli_query($dbsurat, "INSERT INTO delegasianggota (token,nimketua,nimanggota) VALUES ('$token','$nimketua','$nimketua')");
      }
      ?>

      <!-- tabel pengajuan pribadi -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Anggota Delegasi</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="card-body">
                    <form action="delegasi-anggota-tambah.php" method="POST">
                      <div class="form-group row">
                        <label for="keperluan" class="col-sm-3 col-form-label">NIM Anggota Delegasi</label>
                        <div class="col-sm-7">
                          <input type="number" class="form-control" id="nimanggota" name="nimanggota" required>
                          <p class="blink"> Wajib memasukkan seluruh anggota delegasi, karena berpengaruh pada biaya delegasi yang diterima </p>
                        </div>
                        <div class="col-sm-2">
                          <input type="hidden" name="nodata" value="<?= $nodata; ?>">
                          <input type="hidden" name="nimketua" value="<?= $nimketua; ?>">
                          <input type="hidden" name="token" value="<?= $token; ?>">
                          <button type="submit" class="btn btn-success btn-block"><i class="fa-solid fa-user-plus"></i> Tambah</button>
                        </div>
                      </div>
                    </form>
                    <hr>
                    <table id="example2" class="table table-bordered table-hover text-sm">
                      <thead>
                        <tr>
                          <th width="5%" style="text-align: center;">No</th>
                          <th style="text-align: center;">Nama</th>
                          <th style="text-align: center;">NIM</th>
                          <th style="text-align: center;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $nourut = 1;
                        $qdelegasianggota = mysqli_query($dbsurat, "SELECT * FROM delegasianggota WHERE token='$token'");
                        while ($ddelegasianggota = mysqli_fetch_array($qdelegasianggota)) {
                          $nimanggota = $ddelegasianggota['nimanggota'];
                          $no = $ddelegasianggota['no'];
                        ?>
                          <tr>
                            <td>
                              <?= $nourut; ?>
                            </td>
                            <td>
                              <?= namadosen($dbsurat, $nimanggota); ?>
                            </td>
                            <td>
                              <?= $nimanggota; ?>
                            </td>
                            <td style="text-align: center;">
                              <form action="delegasi-anggota-hapus.php" method="post">
                                <input type="hidden" name="no" value="<?= $no; ?>">
                                <input type="hidden" name="token" value="<?= $token; ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus anggota ini ?')"><i class="fa-solid fa-user-xmark"></i> HAPUS</button>
                              </form>
                            </td>
                          </tr>
                        <?php
                          $nourut++;
                        }
                        ?>
                      </tbody>
                    </table>
                    <hr>
                    <a href="delegasi-anggota-simpan.php?token=<?= $token; ?>" class="btn btn-block btn-lg btn-success" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya masukkan adalah benar')"><i class="fa-solid fa-file-arrow-up"></i> AJUKAN</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  </section>
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
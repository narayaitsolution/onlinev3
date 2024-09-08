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
if ($_SESSION['jabatan'] != "mahasiswa") {
  header("location:../deauth.php");
}
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
              <h1>Laporan Delegasi</h1>
            </div>
          </div>
        </div>
      </section>

      <?php
      if (isset($_GET['pesan'])) {
      ?>
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col">
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
      <?php
      }
      ?>

      <!-- ambil data mahasiswa dari database -->
      <?php
      $token = mysqli_real_escape_string($dbsurat, $_GET['token']);
      $datamhs = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE token='$token'");
      $row = mysqli_fetch_array($datamhs);
      $nodata = $row['no'];
      $tanggal = $row['tanggal'];
      $nimmhs = $row['nim'];
      $namamhs = $row['nama'];
      $prodimhs = $row['prodi'];
      $jenissurat = 'Pengajuan delegasi';
      $namakegiatan = $row['namakegiatan'];
      $tingkat = $row['tingkat'];
      $kategori = $row['kategori'];
      $jeniskegiatan = $row['jeniskegiatan'];
      $bukti = $row['bukti'];
      $validator1 = $row['validator1'];
      $tglvalidasi1 = $row['tglvalidasi1'];
      ?>

      <!-- tabel pengajuan pribadi -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Laporan Delegasi</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="card-body">
                    <div class="form-group row">
                      <label for="dosen" class="col-sm-2 col-form-label">Tanggal Pengajuan</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="namamhs" value="<?= tgljam_indo($tanggal); ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="dosen" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="namamhs" value="<?= $namamhs; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="dosen" class="col-sm-2 col-form-label">NIM</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="nimmhs" value="<?= $nimmhs; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Kategori</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="kategori" value="<?= $kategori; ?>" readonly>
                        <small style="color: blue;">
                          <b>Kategori Akademik :</b>
                          <ul>
                            <li>- Kompetisi/kejuaraan/perlombaan dalam bidang ilmiah, teknologi dan riset.</li>
                          </ul>
                          <b>Kategori Non Akademik :</b>
                          <ul>
                            <li>- Kompetisi/kejuaraan/perlombaan dalam bidang seni, budaya, sosial dan keagamaan.</li>
                          </ul>
                        </small>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nama Kegiatan</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="namakegiatan" value="<?= $namakegiatan; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Level Kegiatan</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="tingkat" value="<?= $tingkat; ?>" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Jenis Kegiatan</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="jeniskegiatan" value="<?= $jeniskegiatan; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="keperluan" class="col-sm-2 col-form-label">Undangan / Poster / LoA</label>
                      <div class="col-sm-10">
                        <a href="<?= $bukti; ?>" target="_blank"><img src="<?= $bukti; ?>" width="200px"></a><br>
                        <small style="color: red;">Klik pada gambar untuk memperbersar</small>
                      </div>
                    </div>
                    <?php
                    if ($jeniskegiatan == 'Kelompok') {
                    ?> <div class="card card-info">
                        <div class="card-header">
                          <h3 class="card-title">Anggota Kelompok</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                          </div>
                        </div>
                        <div class="card-body p-0">
                          <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover text-sm">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align: center;">No</th>
                                  <th style="text-align: center;">Nama</th>
                                  <th style="text-align: center;">NIM</th>
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
                                  </tr>
                                <?php
                                  $nourut++;
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
                    <hr>
                    <form action="delegasi-laporan-simpan.php" role="form" method="POST" id="my-form" enctype="multipart/form-data">
                      <div class="form-group row">
                        <label for="laporan" class="col-sm-2 col-form-label">Laporan Kegiatan</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" id="laporan" name="laporan" accept="application/pdf" required>
                          <small style="color: red;">Format File PDF, ukuran file maksimal 5MB</small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="noktp" class="col-sm-2 col-form-label">No. KTP</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="noktp" name="noktp" required>
                          <small style="color: red;">Masukkan hanya angka</small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="ktp" class="col-sm-2 col-form-label">Foto KTP</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" id="ktp" name="ktp" accept="image/jpeg" required>
                          <small style="color: red;">Nama di KTP <b>HARUS SAMA</b> dengan nama ketua delegasi</small><br>
                          <small style="color: red;">Format File JPG, ukuran file maksimal 1MB</small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="ktm" class="col-sm-2 col-form-label">Foto KTM</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" id="ktm" name="ktm" accept="image/jpeg" required>
                          <small style="color: red;">Nama di KTM <b>HARUS SAMA</b> dengan nama ketua delegasi</small><br>
                          <small style="color: red;">Format File JPG, ukuran file maksimal 1MB</small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="norek" class="col-sm-2 col-form-label">No. Rekening</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="norek" name="norek" required>
                          <small style="color: red;">Masukkan hanya angka</small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="bank" class="col-sm-2 col-form-label">Bank</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="bank" name="bank" required>
                          <small style="color: red;">Selain BRI dikenakan potongan biaya transfer</small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="butab" class="col-sm-2 col-form-label">Foto Buku Rekening</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" id="butab" name="butab" accept="image/jpeg" required>
                          <small style="color: red;">Nama pemegang buku <b>HARUS SAMA</b> dengan nama KTP</small><br>
                          <small style="color: red;">Format File JPG, ukuran file maksimal 1MB</small>
                        </div>
                      </div>
                      <hr>
                      <input type="hidden" name="token" value="<?= $token; ?>">
                      <div class="row">
                        <div class="col">
                          <a href="index.php" class="btn btn-secondary btn-block btn-lg"><i class="fa-solid fa-backward"></i> Kembali</a>
                        </div>
                        <div class="col">
                          <button type="submit" id="btn-submit" class="btn btn-success btn-block btn-lg" onclick="return confirm('Dengan ini saya menyatakan bahwa data yang saya unggah adalah benar')"> <i class="fa-solid fa-upload"></i> Upload</button>
                        </div>
                      </div>
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
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
</body>

</html>
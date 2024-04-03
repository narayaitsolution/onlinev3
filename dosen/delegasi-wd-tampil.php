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
if ($_SESSION['jabatan'] != "wadek3") {
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
              <h1>Pengajuan Delegasi</h1>
            </div>
          </div>
        </div>
      </section>

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
      $tglmulai = $row['tglmulai'];
      $tglselesai = $row['tglselesai'];
      $tempat = $row['tempat'];
      $tingkat = $row['tingkat'];
      $kategori = $row['kategori'];
      $jeniskegiatan = $row['jeniskegiatan'];
      $bukti = $row['bukti'];
      $validator1 = $row['validator1'];
      $tglvalidasi1 = $row['tglvalidasi1'];
      $validator2 = $row['validator2'];
      $tglvalidasi2 = $row['tglvalidasi2'];
      ?>

      <!-- tabel pengajuan pribadi -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Pengajuan Delegasi</h3>
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
                            <li>Kompetisi / kejuaraan / perlombaan dalam bidang ilmiah, teknologi dan riset</li>
                          </ul>
                          <b>Kategori Non Akademik :</b>
                          <ul>
                            <li>Kompetisi / kejuaraan / perlombaan dalam bidang olah raga, seni, budaya, sosial dan keagamaan.</li>
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
                      <label class="col-sm-2 col-form-label">Tanggal Mulai</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="tglmulai" value="<?= tgl_indo($tglmulai); ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="tglselesai" value="<?= tgl_indo($tglselesai); ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Tempat</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="tempat" value="<?= $tempat; ?>" readonly>
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
                      <label for="keperluan" class="col-sm-2 col-form-label">Undangan / LoA Kegiatan</label>
                      <div class="col-sm-10">
                        <a href="<?= $bukti; ?>" target="_blank"><img src="<?= $bukti; ?>" width="200px"></a><br>
                        <small style="color: red;">Klik pada gambar untuk memperbersar</small>
                      </div>
                    </div>
                    <?php
                    if ($jeniskegiatan == 'Kelompok') {
                    ?> <div class="card card-primary">
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
                    <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">Verifikasi Pengajuan</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="card-body p-0">
                        <div class="card-body">
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Verifikator</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="verifikator" value="<?= namadosen($dbsurat, $validator1); ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal Verifikasi</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="tglverifikasi" value="<?= tgljam_indo($tglvalidasi1); ?>" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <form role="form" method="POST" id="my-form">
                      <!--
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Biaya Disetujui</label>
                        <div class="col-sm-10">
                          <input type="number" pattern="[0-9]*" class="form-control" name="biaya" value="0">
                          <small style="color: red;">Tuliskan HANYA ANGKA 0 - 9 tanpa titik / koma</small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Peruntukan Biaya</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" name="peruntukan" value=""></textarea>
                        </div>
                      </div>
                      <hr>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kaprodi</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="validator1" value="<?= namadosen($dbsurat, $validator1); ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Disetujui pada</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="tglvalidasi1" value="<?= tgljam_indo($tglvalidasi1); ?>" readonly>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Koordinator Mahasiswa</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="validator2" value="<?= namadosen($dbsurat, $validator2); ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Disetujui pada</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="tglvalidasi2" value="<?= tgljam_indo($tglvalidasi2); ?>" readonly>
                        </div>
                      </div>
                      <hr>
                  -->
                      <input type="hidden" name="token" value="<?= $token; ?>">
                      <hr>
                      <div class="row">
                        <div class="col-6">
                          <button name="aksi" id="btn-submit" value="setujui" type="submit" formaction="delegasi-wd-setujui.php" class="btn btn-success btn-block btn-lg" onclick="return confirm('Apakah anda menyetujui pengajuan ini ?')"> <i class="fa fa-check"></i> SETUJUI</button>
                        </div>
                        <div class="col-6">
                          <button name="aksi" value="tolak" type="button" data-toggle="modal" data-target="#modal-tolak" class="btn btn-danger btn-block btn-lg"> <i class="fa fa-times"></i> TOLAK</button>
                        </div>
                      </div>
                      <!-- modal tolak -->
                      <div class="modal fade" id="modal-tolak">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Alasan Penolakan</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <textarea class="form-control" rows="3" name="keterangan"></textarea>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                              <button name="aksi" id="btn-submit" value="tolak" type="submit" formaction="delegasi-wd-tolak.php" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menolak pengajuan ini ?')"> <i class="fa fa-times"></i> Tolak</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- ./modal tolak-->
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
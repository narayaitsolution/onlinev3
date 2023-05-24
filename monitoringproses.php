<?php
require('system/myfunc.php');
require('system/dbconn.php');
$bulanini = date('m');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SAINTEK e-Office</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="template/plugins/fontawesome6/css/all.css">
  <link rel="stylesheet" href="template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="template/dist/css/adminlte.min.css">
  <style>
    .login-page {
      background-image: url('system/saintek-bg.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>

<body class="hold-transition ">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <h1 style="text-align: center;">Monitoring Proses</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- grafik -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Proses Surat Pengantar PKL</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove"><i class="fas fa-times"></i></button>
              </div>
            </div>
            <?php $no = 1; ?>
            <div class="card-body">
              <!-- cari data PKL 1 tahun terakhir -->
              <?php
              echo 'Bulan ini = ' . $bulanini;

              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <script src="template/plugins/jquery/jquery.min.js"></script>
  <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
<?php
session_start();
session_unset();
session_destroy();
require('system/myfunc.php');
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <style>
    .login-page {
      background-image: url('system/saintek-bg.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><img src="system/saintek-logo.png" width="100%"></a>
      </div>
      <div class="card-body">
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
        <p class="login-box-msg h3"><b>SAINTEK</b> e-Office</p>
        <!--
        <form action="auth.php" method="post" id="my-form">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="User ID" name="userid" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="pass" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
          </div>
          <?php
          $angka1 = rand(1, 5);
          $angka2 = rand(1, 5);
          $kunci = $angka1 + $angka2;
          ?>
          <div class="input-group mb-3">
            <input type="number" placeholder="<?= huruf($angka1); ?> ditambah <?= huruf($angka2); ?> ?" class="form-control" name="antibot" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-question"></span>
              </div>
            </div>
          </div>
          <hr>
          <input type="hidden" name="kunci" value="<?= $kunci; ?>">
          <button type="submit" id="btn-submit" class="btn btn-primary btn-lg btn-block"><i class="fa-solid fa-right-to-bracket"></i> Masuk</button>
        </form>
      -->
        <hr>
        <div class="text-center">
          <small style="color: blue;">Masuk gunakan email <b>uin-malang.ac.id</b></small>
          <a href="authg.php" class="btn btn-primary btn-lg btn-block"><i class="fas fa-envelope"></i> &nbsp;MASUK</a>
          <small style="color: blue;">Butuh bantuan ? klik <a href="mailto:saintek@uin-malang.ac.id">disini</a></small>
        </div>
        <hr>
        <!--
        <div class="row">
          <div class="col text-sm">
            <a href="lupa.php" class="btn btn-success btn-block">LUPA Password</a>
          </div>
          <div class="col text-sm">
            <a href="daftar.php" class="btn btn-warning btn-block">DAFTAR Akun</a>
          </div>
          <div class="col text-sm">
            <a href="laporkan/" class="btn btn-danger btn-block">LAPORKAN Keluhan</a>
          </div>
      -->
      </div>
    </div>
  </div>
  </div>

  <script src="template/plugins/jquery/jquery.min.js"></script>
  <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
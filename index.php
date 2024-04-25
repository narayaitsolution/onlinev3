<?php
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
        <?php
        if (isset($_GET['pesan'])) {
          if ($_GET['pesan'] == "antibot") {
        ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <strong>ERROR!</strong> perhitungan salah!!
            </div>
          <?php
          } elseif ($_GET['pesan'] == "gagal") {
          ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <strong>ERROR!</strong> User ID / Password salah
            </div>
          <?php
          } elseif ($_GET['pesan'] == "resetok") {
          ?>
            <div class="alert alert-success alert-dismissible fade show">
              <strong>RESET berhasil</strong> cek email anda
            </div>
          <?php
          } elseif ($_GET['pesan'] == "daftarok") {
          ?>
            <div class="alert alert-success alert-dismissible fade show">
              <strong>Pendaftaran Berhasil</strong> tunggu verifikasi akun.
            </div>
          <?php
          } elseif ($_GET['pesan'] == 'notaktif') {
          ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <strong>ERROR!!</strong> tunggu verifikasi akun.
            </div>
        <?php
          }
        }
        ?>
        <p class="login-box-msg h3"><b>SAINTEK</b> e-Office</p>
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
        <hr>
        <div class="text-center">
          <a href="authgoogle.php" class="btn btn-danger btn-lg btn-block"><i class="fa-brands fa-google"></i> &nbsp;GOOGLE</a>
          <small style="color: red;">Gunakan email uin-malang.ac.id</small>
        </div>
        <hr>
        <div class="row">
          <div class="col text-sm">
            <a href="lupa.php" class="btn btn-success btn-block">LUPA Password</a>
          </div>
          <div class="col text-sm">
            <a href="daftar.php" class="btn btn-warning btn-block">DAFTAR Akun</a>
          </div>
          <!--
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
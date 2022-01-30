<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="template/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="template/dist/css/adminlte.min.css">
  <style>
    .register-page {
      background-image: url('system/uinmalang.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><img src="system/saintek-logo.png" width="100%"></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg"><b>Daftar Akun</b></p>

        <form action="daftar-simpan.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nama" name="nama">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="NIM" name="nim">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="number" class="form-control" placeholder="Ho. HP" name="nohp">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select class="form-control" name="prodi">
              <option value="Biologi">Biologi</option>
              <option value="Fisika">Fisika</option>
              <option value="Kimia">Kimia</option>
              <option value="Matematika">Matematika</option>
              <option value="Teknik Informatika">Teknik Informatika</option>
              <option value="Teknik Arsitektur">Teknik Arsitektur</option>
              <option value="Perpustakaan dan Ilmu Informasi">Perpustakaan dan Ilmu Informasi</option>
              <option value="Magister Biologi">Magister Biologi</option>
              <option value="Magister Informatika">Magister Informatika</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-home"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="userif" class="form-control" placeholder="User ID" name="userid">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="pass">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block" onclick="return confirm ('Dengan ini saya menyatakan kebenaran data yang saya isikan')">DAFTAR</button>
            </div>
          </div>
        </form>
        <hr>
        <div class="row">
          <div class="col">
            <a href="index.php" class="btn btn-warning btn-sm">Sudah terdaftar</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="template/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
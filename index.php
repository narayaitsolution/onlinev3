<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SAINTEK e-Office</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="template/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="template/dist/css/adminlte.min.css">
  <style>
    .login-page {
      background-image: url('system/uinmalang.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><img src="system/saintek-logo.png" width="100%"></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg h3"><b>SAINTEK</b> e-Office</p>

        <form action="auth.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="User ID">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!--
            <div class="col-5">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Ingat saya
                </label>
              </div>
            </div>
  -->
            <div class="col">
              <button type="submit" class="btn btn-primary btn-lg btn-block">Masuk</button>
            </div>
          </div>
        </form>
        <hr>
        <div class="row">
          <div class="col text-sm">
            <a href="forgot-password.html" class="btn btn-success btn-block">Lupa Password</a>
          </div>
          <div class="col text-sm">
            <a href="register.html" class="btn btn-warning btn-block">DAFTAR</a>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="template/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
<?php
session_start();
require('system/myfunc.php');
require('system/dbconn.php');
if (isset($_COOKIE['usertoken'])) {
    $usertoken = $_COOKIE['usertoken'];
    $cookie_name = "usertoken";
    setcookie($cookie_name, $usertoken, time() + (86400 * 3), "/");
    $nama = $_SESSION['nama'];
    $hakakses = $_SESSION['hakakses'];
} else {
    header('location:civitas-login.php');
}
date_default_timezone_set("Asia/Jakarta");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAINTEK e-Office</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="template/plugins/fontawesome-free/css/all.min.css">
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

<body class="hold-transition login-page text-sm">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><img src="system/saintek-logo.png" width="100%"></a>
            </div>

            <div class="card-body">
                <p class="login-box-msg h5">Salam, <br /><?= $nama; ?></p>
                <?php
                if (isset($_GET['pesan'])) {
                    if ($_GET['pesan'] == "tinggi") {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>ERROR!</strong> Suhu tubuh <b>terlalu tinggi</b><br />
                            Ulangi pengecekan suhu 5 menit lagi
                        </div>
                    <?php
                    } else if ($_GET['pesan'] == "rendah") {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>ERROR!! </strong> Suhu tubuh <b>terlalu rendah</b><br />
                            Ulangi pengecekan suhu 5 menit lagi
                        </div>
                <?php
                    }
                }
                ?>
                <hr>
                <p style="text-align: center;"><?= tgljam_indo(date('Y-m-d H:i:s')); ?></p>
                <hr>
                <form action="civitas-simpan.php" method="post">
                    <label>Suhu Tubuh</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="Suhu tubuh" name="suhu" step="any" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-thermometer"></span>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($hakakses == 'mahasiswa') {
                    ?>
                        <label>Tujuan</label>
                        <div class="input-group mb-3">
                            <select class="form-control" name="keperluan">
                                <option value="Praktikum" selected>Praktikum</option>
                                <option value="Penelitian" selected>Penelitian</option>
                                <option value="Kuliah">Kuliah</option>
                                <option value="Konsultasi">Konsultasi</option>
                                <option value="Administrasi">Administrasi</option>
                                <option value="Ujian Skripsi">Ujian Skripsi</option>
                                <option value="Ujian Tesis">Ujian Tesis</option>
                                <option value="Pertemuan">Pertemuan</option>
                            </select>
                        </div>
                    <?php
                    }
                    ?>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Masuk <i class="fa-solid fa-right-to-bracket"></i></button>
                </form>
            </div>
        </div>
    </div>

    <script src="template/plugins/jquery/jquery.min.js"></script>
    <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
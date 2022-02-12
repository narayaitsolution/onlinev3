<?php
session_start();
require('system/myfunc.php');
require('system/dbconn.php');
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
                <p class="login-box-msg h5">Selamat Datang di <br /><b>Fakultas Sains dan Teknologi </br>UIN Malang</b><br />Mohon mengisi identitas</p>
                <p style="text-align: center;"><?= tgljam_indo(date('Y-m-d H:i:s')); ?></p>
                <hr>
                <form action="tamu-simpan.php" method="post">
                    <label>Suhu Tubuh</label>
                    <input type="number" class="form-control" step="any" id="suhu" name="suhu" required>
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                    <label>Asal Instansi</label>
                    <input type="text" class="form-control" id="instansi" name="instansi" required>
                    <label>Tujuan</label>
                    <select class="form-control" name="tujuan">
                        <option value="SAINTEK" selected>Fakultas SAINTEK</option>
                        <option value="Biologi">Biologi</option>
                        <option value="Fisika">Fisika</option>
                        <option value="Kimia">Kimia</option>
                        <option value="Matematika">Matematika</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Teknik Arsitektur">Teknik Arsitektur</option>
                        <option value="Perpustakaan dan Ilmu Informasi">Perpustakaan dan Ilmu Informasi</option>
                        <option value="Magister Informatika">Magister Informatika</option>
                        <option value="Magister Biologi">Magister Biologi</option>
                    </select>
                    <label>Keperluan</label>
                    <input type="text" class="form-control" id="keperluan" name="keperluan" required>
                    <label>No. Telepon / HP</label>
                    <input type="text" class="form-control" id="nohp" name="nohp" required>
                    <label>E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="return conform ('Saya menyatakan bahwa data yang saya masukkan adalah benar')">MASUK <i class="fa-solid fa-right-to-bracket"></i></button>
                </form>
            </div>
        </div>
    </div>

    <script src="template/plugins/jquery/jquery.min.js"></script>
    <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
<?php
require('../system/myfunc.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAINTEK e-Office</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="../template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
    <style>
        .login-page {
            background-image: url('../system/saintek-bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><img src="../system/saintek-logo.png" width="100%"></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg h3"><b>LAPORKAN</b></p>
                <hr>
                <a href="laporkan-isi.php" class="btn btn-warning btn-lg btn-block"><i class="fa-solid fa-circle-exclamation"></i> LAPORKAN KELUHAN</a>
                <a href="gratifikasi-isi.php" class="btn btn-danger btn-lg btn-block"><i class="fa-solid fa-gift"></i> LAPORKAN GRATIFIKASI</a>
                <a href="laporkan-cek.php" class="btn btn-success btn-lg btn-block"><i class="fa-solid fa-magnifying-glass"></i> Cek Laporan</a>
            </div>
        </div>
    </div>

    <script src="../template/plugins/jquery/jquery.min.js"></script>
    <script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../template/dist/js/adminlte.min.js"></script>
</body>

</html>
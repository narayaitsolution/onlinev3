<?php
session_start();
require('system/myfunc.php');
require('system/dbconn.php');
$namaurl = $_GET['nama'];
$nama = urldecode($namaurl);
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
                <hr>
                <p style="text-align: center;"><?= tgljam_indo(date('Y-m-d H:i:s')); ?></p>
                <hr>
                Kami akan berusaha memberikan pelayanan yang terbaik kepada anda.<br />
                Apabila terdapat hal - hal yang kurang berkenan selama di Fakultas Sains dan Teknologi, silahkan melaporkan dengan klik tombol di bawah ini.<br />
                Laporan anda terjamin kerahasiaannya. <br />
                Laporan anda sangat berarti untuk perbaikan kualitas pelayanan kami.
                <hr>
                <div class="row">
                    <div class="col">
                        <a href="#" class="btn btn-danger btn-lg btn-block" onclick="return alert('COMING SOON')">LAPORKAN</a>
                    </div>
                    <div class="col">
                        <a href="https://saintek.uin-malang.ac.id" class="btn btn-primary btn-lg btn-block">SELESAI</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="template/plugins/jquery/jquery.min.js"></script>
    <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
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
    <link rel="stylesheet" href="template/plugins/fontawesome6/css/all.css">
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
                Terima kasih telah mengunjungi Fakultas Sains dan Teknologi UIN Malang.
                <br />
                Apabila terdapat hal - hal yang kurang berkenan selama di Fakultas Sains dan Teknologi silahkan melaporkan ke <a href="mailto:saintek@uin-malang.ac.id">saintek@uin-malang.ac.id</a>.
                <br />
                Laporan anda sangat berarti untuk perbaikan kualitas pelayanan kami.
                <hr>
            </div>
        </div>
    </div>

    <script src="template/plugins/jquery/jquery.min.js"></script>
    <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>
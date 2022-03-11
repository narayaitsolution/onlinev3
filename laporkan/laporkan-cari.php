<?php
require('../system/myfunc.php');
require('../system/dbconn.php');
$kode = mysqli_real_escape_string($dbsurat, $_POST['kode']);

$qlaporan = mysqli_query($dbsurat, "SELECT * FROM laporkan where kode='$kode'");
$jlaporan = mysqli_num_rows($qlaporan);
if ($jlaporan > 0) {
    $dlaporan = mysqli_fetch_array($qlaporan);
    $status = $dlaporan['status'];
}
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
                <p class="login-box-msg h3"><b>Status Laporan Anda</b></p>
                <hr>
                <?php
                if ($jlaporan > 0) {
                    if ($status == 0) {
                        echo 'Menunggu tindak lanjut pimpinan Fakultas';
                    } else {
                        echo 'Sudah di tindak lanjuti pimpinan Fakultas <br/> Terima kasih atas laporan anda';
                    }
                } else {
                    echo 'Sudah di tindak lanjuti pimpinan Fakultas';
                }
                ?>
                <hr>
                <a href="https://saintek.uin-malang.ac.id" class="btn btn-success btn-lg btn-block">Kembali</a>
            </div>
        </div>
    </div>
    <script src="../template/plugins/jquery/jquery.min.js"></script>
    <script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../template/dist/js/adminlte.min.js"></script>
</body>

</html>
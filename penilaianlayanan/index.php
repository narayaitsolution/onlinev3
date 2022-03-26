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
                <?php
                if (isset($_GET['pesan'])) {
                    if ($_GET['pesan'] == "hitungsalah") {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>ERROR!</strong> perhitungan salah!!
                        </div>
                <?php
                    }
                }
                ?>
                <form action="penilaian-simpan.php" method="POST">
                    <p class="login-box-msg h3"><b>Nilai Kami</b></p>
                    <p style="text-align: center;">Untuk peningkatan kualitas pelayanan, mohon memberikan nilai terhadap kualitas pelayanan kami</p>
                    <hr>
                    <label>Keramahan Pelayanan</label>
                    <select name="pelayanan" class="form-control">
                        <option value="5">Sangat Baik</option>
                        <option value="4" selected>Baik</option>
                        <option value="3">Cukup</option>
                        <option value="2">Buruk</option>
                        <option value="1">Sangat Buruk</option>
                    </select>
                    <label>Kecepatan Pelayanan</label>
                    <select name="kecepatan" class="form-control">
                        <option value="5">Sangat Baik</option>
                        <option value="4" selected>Baik</option>
                        <option value="3">Cukup</option>
                        <option value="2">Buruk</option>
                        <option value="1">Sangat Buruk</option>
                    </select>
                    <label>Kejelasan Prosedur Pelayanan</label>
                    <select name="kejelasan" class="form-control">
                        <option value="5">Sangat Baik</option>
                        <option value="4" selected>Baik</option>
                        <option value="3">Cukup</option>
                        <option value="2">Buruk</option>
                        <option value="1">Sangat Buruk</option>
                    </select>
                    <?php
                    $angka1 = rand(1, 5);
                    $angka2 = rand(1, 5);
                    $kunci = $angka1 + $angka2;
                    ?>
                    <label>Verifikasi</label>
                    <input type="number" placeholder="<?= huruf($angka1); ?> ditambah <?= huruf($angka2); ?> ?" class="form-control" name="verifikasi" required>
                    <input type="hidden" name="kunci" value="<?= $kunci; ?>">
                    <hr>
                    <button type="submit" class="btn btn-success btn-lg btn-block" onclick="return confirm('Lakukan Penilaian ?')">NILAI</button>
                </form>
                <hr>
                <small style="color: blue;">Catatan : Kami <b>tidak menyimpan</b> informasi anda</small>
            </div>
        </div>
    </div>

    <script src="../template/plugins/jquery/jquery.min.js"></script>
    <script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../template/dist/js/adminlte.min.js"></script>
</body>

</html>
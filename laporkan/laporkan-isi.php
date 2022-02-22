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
    <link rel="stylesheet" href="../template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
    <style>
        .container {
            background-image: url('../system/saintek-bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body class="container">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><img src="../system/saintek-logo.png" width="100%"></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg h3">Ada keluhan terkait pelayanan kami ?</p>
                <p style="text-align:center">Kami akan menindak lanjuti laporan anda untuk peningkatan kualitas pelayanan kami.</p>
                <form action="laporkan-simpan.php" enctype="multipart/form-data" method="post" id="my-form">
                    <div class="form-group row">
                        <label for="unitkerja" class="col-sm-3 col-form-label">Keluhan Terkait</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="keluhan">
                                <option value="Kebersihan">Kebersihan</option>
                                <option value="Fasilitas">Fasilitas</option>
                                <option value="Administrasi" selected>Administrasi</option>
                                <option value="Peralatan">Peralatan</option>
                                <option value="Internet / Komputer">Internet / Komputer</option>
                                <option value="Lain - Lain">Lain - Lain</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unitkerja" class="col-sm-3 col-form-label">Unit Kerja / Bagian Terkait</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="unitkerja">
                                <option value="Bagian Umum">Bagian Umum Fakultas</option>
                                <option value="Bagian Akademik">Bagian Akademik Fakultas</option>
                                <option value="Bagian Keuangan">Bagian Keuangan Fakultas</option>
                                <option value="Lab SIM">Bagian IT Fakultas</option>
                                <option value="Prodi. Biologi">Prodi. Biologi</option>
                                <option value="Prodi. Fisika">Prodi. Fisika</option>
                                <option value="Prodi. Kimia">Prodi. Kimia</option>
                                <option value="Prodi. Matematika">Prodi. Matematika</option>
                                <option value="Prodi. Teknik Informatika">Prodi. Teknik Informatika</option>
                                <option value="Prodi. Teknik Arsitektur">Prodi. Teknik Arsitektur</option>
                                <option value="Prodi. Perpustakaan dan Ilmu Informasi">Prodi. Perpustakaan dan Ilmu Informasi</option>
                                <option value="Prodi. Magister Biologi">Prodi. Magister Biologi</option>
                                <option value="Prodi. Magister Informatika">Prodi. Magister Informatika</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unitkerja" class="col-sm-3 col-form-label">Judul Laporan</label>
                        <div class="col-sm-9">
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="laporan" class="col-sm-3 col-form-label">Isi Laporan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="laporan" row="10" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bukti" class="col-sm-3 col-form-label">Bukti <small style="color:red;">*</small></label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="bukti" accept=".jpg,.jpeg">
                        </div>
                    </div>
                    <?php
                    $angka1 = rand(1, 5);
                    $angka2 = rand(1, 5);
                    $kunci = $angka1 + $angka2;
                    ?>
                    <div class="form-group row">
                        <label for="bukti" class="col-sm-3 col-form-label">Verifikasi</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="number" placeholder="<?= huruf($angka1); ?> ditambah <?= huruf($angka2); ?> ?" class="form-control" name="antibot" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-question"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <small style="color:red;">*) optional</small>
                    <hr>
                    <input type="hidden" name="kunci" value="<?= $kunci; ?>">
                    <button type="submit" id="btn-submit" class="btn btn-warning btn-lg btn-block" onclick="return confirm('Laporkan keluhan anda ?')"><i class="fa-solid fa-circle-exclamation"></i> LAPORKAN</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../template/plugins/jquery/jquery.min.js"></script>
    <script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../template/dist/js/adminlte.min.js"></script>
</body>

</html>
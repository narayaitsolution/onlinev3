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
                <a href="#" class="h1"><img src="../system/saintek-logo.png" width="50%"></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg h3">LAPORAN GRATIFIKASI</p>
                <p style="text-align:center">Mengetahui staf / dosen kami menerima gratifikasi ? LAPORKAN!!</p>
                <form action="gratifikasi-simpan.php" enctype="multipart/form-data" method="post" id="my-form">
                    <div class="form-group row">
                        <label for="penerima" class="col-sm-3 col-form-label">Nama Penerima Gratifikasi</label>
                        <div class="col-sm-9">
                            <input type="text" name="penerima" class="form-control" required>
                        </div>
                    </div>
                    <!--
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat penerima Gratifikasi <small style="color:red;">*</small></label>
                        <div class="col-sm-9">
                            <input type="text" name="alamat" class="form-control">
                        </div>
                    </div>
                    -->
                    <div class="form-group row">
                        <label for="jabatan" class="col-sm-3 col-form-label">Jabatan penerima Gratifikasi</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="jabatan">
                                <option value="Pimpinan Fakultas">Pimpinan Fakultas</option>
                                <option value="Pimpinan Program Studi">Pimpinan Program Studi</option>
                                <option value="Dosen" selected>Dosen</option>
                                <option value="Staf Administrasi">Staf Administrasi</option>
                                <option value="Laboran">Laboran</option>
                                <option value="Satpam">Satpam / Security</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 col-form-label">Tempat penerimaan Gratifikasi</label>
                        <div class="col-sm-9">
                            <input type="text" name="tempat" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unitkerja" class="col-sm-3 col-form-label">Waktu Penerimaan Gratifikasi</label>
                        <div class="col-sm-9">
                            <input type="datetime-local" name="waktu" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="laporan" class="col-sm-3 col-form-label">Uraian Gratifikasi</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="uraian" row="10" required></textarea>
                        </div>
                    </div>
                    <!--
                    <div class="form-group row">
                        <label for="unitkerja" class="col-sm-3 col-form-label">Nilai Gratifikasi <small style="color:red;">*</small></label>
                        <div class="col-sm-9">
                            <input type="number" name="nilai" class="form-control">
                        </div>
                    </div>
                    -->
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
                    <small style="color:red;">*) dapat dikosongkan</small>
                    <hr>
                    <input type="hidden" name="kunci" value="<?= $kunci; ?>">
                    <button type="submit" id="btn-submit" class="btn btn-warning btn-lg btn-block" onclick="return confirm('Laporkan ?')"><i class="fa-solid fa-circle-exclamation"></i> LAPORKAN</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../template/plugins/jquery/jquery.min.js"></script>
    <script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../template/dist/js/adminlte.min.js"></script>
</body>

</html>
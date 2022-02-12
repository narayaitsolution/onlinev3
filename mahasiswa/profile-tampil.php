<?php
session_start();
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($_SESSION['hakakses'] != "mahasiswa") {
    header("location:../deauth.php");
}
require('../system/dbconn.php');
require('../system/myfunc.php');
$no = 1;
$tahun = date('Y');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAINTEK e-Office</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini text-sm">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require('navbar.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require('sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Profile</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">User Profile</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="../system/mahasiswa.png" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center"><?= $nama; ?></h3>

                                    <p class="text-muted text-center">NIM. <?= $nip; ?></p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Program Studi</b> <a class="float-right"><?= $prodi; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Status</b> <a class="float-right"><?= strtoupper($hakakses); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- ambil data -->
                        <?php
                        $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip=$nip");
                        $duser = mysqli_fetch_array($quser);
                        $nohp = $duser['nohp'];
                        $email = $duser['email'];
                        $prodi = $duser['prodi'];
                        $user = $duser['user'];
                        $pass = $duser['pass'];
                        $buktivaksin = $duser['buktivaksin'];
                        ?>
                        <div class="col-md-9">
                            <div class="card card-primary">
                                <div class="card-header p-2">
                                    <h3 class="card-title">Data Pribadi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <FORM action="profile-update.php" enctype="multipart/form-data" class="form-horizontal" method="post">
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nip" name="nip" value="<?= $nip; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nohp" class="col-sm-2 col-form-label">No. HP</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="nohp" name="nohp" value="<?= $nohp; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail" name="email" value="<?= $email; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="prodi" class="col-sm-2 col-form-label">Program Studi</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="prodi">
                                                    <option value="<?= $prodi; ?>"><?= $prodi; ?></option>
                                                    <option value="Biologi">Biologi</option>
                                                    <option value="Fisika">Fisika</option>
                                                    <option value="Kimia">Kimia</option>
                                                    <option value="Matematika">Matematika</option>
                                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                                    <option value="Teknik Arsitektur">Teknik Arsitektur</option>
                                                    <option value="Perpustakaan dan Ilmu Informasi">Perpustakaan dan Ilmu Informasi</option>
                                                    <option value="Magister Biologi">Magister Biologi</option>
                                                    <option value="Magister Informatika">Magister Informatika</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="userid" class="col-sm-2 col-form-label">User ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="userid" name="userid" value="<?= $user; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pass" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="pass" id="pass" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pass" class="col-sm-2 col-form-label">Sertifikat Vaksin Terakhir</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($buktivaksin)) {
                                                    $bukti = '../system/noimage.gif';
                                                } else {
                                                    $bukti = $buktivaksin;
                                                }
                                                ?>
                                                <img src="<?= $bukti; ?>" width="50%" class="img-fluid">
                                                <br />
                                                <input type="file" name="fileToUpload" class="form control" accept=".jpg,.jpeg">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-warning btn-lg btn-block" onclick="return confirm('Dengan ini saya menyatakan data yang saya isikan adalah benar')">UPDATE DATA</button>
                                            </div>
                                        </div>
                                    </FORM>
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require('footer.php'); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script src="../template/plugins/jquery/jquery.min.js"></script>
    <script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../template/dist/js/adminlte.min.js"></script>
</body>

</html>
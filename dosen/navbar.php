<style>
    .main-header {
        background-color: white !important
    }
</style>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i> MENU</a>
        </li>
    </ul>
    <!-- righ navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="../system/dosen.png" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline"><?= $nama; ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="../system/dosen.png" class="img-circle elevation-2" alt="User Image">

                    <p>
                        <?= $nama; ?>
                        <small>NIP : <?= $nip; ?></small>
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <a href="#"><?= strtoupper($hakakses); ?></a>
                        </div>
                        <div class="col-6 text-center">
                            <a href="#"><?= strtoupper($jabatan); ?></a>
                        </div>
                    </div>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="profile-tampil.php" class="btn btn-default btn-flat">Profil</a>
                    <a href="../index.php" class="btn btn-default btn-flat float-right" onclick="return confirm ('Keluar dari SAINTEK e-Office ?')">Keluar</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
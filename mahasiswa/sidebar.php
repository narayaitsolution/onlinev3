<!--
<style>
    .main-sidebar {
        background-color: clear !important
    }
</style>
-->

<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="../system/uinlogo-sm.png" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>SAINTEK e-Office</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fa-solid fa-tv"></i>
                        <p>
                            Dashboard
                            <span class="right badge badge-danger"></span>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-envelopes-bulk"></i>
                        <p>
                            Pengajuan Surat
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- ijin penggunaan lab -->
                        <?php
                        //cek status menu ijinlab
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Penggunaan Lab.'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                            //jika menu ijinlab diaktifkan
                            /*
                            $query = mysqli_query($dbsurat, "SELECT * FROM ijinlab WHERE nim='$nim'");
                            $dijinlab = mysqli_fetch_array($query);
                            $statuspengajuan = $dijinlab['statuspengajuan'];
                            if ($statuspengajuan == 0 or $statuspengajuan == 1) {
                                */
                        ?>
                            <li class="nav-item">
                                <a href="ijinlab-isi.php" class="nav-link">
                                    <i class="nav-icon fas fa-flask"></i>
                                    <p>
                                        Ijin Penggunaan Lab.
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                            /*
                            }
                        */
                        }
                        ?>
                        <!-- surat keterangan -->
                        <?php
                        //cek status menu ijinlab
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Surat Keterangan'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <li class="nav-item">
                                <a href="suket-isi.php" class="nav-link">
                                    <i class="nav-icon fas fa-id-card"></i>
                                    <p>
                                        Surat Keterangan
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- surat pengantar PKL -->
                        <?php
                        //cek status menu pkl
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Surat Pengantar PKL'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <li class="nav-item">
                                <a href="pkl-isi.php" class="nav-link" onclick="return alert('Pastikan telah meng-upload bukti vaksin terakhir di User Profile')">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Surat Pengantar PKL</p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- surat ijin penelitian -->
                        <?php
                        //cek status menu ijinlab
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Penelitian'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <li class="nav-item">
                                <a href="ijinpenelitian-isi.php" class="nav-link">
                                    <i class="nav-icon fa fa-search"></i>
                                    <p>
                                        Ijin Penelitian
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- surat ijin ujian -->
                        <?php
                        //cek status menu ijinlab
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Ujian'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <li class="nav-item">
                                <a href="ijinujian-isi.php" class="nav-link">
                                    <i class="nav-icon fa fa-comments"></i>
                                    <p>
                                        Ijin Ujian Offline
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- surat ijin bimbingan -->
                        <?php
                        //cek status menu ijinlab
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Bimbingan'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <li class="nav-item">
                                <a href="ijinbimbingan-isi.php" class="nav-link">
                                    <i class="nav-icon fa fa-book"></i>
                                    <p>
                                        Ijin Bimbingan Offline
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- surat ijin observasi -->
                        <?php
                        //cek status menu ijinlab
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Observasi'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <li class="nav-item">
                                <a href="observasi-isi.php" class="nav-link">
                                    <i class="nav-icon fa fa-edit"></i>
                                    <p>
                                        Ijin Observasi
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- permohonan peminjaman alat -->
                        <?php
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Peminjaman Alat'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <li class="nav-item">
                                <a href="peminjamanalat-isi.php" class="nav-link">
                                    <i class="nav-icon fa fa-wrench"></i>
                                    <p>
                                        Peminjaman Alat
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- permohonan pengambilan data -->
                        <?php
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Pengambilan Data'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <li class="nav-item">
                                <a href="pengambilandata-isi.php" class="nav-link">
                                    <i class="nav-icon fa fa-table"></i>
                                    <p>
                                        Pengambilan Data
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- permohonan SKPI -->
                        <?php
                        $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Pengajuan SKPI'");
                        $dmenu = mysqli_fetch_array($qmenu);
                        $statussurat = $dmenu['status'];
                        if ($statussurat == 1) {
                        ?>
                            <li class="nav-item">
                                <a href="skpi-isi.php" class="nav-link">
                                    <i class="nav-icon fas fa-graduation-cap"></i>
                                    <p>
                                        Pengajuan SKPI
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="mailto:saintekonline@gmail.com" class="nav-link">
                        <i class="nav-icon fa-regular fa-circle-question"></i>
                        <p>
                            Bantuan
                            <span class="right badge badge-danger"></span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
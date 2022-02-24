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
                        <i class="nav-icon fas fa-tv"></i>
                        <p>
                            Dashboard
                            <span class="right badge badge-danger"></span>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-regular fa-file-lines"></i>
                        <p>
                            Pengajuan Surat
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="wfh-isi.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-house-laptop"></i>
                                <p>
                                    Work From Home
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="return alert('COMING SOON')">
                                <i class="nav-icon fa-solid fa-briefcase"></i>
                                <p>
                                    Surat Tugas
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="izin-isi.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-bed-pulse"></i>
                                <p>
                                    Izin Tidak Masuk
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cuti-isi.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-plane-departure"></i>
                                <p>
                                    Cuti
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-square-envelope"></i>
                        <p>
                            Disposisi Surat
                            <span class="right badge badge-danger"></span>
                        </p>
                    </a>
                </li>

                <!-- menu operator SKPI -->
                <?php
                $qoperator = mysqli_query($dbsurat, "SELECT * FROM skpi_operator WHERE kode='$nip'");
                $jmldata = mysqli_num_rows($qoperator);
                if ($jmldata == 1) {

                ?>
                    <li class="nav-item has-treeview menu-close">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>
                                SKPI
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Rekap Pengajuan SKPI'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                            ?>
                                <li class="nav-item">
                                    <a href="skpi-rekap.php" class="nav-link">
                                        <i class="nav-icon fas fa-graduation-cap"></i>
                                        <p>
                                            Rekap Pengajuan SKPI
                                            <!--<span class="right badge badge-danger">BARU</span>-->
                                        </p>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                        <ul class="nav nav-treeview">
                            <?php
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Isi data SKPI'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                            ?>
                                <li class="nav-item">
                                    <a href="skpi-isi.php" class="nav-link">
                                        <i class="nav-icon fas fa-graduation-cap"></i>
                                        <p>
                                            Isi data SKPI
                                        </p>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                <?php
                }
                ?>

                <li class="nav-item">
                    <a href="https://wa.me/6281234302099" target="_blank" class="nav-link">
                        <i class="nav-icon fa-brands fa-whatsapp"></i>
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
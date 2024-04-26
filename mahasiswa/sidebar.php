<!--
<style>
    .main-sidebar {
        background-color: clear !important
    }
</style>
-->

<aside class="main-sidebar sidebar-light-Fimary elevation-4">
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
                        <?php
                        $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                        $qdata = mysqli_fetch_array($quser);
                        $buktivaksin = $qdata['buktivaksin'];
                        if (!empty($buktivaksin)) {
                        ?>
                            <!-- surat pengantar PKL -->
                            <?php
                            //cek status menu pkl
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Surat Pengantar PKL'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {
                                    $qpkl = mysqli_query($dbsurat, "SELECT * FROM pklanggota WHERE nimanggota='$nim' and statussurat<2");
                                    $jpkl = mysqli_num_rows($qpkl);
                                    if ($jpkl > 0) {
                            ?>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="return alert('Anda hanya diijinkan mengajukan izin PKL 1x. Hubungi Koor. PKL untuk membatalkan pengajuan anda sebelumnya')">
                                                <i class="nav-icon fas fa-users"></i>
                                                <p>Pengantar PKL</p>
                                            </a>
                                        </li>
                                    <?php
                                    } else {
                                    ?>
                                        <li class="nav-item">
                                            <a href="pkl-isi.php" class="nav-link" onclick="return alert('Pastikan telah meng-upload bukti vaksin terakhir di User Profile')">
                                                <i class="nav-icon fas fa-users"></i>
                                                <p>Pengantar PKL</p>
                                            </a>
                                        </li>
                            <?php

                                    }
                                }
                            }
                            ?>

                            <!-- surat pengantar Magang -->
                            <?php
                            //cek status menu Magang
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Surat Pengantar Magang'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {
                                    $qMagang = mysqli_query($dbsurat, "SELECT * FROM maganganggota WHERE nimanggota='$nim'");
                                    $jMagang = mysqli_num_rows($qMagang);
                                    if ($jMagang > 0) {
                            ?>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="return alert('Anda hanya diijinkan mengajukan izin Magang 1x. Hubungi Koor. Magang untuk membatalkan pengajuan anda sebelumnya')">
                                                <i class="nav-icon fas fa-users"></i>
                                                <p>Pengantar Magang</p>
                                            </a>
                                        </li>
                                    <?php
                                    } else {
                                    ?>
                                        <li class="nav-item">
                                            <a href="magang-isi.php" class="nav-link" onclick="return alert('Pastikan telah meng-upload bukti vaksin terakhir di User Profile')">
                                                <i class="nav-icon fas fa-users"></i>
                                                <p>Pengantar Magang</p>
                                            </a>
                                        </li>
                            <?php

                                    }
                                }
                            }
                            ?>

                            <!-- Penghargaan -->
                            <?php
                            //cek status menu pkl
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Penghargaan'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $qpenghargaan = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE nim='$nim'");
                                $jpenghargaan = mysqli_fetch_array($qpenghargaan);
                                if ($jpenghargaan == 0) {
                            ?>
                                    <li class="nav-item">
                                        <a href="penghargaan-isi.php" class="nav-link">
                                            <i class="nav-icon fas fa-trophy"></i>
                                            <p>Penghargaan Prestasi</p>
                                            <span class="badge badge-danger right">Baru</span>
                                        </a>
                                    </li>
                            <?php
                                }
                            }
                            ?>

                            <!-- Delegasi Lomba -->
                            <?php
                            //cek status menu pkl
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Delegasi'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                            ?>
                                <li class="nav-item">
                                    <a href="delegasi-isi.php" class="nav-link">
                                        <i class="nav-icon fas fa-plane-departure"></i>
                                        <p>Pengajuan Delegasi</p>
                                        <span class="badge badge-danger right">Baru</span>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>

                            <!-- SK kegiatan -->
                            <li class="nav-item has-treeview menu-close">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa-solid fa-file-text"></i>
                                    <p>Pengajuan SK ORMAWA<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="skpanitia-isi.php" class="nav-link">
                                            <i class="nav-icon fas fa-user"></i>
                                            <p>SK Kepanitiaan</p>
                                            <span class="badge badge-danger right">Baru</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="sknarasumber-isi.php" class="nav-link">
                                            <i class="nav-icon fas fa-user-secret"></i>
                                            <p>SK Narasumber</p>
                                            <span class="badge badge-danger right">Baru</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="skpeserta-isi.php" class="nav-link">
                                            <i class="nav-icon fas fa-users"></i>
                                            <p>SK Peserta</p>
                                            <span class="badge badge-danger right">Baru</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- surat keterangan -->
                            <?php
                            //cek status menu ijinlab
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Surat Keterangan'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {

                            ?>
                                    <!-- surat rekomendasi -->
                                    <li class="nav-item">
                                        <a href="rekomendasi-isi.php" class="nav-link">
                                            <i class="nav-icon fas fa-id-card"></i>
                                            <p>
                                                Rekomendasi
                                                <span class="right badge badge-danger"></span>
                                            </p>
                                        </a>
                                    </li>

                                    <!-- surat keterangan -->
                                    <li class="nav-item">
                                        <a href="suket-isi.php" class="nav-link">
                                            <i class="nav-icon fas fa-id-card"></i>
                                            <p>
                                                Keterangan Kelakuan Baik
                                                <span class="right badge badge-danger"></span>
                                            </p>
                                        </a>
                                    </li>

                                    <!-- surat keterangan beasiswa -->
                                    <li class="nav-item">
                                        <a href="https://kemahasiswaan.uin-malang.ac.id/layanan-mahasiswa/" class="nav-link" target="_blank" onclick="return alert('Surat Keterangan Beasiswa diajukan melalui Kemahasiswaan Pusat')">
                                            <i class="nav-icon fas fa-id-card"></i>
                                            <p>
                                                Keterangan Beasiswa
                                                <span class="right badge badge-danger"></span>
                                            </p>
                                        </a>
                                    </li>

                                    <!-- surat keterangan masih studi -->
                                    <li class="nav-item">
                                        <a href="https://siakad.uin-malang.ac.id" target="_blank" class="nav-link" onclick="return alert('Surat Keterangan Aktif Kuliah dapat di ajukan melalui SIAKAD masing - masing')">
                                            <i class="nav-icon fas fa-id-card"></i>
                                            <p>
                                                Keterangan Mahasiswa Aktif
                                                <span class="right badge badge-danger"></span>
                                            </p>
                                        </a>
                                    </li>
                            <?php
                                }
                            }
                            ?>



                            <!-- surat ijin penelitian -->
                            <?php
                            //cek status menu ijinlab
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Penelitian'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {

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
                            }
                            ?>

                            <!-- ijin penggunaan lab -->
                            <?php
                            //cek status menu ijinlab
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Penggunaan Lab.'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {

                            ?>
                                    <li class="nav-item">
                                        <a href="ijinlab-isi1.php" class="nav-link">
                                            <i class="nav-icon fas fa-flask"></i>
                                            <p>
                                                Ijin Penggunaan Lab.
                                                <span class="right badge badge-danger"></span>
                                            </p>
                                        </a>
                                    </li>
                            <?php
                                }
                            }
                            ?>

                            <!-- surat ijin observasi -->
                            <?php
                            //cek status menu ijinlab
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Observasi'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {

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
                            }
                            ?>

                            <!-- permohonan pengambilan data -->
                            <?php
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Pengambilan Data'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {

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
                            }
                            ?>

                            <!-- permohonan peminjaman alat -->
                            <?php
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Peminjaman Alat'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {

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

                            <!-- surat ijin bimbingan -->
                            <?php
                            //cek status menu ijinlab
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Bimbingan'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {

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
                            }
                            ?>

                            <!-- surat ijin ujian -->
                            <?php
                            //cek status menu ijinlab
                            $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Ijin Ujian'");
                            $dmenu = mysqli_fetch_array($qmenu);
                            $statussurat = $dmenu['status'];
                            if ($statussurat == 1) {
                                $quser = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nim'");
                                $qdata = mysqli_fetch_array($quser);
                                $buktivaksin = $qdata['buktivaksin'];
                                if (!empty($buktivaksin)) {

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
                            }
                            ?>



                    </ul>
                </li>
                <!--
                <li class="nav-item">
                    <a href="../penilaianlayanan" class="nav-link">
                        <i class="nav-icon fa-solid fa-thumbs-up"></i>
                        <p>
                            Penilaian Layanan
                            <span class="right badge badge-danger"></span>
                        </p>
                    </a>
                </li>
                        -->
                <li class="nav-item">
                    <a href="mailto:saintekonline@gmail.com" class="nav-link">
                        <i class="nav-icon fa-regular fa-circle-question"></i>
                        <p>
                            Laporkan Error
                            <span class="right badge badge-danger"></span>
                        </p>
                    </a>
                </li>
            </ul>
        <?php
                        }
        ?>
        </nav>
    </div>
</aside>
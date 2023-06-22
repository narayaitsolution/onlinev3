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
                <!-- menu pengunjung fakultas khusus wadek 2& 3 -->
                <?php
                if ($jabatan == 'wadek3' or $jabatan == 'wadek2') {
                ?>
                    <li class="nav-item has-treeview menu-close">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa-solid fa-users"></i>
                            <p>
                                Pengunjung Fakultas
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pengunjung-tampil.php" class="nav-link">
                                    <i class="nav-icon fa-solid fas fa-user-clock"></i>
                                    <p>
                                        Data Hari ini
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pengunjung-rekap.php" class="nav-link">
                                    <i class="nav-icon fa-solid fas fa-users"></i>
                                    <p>
                                        Rekap Pengunjung
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <?php
                if ($jabatan == 'wadek1') {
                ?>
                    <li class="nav-item">
                        <a href="skripsi-progress.php" class="nav-link">
                            <i class="nav-icon fa-solid fas fa-graduation-cap"></i>
                            <p>
                                Progress Skripsi
                                <span class="right badge badge-danger"></span>
                            </p>
                        </a>
                    </li>
                <?php
                }
                ?>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-regular fa-file-lines"></i>
                        <p>
                            Pengajuan Surat
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        $qjenissurat = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat = 'Pengajuan WFH'");
                        $djenissurat = mysqli_fetch_array($qjenissurat);
                        $status = $djenissurat['status'];
                        if ($status == '1') {
                        ?>
                            <li class="nav-item">
                                <a href="wfh-isi.php" class="nav-link">
                                    <i class="nav-icon fa-solid fa-house-laptop"></i>
                                    <p>
                                        Work From Home
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="nav-item">
                            <?php
                            //cek apakah menu diaktifkan
                            $qjenissurat = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat = 'Pengajuan WFH'");
                            $djenissurat = mysqli_fetch_array($qjenissurat);
                            $status = $djenissurat['status'];
                            if ($status == '1') {
                                //cek apakah sudah upload bukti pelaksanaan
                                $qst = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE nip='$nip' AND statussurat=1");
                                $jst = mysqli_num_rows($qst);
                                if ($jst > 0) {
                            ?>
                                    <a href="#" class="nav-link" onclick="return alert('ANDA BELUM MENGUNGGAH BUKTI PELAKSANAAN SURAT TUGAS !!')">
                                    <?php
                                } else {
                                    ?>
                                        <a href="surattugas-isi.php" class="nav-link">
                                        <?php
                                    }
                                        ?>
                                        <i class="nav-icon fa-solid fa-briefcase"></i>
                                        <p>
                                            Surat Tugas
                                            <span class="right badge badge-danger"></span>
                                        </p>
                                        </a>
                                    <?php
                                }
                                    ?>
                        </li>
                        <li class="nav-item">
                            <a href="izin-isi.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-user-slash"></i>
                                <p>
                                    Izin Tidak Masuk
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a href="cuti-isi.php" class="nav-link">
                                <i class=" nav-icon fa-solid fa-plane-departure"></i>
                                <p>
                                    Cuti
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                            -->
                    </ul>
                </li>
                <!--
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-warehouse"></i>
                        <p>
                            Peminjaman Fasilitas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="return alert('COMING SOON')">
                                <i class="nav-icon fa-solid fa-house-user"></i>
                                <p>
                                    Peminjaman Ruangan
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="return alert('COMING SOON')">
                                <i class="nav-icon fa-solid fa-car"></i>
                                <p>
                                    Peminjaman Kendaraan
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="return alert('COMING SOON')">
                                <i class="nav-icon fa-solid fa-screwdriver-wrench"></i>
                                <p>
                                    Peminjaman Peralatan
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>
                -->
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-envelopes-bulk"></i>
                        <p>
                            Riwayat Surat
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        if ($jabatan <> 'dosen') {
                        ?>
                            <li class="nav-item">
                                <a href="pengajuanbawahan-tampil.php" class="nav-link">
                                    <i class="nav-icon fa-solid fa-envelope-open"></i>
                                    <p>
                                        Surat Bawahan Disetujui
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="nav-item">
                            <a href="pengajuanmhs-tampil.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-envelope-open-text"></i>
                                <p>
                                    Surat Mahasiswa Disetujui
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- koordinator mahasiswa -->
                <?php
                if ($jabatan == 'koormhsalumni') {
                ?>
                    <li class="nav-item">
                        <a href="koormhs-pkl-tampil.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Izin PKL
                                <span class="right badge badge-danger"></span>
                            </p>
                        </a>
                    </li>
                <?php
                }
                ?>

                <?php
                $qmenu = mysqli_query($dbsurat, "SELECT * FROM jenissurat WHERE namasurat='Pengguna Lab.'");
                $dmenu = mysqli_fetch_array($qmenu);
                $statussurat = $dmenu['status'];
                if ($statussurat == 1) {
                    $sql = mysqli_query($dbsurat, "SELECT * FROM laboratorium WHERE kalab='$nip'");
                    $jsql = mysqli_num_rows($sql);
                    if ($jsql > 0) {
                ?>
                        <li class="nav-item">
                            <a href="ijinlab-kalab-penggunalab-tampil.php" class="nav-link">
                                <i class="nav-icon fas fa-flask"></i>
                                <p>
                                    Pengguna Lab.
                                    <span class="right badge badge-danger"></span>
                                </p>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>

                <!-- menu koordinator PKL Fakultas -->
                <?php
                $qoperator = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE prodi='SAINTEK' and kdjabatan='koorpkl' and nip='$nip'");
                $jmldata = mysqli_num_rows($qoperator);
                if ($jmldata == 1) {
                ?>
                    <li class="nav-item">
                        <a href="pkl-rekap.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Rekap PKL
                                <span class="right badge badge-danger">*</span>
                            </p>
                        </a>
                    </li>

                <?php
                }
                ?>

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

                <!-- menu admin -->
                <?php
                if ($nip == '198312132019031004') {
                ?>
                    <li class="nav-item has-treeview menu-close">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-lock"></i>
                            <p>
                                Menu admin
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pejabat-tampil.php" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Manajemen Pejabat
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="lab-cekkapasitas.php" class="nav-link">
                                    <i class="nav-icon fas fa-flask"></i>
                                    <p>
                                        Kontrol Kapasitas Lab.
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="kontrolmenu-tampil.php" class="nav-link">
                                    <i class="nav-icon fas fa-envelope"></i>
                                    <p>
                                        Menu Persuratan
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="skripsi-fispii.php" class="nav-link">
                                    <i class="nav-icon fas fa-graduation-cap"></i>
                                    <p>
                                        Tarik Data Skripsi
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="loginas.php" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Login As
                                        <span class="right badge badge-danger"></span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <?php
                if ($jabatan == 'dekan' || $jabatan == 'wadek1' || $jabatan == 'wadek2' || $jabatan == 'wadek3' || $jabatan == 'kaprodi') {
                ?>
                    <li class="nav-item">
                        <a href="kinerja-rekap.php" class="nav-link" target="_blank">
                            <i class="nav-icon fa-solid fa-person-digging"></i>
                            <p>
                                Kinerja Bawahan
                                <span class="right badge badge-danger"></span>
                            </p>
                        </a>
                    </li>
                <?php
                }
                ?>
                <li class="nav-item">
                    <a href="https://helpdesk.uin-malang.ac.id" class="nav-link" target="_blank">
                        <i class="nav-icon fa-solid fa-bullhorn"></i>
                        <p>
                            Laporkan Keluhan
                            <span class="right badge badge-danger"></span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../penilaianlayanan" class="nav-link">
                        <i class="nav-icon fa-solid fa-thumbs-up"></i>
                        <p>
                            Penilaian Layanan
                            <span class="right badge badge-danger"></span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://wa.me/6281234302099" target="_blank" class="nav-link">
                        <i class="nav-icon fa-brands fa-whatsapp"></i>
                        <p>
                            Laporkan Error
                            <span class="right badge badge-danger"></span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
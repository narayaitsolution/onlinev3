<!-- connect to db -->
<?php
require('../system/dbconn.php');
require('../system/myfunc.php');
?>
<!-- ./db -->


<!-- ambil data ijin lab dari tabel suket -->
<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$datamhs = mysqli_query($dbsurat, "SELECT * FROM suket WHERE token='$token'");
$row = mysqli_fetch_array($datamhs);
$nosurat = $row['keterangan'];
$nodata = $row['no'];
$nim = $row['nim'];
$nama = $row['nama'];
$prodi = $row['prodi'];
$jenissurat = $row['jenissurat'];
$keperluan = $row['keperluan'];
$validator3 = $row['validator3'];
$validasi3 = $row['validasi3'];
$tglvalidasi3 = $row['tglvalidasi3'];
$keterangan = $row['keterangan'];
$statussurat = $row['statussurat'];

$tgl = $tglvalidasi3;
$jam = date('H-i-s');
$tahun = date('Y');
$bulan = date('m');

if ($statussurat == 1) {


    //data wd
    $datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$validator3'");
    $rowwd = mysqli_fetch_array($datawd);
    $idwd = $rowwd['iddosen'];
    $nipwd = $rowwd['nip'];
    $namawd = $rowwd['nama'];
    $jabatanwd = $rowwd['jabatan'];

    //buat qrcode
    include "../system/phpqrcode/qrlib.php";
    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //echo $actual_link;
    $tgl = date('Y-m-d');
    $jam = date('H-m-s');
    $codeContents = $actual_link;
    $namafile = $nim . "-" . "suket" . $nodata;
    QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);
?>
    <html>

    <head>
        <link rel="stylesheet" href="../system/surat.css">
    </head>

    <script>
        window.print();
    </script>

    <body>
        <table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
            <tbody>
                <td colspan="5" align="center"><img src="../system/kopsurat.jpg" width="100%" /></td>
            </tbody>
        </table>

        <table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <?php if ($jenissurat == "Surat Keterangan Kelakuan Baik") {
                        echo "<td colspan='3' align='center'><b>SURAT KETERANGAN</b></td>";
                    } else {
                        echo "<td colspan='3' align='center'><b>SURAT REKOMENDASI</b></td>";
                    }
                    ?>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" align="center">
                        <h2>Nomor : <?php echo $keterangan; ?></h2>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <font face="Times" size="12">
            <!-- table data pegawai -->
            <table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
                <tbody>
                    <tr>
                        <th width="10%"></th>
                        <th width="20%"></th>
                        <th width="20%"></th>
                        <th width="20%"></th>
                        <th width="20%"></th>
                        <th width="10%"></th>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="4">Yang bertanda tangan di bawah ini :</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Nama</td>
                        <td colspan="3">: <?php echo $namawd; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>NIP</td>
                        <td colspan="3">: <?php echo $nipwd; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Jabatan</td>
                        <td colspan="3">: <?php echo $jabatanwd; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="3"> Universitas Islam Negeri Maulana Malik Ibrahim Malang</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php if ($jenissurat == "Surat Keterangan Kelakuan Baik") {
                    ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="3">Dengan ini menerangkan bahwa :</td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="4">Dengan ini memberikan rekomendasi kepada :</td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Nama</td>
                        <td colspan="3">: <?php echo $nama; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>NIM</td>
                        <td colspan="3">: <?= $nim; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Program Studi</td>
                        <td colspan="3">: <?= $prodi; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php if ($jenissurat == "Surat Keterangan Rekomendasi") {
                    ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="4" style="text-align: justify;">untuk <?= $keperluan; ?> </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="4" style="text-align: justify;">Demikian Surat Rekomendasi ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <tr>
                            <td>&nbsp;</td>
                            <?php
                            if ($bulan < 7) {
                                $semester = "Genap";
                                $tahuna = $tahun - 1;
                                $tahunb = $tahun;
                            } else {
                                $semester = "Ganjil";
                                $tahuna = $tahun;
                                $tahunb = $tahun + 1;
                            }
                            ?>
                            <td colspan="4" style="text-align: justify;">Pada Semester <?= $semester; ?> Tahun Akademik <?= $tahuna . "/" . $tahunb; ?> adalah mahasiswa di Program Studi <?= $prodi; ?> Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang dan
                                <?php
                                if ($jenissurat == "Surat Keterangan Keringanan UKT") {
                                ?>
                                    telah memenuhi syarat administrasi untuk mendapatkan <b> KERINGANAN UKT semester <?= $semester ?> Tahun Akademik <?= $tahuna . "/" . $tahunb; ?></b>.</td>
                        <?php
                                } elseif ($jenissurat == "Surat Keterangan Penurunan UKT") {
                        ?>
                            telah memenuhi syarat administrasi untuk mendapatkan <b> PENURUNAN UKT semester <?= $semester ?> Tahun Akademik <?= $tahuna . "/" . $tahunb; ?></b>.</td>
                        <?php
                                } elseif ($jenissurat == "Surat Keterangan Perpanjangan Waktu Pembayaran UKT") {
                        ?>
                            telah memenuhi syarat administrasi untuk mendapatkan <b> PERPANJANGAN WAKTU PEMBAYARAN UKT semester <?= $semester ?> Tahun Akademik <?= $tahuna . "/" . $tahunb; ?></b>.</td>
                        <?php
                                } else {
                        ?>
                            <b>memiliki perilaku baik dalam aktivitas akademik</b>.</td>
                        <?php
                                }
                        ?>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                        if ($jenissurat == "Surat Keterangan Rekomendasi" or $jenissurat == "Surat Keterangan Kelakuan Baik") {
                        ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="4" style="text-align: justify;">Demikian Surat Keterangan ini dibuat dengan sebenarnya.</td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="4" style="text-align: justify;">Demikian Surat Keterangan ini dibuat dengan sebenarnya.</td>
                            </tr>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <!-- table bawah -->
            <table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align:center">Malang, <?= tgl_indo($tglvalidasi3); ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:center">
                            <small><i>Scan QRCode ini </i></small><br />
                            <img src="../qrcode/<?= $namafile; ?>.png" width="80" /><br />
                            <small><i>untuk verifikasi surat</i></small>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <?php
                        if ($validasi3 == 1) {
                            $sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip = '$validator3'");
                            $jdata = mysqli_num_rows($sql);
                            if ($jdata > 0) {
                                $hasil = mysqli_fetch_array($sql);
                                $ttd = $hasil['ttd'];
                            } else {
                                $ttd = 'imamtazi.jpg';
                            }
                        ?>
                            <td style="text-align:center"><img src="../ttd/<?= $ttd; ?>" width="300" /></td>
                        <?php
                        }
                        ?>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
        </font>
        </table>
    </body>

    </html>
<?php
} else {
?>
    <html>

    <body>
        <br>
        <br>
        <br>
        <h1 style="text-align: center;">SURAT TIDAK DITEMUKAN / SUDAH DIBATALKAN!!</h1>
        <h3 style="text-align: center;">SILAHKAN HUBUNGI BAGIAN ADMINISTRASI UNTUK VERIFIKASI SURAT MANUAL</h3>
        <h3 style="text-align: center;"><a href="https://saintek.uin-malang.ac.id">KLIK DISINI UNTUK KEMBALI</a></h3>
    </body>

    </html>
<?php
}
?>
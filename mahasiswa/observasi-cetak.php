<html>

<head>
    <link rel="stylesheet" href="../system/surat.css">
</head>

<script>
    window.print();
</script>

<!-- connect to db -->
<?php
require('../system/dbconn.php');
require('../system/myfunc.php');
?>
<!-- ./db -->

<!-- session -->
<?php
//session_start();
//if($_SESSION['status']!="login"){
//	header("location:../login.php?pesan=belum_login");
//}
?>
<!-- /session -->

<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
// ambil data dari record
$datasurat = mysqli_query($dbsurat, "SELECT * FROM observasi WHERE token='$token'");
$rowsurat = mysqli_fetch_array($datasurat);
$nosurat = $rowsurat['keterangan'];
$nim = $rowsurat['nim'];
$prodi = $rowsurat['prodi'];
$matakuliah = $rowsurat['matakuliah'];
$dosen = $rowsurat['dosen'];
$instansi = $rowsurat['instansi'];
$alamat = $rowsurat['alamat'];
$tglpelaksanaan = date('Y-m-d', strtotime($rowsurat['tglpelaksanaan']));
$tglvalidasi3 = $rowsurat['tglvalidasi3'];
$validator3 = $rowsurat['validator3'];
$validasi3 = $rowsurat['validasi3'];
$tglsurat = date('Y-m-d', strtotime($tglvalidasi3));


//data wd
$kdjabatan = 'wadek3';
$datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan='$kdjabatan'");
$rowwd = mysqli_fetch_array($datawd);
$nip = $rowwd['nip'];
$namawd = $rowwd['nama'];
$jabatan = $rowwd['jabatan'];

//buat qrcode
$tgl = date('Y-m-d');
$jam = date('H-i-s');
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;
$codeContents = $actual_link;
$namafile = $nim . "_" . $tgl . "_" . $jam;
QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);
?>

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
                <td colspan="2">&nbsp;</td>
                <td style="text-align:right">Malang, <?= tgl_indo($tglsurat); ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Nomor </td>
                <td>: <?= $nosurat; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Lampiran </td>
                <td>: -</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Hal </td>
                <td>: Izin Observasi</td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <font face="Times" size="12">
        <table table style="width:80%; margin-left:auto;margin-right:auto; text-align:justify" cellspacing="0" border="0">
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">Yth. <?= $instansi; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3"><?= $alamat; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">Dengan hormat,</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">Sehubungan dengan tugas mata kuliah <?= $matakuliah; ?> mahasiswa jurusan <?= $prodi; ?> Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang dengan nama - nama sebagai berikut :</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center">NIM</td>
                    <td align="center">Nama</td>
                    <td align="center">Dosen Pembimbing</td>
                    <td>&nbsp;</td>
                </tr>
                <?php
                // data peserta observasi
                $dataanggota = mysqli_query($dbsurat, "SELECT * FROM observasianggota WHERE token='$token'");
                while ($rowanggota = mysqli_fetch_array($dataanggota)) {
                    $nimanggota = $rowanggota['nimanggota'];
                    $namaanggota = $rowanggota['nama'];
                ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td align="center"><?= $nimanggota; ?></td>
                        <td align="left"><?= $namaanggota; ?></td>
                        <td align="center"><?= $dosen; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">Maka kami mohon Bapak/Ibu berkenan memberikan izin pada mahasiswa tersebut untuk melakukan observasi di <?= $instansi; ?> dengan waktu pelaksanaan pada tanggal <?= tgl_indo($tglpelaksanaan); ?> - Selesai.</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">Demikian permohonan ini, atas perhatiannya disampaikan terimakasih.</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
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
                    <td style="text-align:center">Malang, <?= tgl_indo($tgl); ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <small><i>Scan QRCode ini </i></small><br />
                        <img src="../qrcode/<?= $namafile; ?>.png" width="80" /><br />
                        <small><i>untuk verifikasi surat</i></small>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <?php
                    if ($validasi3 == 1) {
                        $sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$validator3'");
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
        </table>
    </font>
</body>

</html>
<html>

<head>
    <link rel="stylesheet" href="../system/surat.css">
</head>

<script>
    window.print();
</script>

<!-- connect to db -->
<?php
session_start();
$nip = $_SESSION['nip'];
require('../system/dbconn.php');
require('../system/myfunc.php');
?>
<!-- ./db -->

<!-- ambil data ijin lab dari tabel suket -->
<?php
$jam = date('H-i-s');
$tahun = date('Y');
$bulan = date('m');

//data wd
$datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$nip'");
$rowwd = mysqli_fetch_array($datawd);
$idwd = $rowwd['iddosen'];
$nipwd = $rowwd['nip'];
$namawd = $rowwd['nama'];
$jabatanwd = $rowwd['jabatan'];

/*
//buat qrcode
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;
$tgl = date('Y-m-d');
$jam = date('H-m-s');
$codeContents = $actual_link;
$namafile = $nim . "-" . "suket" . $nodata;
QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);
*/
?>

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
            <td colspan='3' style="text-align: center;"><b>DAFTAR PENERIMA PENGHARGAAN</b></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <?php
            if (date('m', strtotime('now')) > 6) {
                $semester = 'GANJIL';
                $tahunajaran = $tahun . '/' . date('Y', strtotime('+1 year'));;
            } else {
                $semester = 'GENAP';
                $tahunajaran = date('Y', strtotime('-1 year')) . '/' . $tahun;
            }

            ?>
            <td colspan='3' style="text-align: center;"><b>PERIODE SEMESTER<?= $semester; ?> TAHUN AJARAN <?= $tahunajaran; ?></b></td>
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
    <table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="1">
        <tbody>
            <tr>
                <th>No.</th>
                <th>Program Studi</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Kegiatan</th>
                <th>Nama kegiatan</th>
                <th>Tingkat</th>
                <th>Peringkat</th>
            </tr>
            <?php
            $no = 1;
            $qpenghargaan = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE statussurat='1' ORDER BY prodi, kegiatan, tingkat, peringkat");
            while ($dpenghargaan = mysqli_fetch_array($qpenghargaan)) {
                $prodi = $dpenghargaan['prodi'];
                $namamhs = $dpenghargaan['nama'];
                $nim = $dpenghargaan['nim'];
                $kegiatan = $dpenghargaan['kegiatan'];
                $namakegiatan = $dpenghargaan['namakegiatan'];
                $tingkat = $dpenghargaan['tingkat'];
                $peringkat = $dpenghargaan['peringkat'];
            ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $prodi; ?></td>
                    <td><?= $namamhs; ?></td>
                    <td><?= $nim; ?></td>
                    <td><?= $kegiatan; ?></td>
                    <td><?= $namakegiatan; ?></td>
                    <td><?= $tingkat; ?></td>
                    <td><?= $peringkat; ?></td>
                </tr>
            <?php
                $no++;
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
                <td style="text-align:center">Malang, <?= tgl_indo(date('Y-m-d', strtotime('now'))); ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td style="text-align:center">
                    <!--
                    <small><i>Scan QRCode ini </i></small><br />
                    <img src="../qrcode/<?= $namafile; ?>.png" width="80" /><br />
                    <small><i>untuk verifikasi surat</i></small>
        -->
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php
                $sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip = '$nipwd'");
                $jdata = mysqli_num_rows($sql);
                if ($jdata > 0) {
                    $hasil = mysqli_fetch_array($sql);
                    $ttd = $hasil['ttd'];
                } else {
                    $ttd = 'imamtazi.jpg';
                }
                ?>
                <td style="text-align:center"><img src="../ttd/<?= $ttd; ?>" width="300" /></td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
</font>
</table>

</html>
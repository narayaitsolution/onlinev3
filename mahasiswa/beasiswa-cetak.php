<html>

<head>
    <link rel="stylesheet" href="../system/surat.css">
    <style>
        table,
        thead,
        tbody,
        tfoot,
        tr,
        th,
        td {
            padding: 0;
            border-spacing: 0;
        }
    </style>
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

<!-- ambil data ijin lab dari tabel suket -->
<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$datamhs = mysqli_query($dbsurat, "SELECT * FROM beasiswa WHERE token='$token'");
$row = mysqli_fetch_array($datamhs);
$nosurat = $row['keterangan'];
$nodata = $row['no'];
$nim = $row['nim'];
$prodi = $row['prodi'];
$namabeasiswa = $row['namabeasiswa'];
$pemberibeasiswa = $row['pemberibeasiswa'];
$validator2 = $row['validator2'];
$validasi2 = $row['validasi2'];
$tglvalidasi2 = $row['tglvalidasi2'];
$keterangan = $row['keterangan'];

$tgl = $tglvalidasi2;
$jam = date('H-i-s');
$tahun = date('Y');
$bulan = date('m');



//data wd
$datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$validator2'");
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
$namafile = $token;
QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);
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
            <td colspan='3' align='center'><b>SURAT REKOMENDASI BEASISWA</b></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4" align="center">
                <h2>Nomor : <?= $keterangan; ?></h2>
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
                <td colspan="3">: <?= $namawd; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>NIP</td>
                <td colspan="3">: <?= $nipwd; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Jabatan</td>
                <td colspan="3">: <?= $jabatanwd; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3"> Fakultas Sains dan Teknologi</td>
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
                <td colspan="3">Dengan ini memberikan rekomendasi kepada :</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Nama</td>
                <td colspan="3">: <?= namadosen($dbsurat, $nim); ?></td>
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
            <tr>
                <td>&nbsp;</td>
                <td colspan="4" style="text-align: justify;">Untuk memperoleh beasiswa <?= $namabeasiswa; ?> dari <?= $pemberibeasiswa; ?>. </td>
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
                <td colspan="4" style="text-align: justify;">Demikian Surat Rekomendasi ini dibuat untuk dipergunakan sebagaimana mestinya.</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>

    <!-- table bawah -->
    <table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
        <tbody>
            <tr>
                <td width="30%">&nbsp;</td>
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
                <td style="text-align:center">a.n. Dekan</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align:center">
                    <?= $jabatanwd; ?><br />
                    <img src="../qrcode/<?= $namafile; ?>.png" width="80" /><br />
                    <?= $namawd; ?>
                </td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</font>
</table>

</html>
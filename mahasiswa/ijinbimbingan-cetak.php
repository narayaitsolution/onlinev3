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

<!-- ambil data ijin lab dari tabel suket -->
<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$datamhs = mysqli_query($dbsurat, "SELECT * FROM ijinbimbingan WHERE token='$token'");
$row = mysqli_fetch_array($datamhs);
$nodata = $row['no'];
$tanggal = $row['tanggal'];
$nim = $row['nim'];
$nama = $row['nama'];
$prodi = $row['prodi'];
$dosen = $row['dosen'];
$tglmulai = $row['tglmulai'];
$tglselesai = $row['tglselesai'];
$validator3 = $row['validator3'];
$validasi3 = $row['validasi3'];
$tglvalidasi3 = $row['tglvalidasi3'];
$keterangan = $row['keterangan'];

$tgl = $tglvalidasi3;
$jam = date('H-i-s');
$tahun = date('Y');
$bulan = date('m');



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
            <td colspan="3" align="center" style="font-size:26px">
                <b><u>SURAT KETERANGAN</u></b>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="center">
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
            <tr>
                <td>&nbsp;</td>
                <td colspan="4">Dengan ini memberikan izin kepada mahasiswa di bawah ini :</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Nama</td>
                <td colspan="3">: <?= $nama; ?></td>
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
                <td colspan="4" align="justify">Untuk melaksanakan bimbingan offline kepada <?= $dosen; ?> di Program Studi <?= $prodi; ?> Fakulas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang mulai tanggal <?= tgl_indo($tglmulai); ?> sampai dengan <?= tgl_indo($tglselesai); ?>.</td>
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
                <td colspan="4">Demikian Surat Keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</td>
                <td>&nbsp;</td>
            </tr>
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

</html>
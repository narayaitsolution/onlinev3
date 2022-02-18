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
require('../system/dbconn.php');
require('../system/myfunc.php');
?>

<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
// ambil data dari record
$datasurat = mysqli_query($dbsurat, "SELECT * FROM peminjamanalat WHERE token='$token'");
$rowsurat = mysqli_fetch_array($datasurat);
$nosurat = $rowsurat['no'];
$nim = $rowsurat['nim'];
$prodi = $rowsurat['prodi'];
$nama = $rowsurat['nama'];
$judulskripsi = $rowsurat['judulskripsi'];
$dosen = $rowsurat['dosen'];
$pimpinaninstansi = $rowsurat['pimpinaninstansi'];
$instansi = $rowsurat['instansi'];
$alamat = $rowsurat['alamat'];
$namaalat = $rowsurat['namaalat'];
$jumlahalat = $rowsurat['jumlahalat'];
$tglmulai = $rowsurat['tglmulai'];
$tglselesai = $rowsurat['tglselesai'];
$tglsurat = $rowsurat['tglvalidasi3'];
$validator3 = $rowsurat['validator3'];
$validasi3 = $rowsurat['validasi3'];
$keterangan = $rowsurat['keterangan'];

//data wd
$datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan='wadek1'");
$rowwd = mysqli_fetch_array($datawd);
$iddosen = $rowwd['iddosen'];
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

<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
    <tbody>
        <td colspan="5" align="center"><img src="../system/kopsurat.jpg" width="100%" /></td>
    </tbody>
</table>

<body>
    <table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
        <tbody>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td style="text-align:right">Malang, <?= tgl_indo($tglsurat); ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Nomor </td>
                <td colspan="2">: <?= $keterangan; ?></td>
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
                <td colspan="2">: Izin Sewa / Peminjaman Alat </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3">Yth. <?= $pimpinaninstansi; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><?= $instansi; ?></td>
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
                <td colspan="3">Sehubungan dengan penelitian mahasiswa Program Studi <?= $prodi; ?> Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang atas nama:</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Nama</td>
                <td colspan="2">: <?= $nama; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>NIM</td>
                <td colspan="2">: <?= $nim; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Judul</td>
                <td colspan="2">: <?= $judulskripsi; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Dosen Pembimbing</td>
                <td colspan="2">: <?= $dosen; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align: justify;">Maka kami mohon Bapak/Ibu berkenan memberikan izin pada mahasiswa tersebut untuk dapatnya meminjam / menyewa alat <?= $namaalat; ?> <?= $jumlahalat; ?> di <?= $instansi; ?>. </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align: justify;">Tanggal Peminjaman : <?= tgl_indo($tglmulai); ?> – <?= tgl_indo($tglselesai); ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align: justify;">Demikian permohonan ini, atas kerjasamanya disampaikan terimakasih.</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center" colspan="2"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center" colspan="2">
                    <small><i>Scan QRcode ini</i></small><br />
                    <img src="../qrcode/<?= $namafile; ?>.png" width="80" /><br />
                    <small><i>Untuk verifikasi surat</i></small>
                </td>
                <?php
                if ($validasi3 == 1) {
                    $sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE kdjabatan='wadek1'");
                    $hasil = mysqli_fetch_array($sql);
                    $ttd = $hasil['ttd'];
                ?>
                    <td style="text-align:justify"><img src="../ttd/<?= $ttd; ?>" width="300" /></td>
                <?php
                }
                ?>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center" colspan="2"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
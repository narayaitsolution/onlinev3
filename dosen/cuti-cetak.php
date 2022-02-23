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

<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$datamhs = mysqli_query($dbsurat, "SELECT * FROM cuti WHERE token='$token'");
$row = mysqli_fetch_array($datamhs);
$nosurat = $row['no'];
$nama = $row['nama'];
$nip = $row['nip'];
$prodi = $row['prodi'];
$pangkat = $row['pangkat'];
$golongan = $row['golongan'];
$jabatan = $row['jabatan'];
$jeniscuti = $row['jeniscuti'];
$tglizin1 = $row['tglizin1'];
$tglizin2 = $row['tglizin2'];
$jmlizin = $row['jmlizin'];
$alasan = $row['alasan'];
$validator2 = $row['validator2'];
$validasi2 = $row['validasi2'];
$tglvalidasi2 = $row['tglvalidasi2'];
$keterangan = $row['keterangan'];

//data wd
$datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat where nip='$validator2'");
$rowwd = mysqli_fetch_array($datawd);
$idwd = $rowwd['iddosen'];
$nipwd = $rowwd['nip'];
$namawd = $rowwd['nama'];
$jabatanwd = $rowwd['jabatan'];

//buat qrcode
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;
$codeContents = $actual_link;
$namafile = uniqid();
QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);
?>

<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
    <tbody>
        <td colspan="5" align="center"><img src="../system/kopsurat.jpg" width="100%" /></td>
    </tbody>
</table>

<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
    <thead>
        <tr>
            <td></td>
            <td width="20%"></td>
            <td colspan="2"></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>&nbsp;</td>
            <td>Nomor </td>
            <td colspan="2">: <?= $keterangan; ?></td>
            <td></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Lampiran </td>
            <td colspan="2">: 1 lembar</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Hal </td>
            <td colspan="2">: Permohonan Surat Izin <?= $jeniscuti; ?> <br /> atas nama <?= $nama; ?> </td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">Yth. Kepala Biro Administrasi Umum</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">Perencanaan dan Keuangan</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">UIN Maulana Malik Ibrahim Malang</td>
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
            <td colspan="3" style="text-align: justify;">Sehubungan dengan izin <?= strtolower($jeniscuti); ?> <?= $jabatan; ?> Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang atas nama :</td>
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
            <td>NIP</td>
            <td colspan="2">: <?= $nip; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Pangkat / Golongan</td>
            <td colspan="2">: <?= $pangkat; ?> / <?= $golongan; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Jabatan</td>
            <td colspan="2">: <?= $jabatan; ?> pada Program Studi <?= $prodi; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Satuan Organisasi</td>
            <td colspan="2">: Fakultas Sains dan Teknologi UIN Malang</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" style="text-align: justify;">Maka kami mohon untuk diberikan izin cuti <?= $jeniscuti; ?> kepada pegawai tersebut selama <?= $jmlizin; ?> hari kerja terhitung mulai <?= tgl_indo($tglizin1); ?> s.d <?= tgl_indo($tglizin2); ?> karena <?= $alasan; ?>.</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" style="text-align: justify;">Demikian surat permohonan ini dibuat, atas perhatian dan kerja sama yang baik disampaikan terima kasih.</td>
            <td>&nbsp;</td>
        </tr>

    </tbody>
</table>

<!-- table bawah -->
<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
    <tbody>
        <tr>
            <td>&nbsp;</td>
            <td>
                <small><i>Scan QRCode ini </i></small><br />
                <img src="../qrcode/<?php echo $namafile; ?>.png" width="80" /><br />
                <small><i>untuk verifikasi surat</i></small>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php
            if ($validasi2 == 1) {
                $sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip = '$validator2'");
                $hasil = mysqli_fetch_array($sql);
                $ttd = $hasil['ttd'];
            ?>
                <td style="text-align:center">Malang, <?= tgl_indo($tglvalidasi2); ?> <br /><img src="../ttd/<?= $ttd; ?>" width="300" /></td>
            <?php
            }
            ?>
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
            <td>&nbsp;</td>
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

</html>
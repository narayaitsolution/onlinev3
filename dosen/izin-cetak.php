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
//get data wfh from table wfh
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$query = mysqli_query($dbsurat, "SELECT * FROM izin WHERE token='$token'");
$data = mysqli_fetch_array($query);
$tglsurat = $data['tglsurat'];
$nip = $data['nip'];
$nama = $data['nama'];
$prodi = $data['prodi'];
$pangkat = $data['pangkat'];
$jabatan = $data['jabatan'];
$tglizin1 = $data['tglizin1'];
$tglizin2 = $data['tglizin2'];
$jenisizin = $data['jenisizin'];
$alasan = $data['alasan'];
$validator2 = $data['validator2'];
$validasi2 = $data['validasi2'];
$tglvalidasi2 = $data['tglvalidasi2'];
$nosurat = $data['keterangan'];

//get data wd
$datawd = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$validator2'");
$rowwd = mysqli_fetch_array($datawd);
$nipwd = $rowwd['nip'];
$namawd = $rowwd['nama'];

//buat qrcode
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;
$tgl = date('Y-m-d');
$jam = date('H-m-s');
$codeContents = $actual_link;
$namafile = $nip . "_" . $tgl . "_" . $jam;
QRcode::png($codeContents, "../qrcode/$namafile.png", 'L', 4, 4);
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
            <td colspan="4" align="center">
                <h1>SURAT KETERANGAN</h1>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4" align="center">
                <!--<h2>Nomor : <?= $nosurat; ?></h2>-->
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
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
            <td colspan="3">: Kabag TU Fakultas Sains dan Teknologi</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4">Dengan ini menerangkan bahwa :</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Nama</td>
            <td colspan="3">: <?= $nama; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>NIP/NIDT/NIPT</td>
            <td colspan="3">: <?= $nip; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Pangkat / Golongan</td>
            <td colspan="3">: <?= $pangkat; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Jabatan</td>
            <td colspan="3">: <?= $jabatan; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <?php
            if ($tglizin1 == $tglizin2) {
            ?>
                <td colspan="4">Pada hari <?= hari(date("N", strtotime($tglizin1))); ?> tanggal <?= tgl_indo(($tglizin1)); ?> diberikan izin <?= $jenisizin; ?> karena <?= $alasan; ?></td>
            <?php
            } else {
            ?>
                <td colspan="4">Pada hari <?= hari(date("N", strtotime($tglizin1))); ?> tanggal <?= tgl_indo(($tglizin1)); ?> s/d <?= hari(date("N", strtotime($tglizin2))); ?> tanggal <?= tgl_indo(($tglizin2)); ?> diberikan izin <?= $jenisizin; ?> karena <?= $alasan; ?></td>
            <?php
            }
            ?>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4">Surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
<br />
<br />

<!-- table bawah -->
<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
    <tbody>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align:center">Malang, <?php echo tgl_indo($tglvalidasi2); ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="text-center">
                <small><i>Scan QRCode ini </i></small><br />
                <img src="../qrcode/<?php echo $namafile; ?>.png" width="70" /><br />
                <small><i>untuk verifikasi</i></small><br />
                <small><i>keaslian surat</i></small><br />
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php
            if ($validasi2 == 1) {
                $sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$validator2'");
                $dsql = mysqli_fetch_array($sql);
                $ttd = $dsql['ttd'];
                $jabatan = $dsql['jabatan'];
                $namakaprodi = $dsql['nama'];
                $nipkaprodi = $dsql['nip'];
                if ($jabatan == 'Wakil Dekan Bidang AUPK' || $jabatan == 'Dekan') {
            ?>
                    <td style="text-align:center">
                        <img src="../ttd/<?= $ttd; ?>" width="250px"><br />
                    </td>
                <?php
                } else {
                ?>
                    <td style="text-align:center">
                        <!--<?= $jabatan; ?><br />-->
                        <img src="../ttd/<?= $ttd; ?>" width="100px"><br />
                        <u><?= $namakaprodi; ?></u><br />
                        NIP. <?= $nipkaprodi; ?>
                    </td>
            <?php
                }
            }
            ?>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>

</html>
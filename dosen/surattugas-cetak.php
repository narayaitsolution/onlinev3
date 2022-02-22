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
$query = mysqli_query($dbsurat, "SELECT * FROM surattugas WHERE token='$token'");
$data = mysqli_fetch_array($query);
$tglsurat = $data['tglsurat'];
$nip = $data['nip'];
$nama = $data['nama'];
$prodi = $data['prodi'];
$pangkat = $data['pangkat'];
$golongan = $data['golongan'];
$jabatan = $data['jabatan'];
$untuk = $data['untuk'];
$tglpelaksanaan = $data['tglpelaksanaan'];
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
                <h1><u>SURAT TUGAS</u></h1>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4" align="center">
                <h2>Nomor : <?= $nosurat; ?></h2>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td>Menimbang </td>
            <td colspan="5">: 1. Perintah Pimpinan tanggal <?= tgl_indo($tglvalidasi2); ?></td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align: center;" colspan="6"><b>Memberikan Tugas Kepada :</b></td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; text-align: center;" width="5%">No.</td>
            <td style="border: 1px solid black; text-align: center;">Nama / NIP</td>
            <td style="border: 1px solid black; text-align: center;">Pangkat / Golongan</td>
            <td colspan="2" style="border: 1px solid black; text-align: center;">Jabatan</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black;text-align: center;">1.</td>
            <td style="border: 1px solid black;"><?= $nama; ?> <br /> NIP. <?= $nip; ?></td>
            <td style="border: 1px solid black;"><?= $pangkat; ?> / <?= $golongan; ?></td>
            <td colspan="2" style="border: 1px solid black;"><?= strtolower($jabatan); ?> <?= $prodi; ?></td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td>Untuk</td>
            <td colspan="5">: <?= $untuk; ?> pada tanggal <?= tgl_indo($tglpelaksanaan); ?></td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Keterangan lain - lain</td>
            <td colspan="5">
                : 1. Supaya dilaksanakan dengan penuh tanggung jawab. <br />
                2. Membuat laporan kegiatan dan diserahkan kepada Dekan paling lambat 1 (satu) minggu setelah menyelesaikan tugas.<br />
                3. Surat tugas ini disampaikan kepada yang bersangkutan untuk diketahui dan diindahkan sebagaimana mestinya.
            </td>
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
                $sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip='$validator2' AND kdjabatan='dekan'");
                $dsql = mysqli_fetch_array($sql);
                $ttd = $dsql['ttd'];
                $jabatan = $dsql['jabatan'];
                $namakaprodi = $dsql['nama'];
                $nipkaprodi = $dsql['nip'];
            ?>
                <td style="text-align:center">
                    <!--<?= $jabatan; ?><br />-->
                    <img src="../ttd/<?= $ttd; ?>" width="300px"><br />
                    <!--<u><?= $namakaprodi; ?></u><br />-->
                    <!--NIP. <?= $nipkaprodi; ?>-->
                </td>
            <?php
            }
            ?>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>

</html>
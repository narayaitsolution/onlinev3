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

<!-- ambil data -->
<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$qnosurat = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE token='$token'");
$dnosurat = mysqli_fetch_array($qnosurat);
$keterangan = $dnosurat['keterangan'];
$validator2 = $dnosurat['validator2'];
$jam = date('H-i-s');
$tahun = date('Y');
$bulan = date('m');

?>

<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
    <tbody>
        <td colspan="5" style="text-align: center;"><img src="../system/kopsurat.jpg" width="100%" /></td>
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
            <td colspan="3" style="text-align: center;"><b>SURAT REKOMENDASI</b></td>
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
            <td colspan="6">&nbsp;</td>
        </tr>
    </tbody>
</table>
<font face="Times" size="12">
    <!-- table data pegawai -->
    <table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
        <tbody>
            <tr>
                <td colspan="6">Yang bertanda tangan di bawah ini :</td>
            </tr>
            <tr>
                <td colspan="2">Nama</td>
                <td colspan="4">: <?= namadosen($dbsurat, $validator2); ?></td>
            </tr>
            <tr>
                <td colspan="2">NIP</td>
                <td colspan="4">: <?= $validator2; ?></td>
            </tr>
            <tr>
                <td colspan="2">Jabatan</td>
                <td colspan="4">: Wakil Dekan Bidang Kemahasiswaan dan Kerja Sama</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">Dengan ini memberikan rekomendasi kepada :</td>
            </tr>
            <!-- ambil data -->
            <?php
            $nomer = 1;
            $qdelegasi = mysqli_query($dbsurat, "SELECT * FROM delegasi WHERE token='$token'");
            $ddelegasi = mysqli_fetch_array($qdelegasi);
            $nodata = $ddelegasi['no'];
            $nim = $ddelegasi['nim'];
            $prodi = $ddelegasi['prodi'];
            $jeniskegiatan = $ddelegasi['jeniskegiatan'];
            $namakegiatan = $ddelegasi['namakegiatan'];
            $tglmulai = $ddelegasi['tglmulai'];
            $tglselesai = $ddelegasi['tglselesai'];
            $tempat = $ddelegasi['tempat'];
            $tglvalidasi3 = $ddelegasi['tglvalidasi3'];
            $validasi3 = $ddelegasi['validasi3'];
            $validator3 = $ddelegasi['validator3'];
            $keterangan = $ddelegasi['keterangan'];
            $biaya = $ddelegasi['biaya'];
            $qdelegasikelompok = mysqli_query($dbsurat, "SELECT * FROM delegasianggota WHERE token='$token'");
            while ($ddelegasikelompok = mysqli_fetch_array($qdelegasikelompok)) {
                $nimanggota = $ddelegasikelompok['nimanggota'];
            ?>
                <tr>
                    <td><?= $nomer; ?></td>
                    <td>Nama</td>
                    <td colspan="4">: <?= namadosen($dbsurat, $nimanggota); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>NIM</td>
                    <td colspan="4">: <?= $nimanggota; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Jurusan</td>
                    <td colspan="4">: <?= $prodi; ?></td>
                </tr>
            <?php
                $nomer++;
            }
            ?>
            <tr>
                <td colspan="6" style="text-align: justify;">Untuk mengikuti kegiatan <?= $namakegiatan; ?> di <?= $tempat; ?> pada tanggal <?= tgl_indo($tglmulai); ?> - <?= tgl_indo($tglselesai); ?></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: justify;">Demikian surat rekomendasi ini dibuat agar dapat dipergunakan sebagaimana mestinya.</td>
            </tr>
        </tbody>
    </table>

    <!-- ambil data wd -->
    <?php
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
    $namafile = $token;
    QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);

    ?>
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
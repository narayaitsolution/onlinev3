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
            <td colspan="3" style="text-align: center;"><b>DISPOSISI PENDELEGASIAN MAHASISWA</b></td>
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
                <td colspan="6">Sehubungan dengan pengajuan delegasi mahasiswa :</td>
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
                <td colspan="6" style="text-align: justify;">Untuk melaksanakan kegiatan <?= $namakegiatan; ?> di <?= $tempat; ?> pada tanggal <?= tgl_indo($tglmulai); ?> - <?= tgl_indo($tglselesai); ?>.</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: justify;">Maka dengan ini kami mohon kepada PPK dan BPP Fakulas Sains dan Teknologi untuk memproses pencairan dana pendelegasian mahasiswa tersebut sebesar Rp. ............................</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: justify;">Atas bantuannya disampaikan terima kasih</td>
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
    $namafile = $nim . "-" . "suket" . $nodata;
    QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);

    ?>
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
                <td width="30%">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align:center">Malang, <?= tgl_indo($tglvalidasi3); ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align:center">Wakil Dekan Bidang Kemahasiswaan dan Kerjasama</td>
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
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align:center">
                    <img src="../qrcode/<?= $namafile; ?>.png" width="80" /><br />
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
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align:center">Dr. Dwi Suheriyanto, S.Si, M.P.</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</font>
</table>

<!-- lampiran -->
<table>
    <tr>
        <td style="page-break-after: always">&nbsp;</td>
    </tr>
</table>
<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
    <tbody>
        <td colspan="5" style="text-align: center;"><img src="../system/kopsurat.jpg" width="100%" /></td>
    </tbody>
</table>
<!-- ambil data upload -->
<?php
$qupload = mysqli_query($dbsurat, "SELECT * FROM delegasiupload WHERE token='$token'");
$dupload = mysqli_fetch_array($qupload);
$noktp = $dupload['noktp'];
$fotoktp = $dupload['fotoktp'];
$fotoktm = $dupload['fotoktm'];
$bank = $dupload['bank'];
$norek = $dupload['norek'];
$butab = $dupload['butab'];
?>
<table table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0" border="0">
    <tbody>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;"><b>LAMPIRAN DISPOSISI PENDELEGASIAN MAHASISWA</b></td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td>Nama Ketua Delegasi</td>
            <td colspan="5">: <?= namadosen($dbsurat, $nim); ?></td>
        </tr>
        <tr>
            <td>NIM</td>
            <td colspan="5">: <?= $nim; ?></td>
        </tr>
        <tr>
            <td>No. Telp</td>
            <td colspan="5">: <?= nohp($dbsurat, $nim); ?></td>
        </tr>
        <tr>
            <td>Foto KTM</td>
            <td colspan="5"><img src="<?= $fotoktm; ?>" width="300px"></td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td>Bank</td>
            <td colspan="5">: <?= $bank; ?></td>
        </tr>
        <tr>
            <td>No. Rekening</td>
            <td colspan="5">: <?= $norek; ?></td>
        </tr>
        <tr>
            <td>Foto Buku Tabungan</td>
            <td colspan="5"><img src="<?= $butab; ?>" width="300px"></td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td>No. KTP</td>
            <td colspan="5">: <?= $noktp; ?></td>
        </tr>
        <tr>
            <td>Foto KTP</td>
            <td colspan="5"><img src="<?= $fotoktp; ?>" width="300px"></td>
        </tr>
    </tbody>
</table>

</html>
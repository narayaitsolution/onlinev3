<html>

<head>
    <link rel="stylesheet" href="../system/surat.css">
    <style>
        table,
        th,
        td {
            border: none;
            font-family: Cambria,
                'MyCambria',
                serif;

        }

        @font-face {
            font-family: 'MyCambria';
            src: url('../system/cambria.ttf') format('truetype');
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

<!-- ambil data SK dari database -->
<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$qsk = mysqli_query($dbsurat, "SELECT * FROM sk WHERE token='$token'");
$dsk = mysqli_fetch_array($qsk);
$tanggal = $dsk['tanggal'];
$prodi = $dsk['prodi'];
$nimmhs = $dsk['nim'];
$jenissk = $dsk['jenissk'];
$namakegiatan = $dsk['namakegiatan'];
$ormas = $dsk['ormas'];
$tema = $dsk['tema'];
$verifikator1 = $dsk['verifikator1'];
$verifikasi1 = $dsk['verifikasi1'];
$tglverifikasi1 = $dsk['tglverifikasi1'];
$keterangan = $dsk['keterangan'];
$pembiayaan = $dsk['pembiayaan'];
$token = $dsk['token'];
$tahunsurat = date('Y', strtotime($tglverifikasi1));

//buat qrcode
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$codeContents = $actual_link;
$namafile = uniqid();
QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);
?>

<table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0">
    <tbody>
        <tr>
            <td colspan="5" style="text-align: center;"><img src="../system/uinlogo-bw.png" width="100px"></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>SURAT KEPUTUSAN DEKAN</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>FAKULTAS SAINS DAN TEKNOLOGI</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>UNIVERSITAS ISLAM NEGERI MAULANA MALIK IBRAHIM MALANG</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>Nomor : <?= $keterangan; ?></b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">Tentang</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>PENETAPAN PANITIA KEGIATAN <?= $namakegiatan; ?></b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b><?= strtoupper($ormas); ?></b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>FAKULTAS SAINS DAN TEKNOLOGI</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>UIN MAULANA MALIK IBRAHIM MALANG</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>TAHUN ANGGARAN <?= $tahunsurat; ?></b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
    </tbody>
</table>
<!-- table body -->
<table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0">
    <tbody>
        <tr>
            <td colspan="5" style="text-align: center;"><b>DEKAN FAKULTAS SAINS DAN TEKNOLOGI</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>UNIVERSITAS ISLAM NEGERI MAULANA MALIK IBRAHIM MALANG</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Menimbang</b></td>
            <td style="vertical-align:top;">:</td>
            <td style="vertical-align:top;">a.</td>
            <td colspan="2" style="text-align: justify;">bahwa guna mendukung Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= $ormas; ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”, maka perlu adanya Panitia;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">b.</td>
            <td colspan="2" style="text-align: justify;">bahwa berdasarkan poin a, maka perlu ditetapkan dengan Keputusan Dekan tentang Penetapan Panitia Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= $ormas; ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”.</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Mengingat</b></td>
            <td style="vertical-align:top;">:</td>
            <td style="vertical-align:top;">1.</td>
            <td colspan="2" style="text-align: justify;">Undang-undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">2.</td>
            <td colspan="2" style="text-align: justify;">Keputusan Menteri Agama Republik Indonesia Nomor 8 tahun 2013 tentang Tata kerja Universitas Islam Negeri Maulana Malik Ibrahim Malang;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">3.</td>
            <td colspan="2" style="text-align: justify;">Peraturan Menteri Agama Republik Indonesia Nomor 15 Tahun 2017 tentang Statuta Universitas Islam Negeri Maulana Malik Ibrahim Malang;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">4.</td>
            <td colspan="2" style="text-align: justify;">Surat Keputusan Dekan Fakultas Sains dan Teknologi Nomor Un.03.6/PP.01.2/2452/2017 tentang Pedoman Pendidikan Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang Tahun Akademik 2017/2018;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">5.</td>
            <td colspan="2" style="text-align: justify;">Surat Keputusan Rektor Universitas Islam Negeri Maulana Malik Ibrahim Malang Nomor 1676 Tahun 2021 tanggal 12 Mei 2021 tentang Pedoman Pendidikan Universitas Islam Negeri Maulana Malik Ibrahim Malang.</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Memperhatikan</b></td>
            <td style="vertical-align:top;">:</td>
            <td style="vertical-align:top;">1.</td>
            <td colspan="2" style="text-align: justify;">Surat Permohonan dari <?= $ormas; ?> tanggal <?= tgl_indo($tanggal); ?>;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">2.</td>
            <td colspan="2" style="text-align: justify;">Disposisi Pimpinan tanggal <?= tgl_indo($tanggal); ?>.</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;page-break-after: always;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>MEMUTUSKAN</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Menetapkan</b></td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;"><b>Keputusan Dekan Fakultas Sains dan Teknologi tentang Penetapan Panitia Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= $ormas; ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”.</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Pertama</b></td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;">Menetapkan Panitia Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= $ormas; ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”, seperti yang tersebut dalam daftar keputusan ini.</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Kedua</b></td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;">Menugaskan kepada Panitia sebagaimana dimaksud dalam daftar terlampir.</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Ketiga</b></td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;">Segala pembiayaan yang dikeluarkan sebagai akibat pelaksanaan Keputusan ini dibebankan kepada <?= $pembiayaan; ?></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Keempat</b></td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;">Keputusan ini berlaku Sejak tanggal ditetapkan dengan ketentuan apabila dikemudian hari terdapat kekeliruan dalam penetapannya akan diadakan perbaikan sebagaimana mestinya.</textarea></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
    </tbody>
</table>
<!-- table footer -->
<table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0">
    <tbody>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">Ditetapkan di Malang</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">Pada tanggal <?= tgl_indo($tglverifikasi1); ?></td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">DEKAN,</td>
        </tr>
        <tr>
            <td width="60%" class="text-center">
                <small><i>Scan QRCode ini </i></small><br />
                <img src="../qrcode/<?php echo $namafile; ?>.png" width="70" /><br />
                <small><i>untuk verifikasi</i></small><br />
                <small><i>keaslian surat</i></small><br />
            </td>
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">SRI HARINI</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
        </tr>
    </tbody>
</table>
<!-- table tembusan -->
<table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0">
    <tbody>
        <tr>
            <td colspan="5"><b><u>Tembusan disampaikan kepada :</u></b></td>
        </tr>
        <tr>
            <td colspan="5">1. Yth. Para Wakil Dekan;</td>
        </tr>
        <tr>
            <td colspan="5">2. Yth. Para Ketua Jurusan;</td>
        </tr>
        <tr>
            <td colspan="5">3. Yth. Bendahara Pembantu Pengeluaran;</td>
        </tr>
        <tr>
            <td colspan="5">4. Yang bersangkutan;</td>
        </tr>
        <tr>
            <td colspan="5">5. Arsip;</td>
        </tr>
    </tbody>
</table>
<p style="page-break-before: always;">&nbsp;</p>
<table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0">
    <tbody>
        <tr>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;"></td>
            <td colspan="3" style="text-align: justify;"></td>
        </tr>
        <tr>
            <td style="vertical-align:top;">Lampiran</td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;">Surat Keputusan Dekan Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang</td>
        </tr>
        <tr>
            <td style="vertical-align:top;">Nomor</td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;"><?= $keterangan; ?></td>
        </tr>
        <tr>
            <td style="vertical-align:top;">Tanggal</td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;"><?= tgl_indo($tglverifikasi1); ?></td>
        </tr>
        <tr>
            <td style="vertical-align:top;">Tentang</td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>PENETAPAN PANITIA KEGIATAN <?= $namakegiatan; ?></b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b><?= strtoupper($ormas); ?></b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>FAKULTAS SAINS DAN TEKNOLOGI</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>UIN MAULANA MALIK IBRAHIM MALANG</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;"><b>TAHUN ANGGARAN <?= $tahunsurat; ?></b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
    </tbody>
</table>
<!-- table Panitia -->
<table style="width:90%; margin-left:auto;margin-right:auto;" cellspacing="0">
    <thead>
        <tr>
            <td style="border: 1px solid;text-align: center;" width="5%"><b>NO</b></td>
            <td style="border: 1px solid;text-align: center;" width="35%"><b>Sie. Kepanitiaan</b></td>
            <td style="border: 1px solid;text-align: center;"><b>Nama</b></td>
            <td style="border: 1px solid;text-align: center;" width="25%"><b>NIM</b></td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $qPanitia = mysqli_query($dbsurat, "SELECT * FROM skpanitia WHERE token='$token'");
        while ($dPanitia = mysqli_fetch_array($qPanitia)) {
            $namapanitia = $dPanitia['nama'];
            $nimpanitia = $dPanitia['nim'];
            $siepanitia = $dPanitia['siepanitia'];
        ?>
            <tr>
                <td style="border: 1px solid;"><?= $no; ?></td>
                <td style="border: 1px solid;"><?= $siepanitia; ?></td>
                <td style="border: 1px solid;"><?= $namapanitia; ?></td>
                <td style="border: 1px solid;"><?= $nimpanitia; ?></td>
            <tr>
            <?php
            $no++;
        }
            ?>
    </tbody>
</table>
<!-- table ttd lampiran -->
<table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0">
    <tbody>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">Ditetapkan di Malang</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">Pada tanggal <?= tgl_indo($tglverifikasi1); ?></td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">DEKAN,</td>
        </tr>
        <tr>
            <td width="60%" class="text-center">
                <small><i>Scan QRCode ini </i></small><br />
                <img src="../qrcode/<?php echo $namafile; ?>.png" width="70" /><br />
                <small><i>untuk verifikasi</i></small><br />
                <small><i>keaslian surat</i></small><br />
            </td>
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">SRI HARINI</td>
        </tr>
    </tbody>
</table>

</html>
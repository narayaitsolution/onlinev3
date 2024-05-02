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
$namakegiatan = strtoupper($dsk['namakegiatan']);
$ormas = strtoupper($dsk['ormas']);
$tema = $dsk['tema'];
$verifikator1 = $dsk['verifikator1'];
$verifikasi1 = $dsk['verifikasi1'];
$tglverifikasi1 = $dsk['tglverifikasi1'];
$keterangan = $dsk['keterangan'];
$pembiayaan = $dsk['pembiayaan'];
$token = $dsk['token'];
$cetak = $dsk['cetak'];
$tahunsurat = date('Y', strtotime($tglverifikasi1));


//buat qrcode
include "../system/phpqrcode/qrlib.php";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$codeContents = $actual_link;
$namafile = uniqid();
QRcode::png($codeContents, "../qrcode/$namafile.png", "L", 4, 4);

//update jumlah cetak
$jmlcetak = $cetak + 1;
$qupdatecetak = mysqli_query($dbsurat, "UPDATE sk SET cetak='$jmlcetak' WHERE token='$token'");
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
            <td colspan="5" style="text-align: center;"><b>PENETAPAN NARASUMBER KEGIATAN <?= strtoupper($namakegiatan); ?></b></td>
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
            <td colspan="2" style="text-align: justify;">bahwa guna mendukung Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= $ormas; ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”, maka perlu adanya Narasumber;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">b.</td>
            <td colspan="2" style="text-align: justify;">bahwa berdasarkan poin a, maka perlu ditetapkan dengan Keputusan Dekan tentang Penetapan Narasumber Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= $ormas; ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”.</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Mengingat</b></td>
            <td style="vertical-align:top;">:</td>
            <td style="vertical-align:top;">1.</td>
            <td colspan="2" style="text-align: justify;">Undang-Undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">2.</td>
            <td colspan="2" style="text-align: justify;">Undang-Undang Nomor 12 Tahun 2012 tentang Pendidikan Tinggi;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">3.</td>
            <td colspan="2" style="text-align: justify;">Peraturan Pemerintah Nomor 4 Tahun 2014 tentang Penyelenggaraan dan Pengelolaan Perguruan Tinggi;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">4.</td>
            <td colspan="2" style="text-align: justify;">Keputusan Presiden Nomor 50 Tahun 2004 tentang perubahan Sekolah Tinggi Agama Islam Negeri (STAIN) Malang menjadi Universitas Islam Negeri (UIN) Malang;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">5.</td>
            <td colspan="2" style="text-align: justify;">Keputusan Menteri Agama Nomor 65 Tahun 2009 tentang Perubahan Universitas Islam Negeri (UIN) Malang menjadi Universitas Islam Negeri Maulana Malik Ibrahim Malang;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">6.</td>
            <td colspan="2" style="text-align: justify;">Keputusan Menteri Agama Nomor 15 Tahun 2017 tentang Statuta Universitas Islam Negeri Malang;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">7.</td>
            <td colspan="2" style="text-align: justify;">Peraturan Menteri Agama Nomor 2 Tahun 2018 tentang Organisasi dan Tata Kerja Universitas Islam Negeri Malang;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">8.</td>
            <td colspan="2" style="text-align: justify;">Keputusan Direktur Jenderal Pendidikan Islam Nomor 4961 Tahun 2016 tentang Pedoman Umum Organisasi Kemahasiswaan pada Perguruan Tinggi Keagamaan Islam;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">9.</td>
            <td colspan="2" style="text-align: justify;">Keputusan Rektor Universitas Islam Negeri Maulana Malik Ibrahim Malang Nomor : 4663/Un.3/Hk.00.5/08/2018 tentang Pedoman Umum Pembinaan Organisasi Kemahasiswaan Universitas Islam Negeri Maulana Malik Ibrahim Malang;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b></b></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">10.</td>
            <td colspan="2" style="text-align: justify;">Keputusan Dekan Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang Nomor : 2044/FST/HK.00.5/07/2022 tentang Pedoman Umum Pembinaan Organisasi Kemahasiswaan Fakultas Sains dan Teknologi.</td>
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
            <td colspan="3" style="text-align: justify;"><b>Keputusan Dekan Fakultas Sains dan Teknologi tentang Penetapan Narasumber Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= $ormas; ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”.</b></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Pertama</b></td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;">Menetapkan Narasumber Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= $ormas; ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”, seperti yang tersebut dalam daftar keputusan ini.</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"><b>Kedua</b></td>
            <td style="vertical-align:top;">:</td>
            <td colspan="3" style="text-align: justify;">Menugaskan kepada Narasumber sebagaimana dimaksud dalam daftar terlampir.</td>
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
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%" style="text-align: center;">^</td>
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
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">SRI HARINI</td>
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
            <td colspan="5" style="text-align: center;"><b>PENETAPAN NARASUMBER KEGIATAN <?= strtoupper($namakegiatan); ?></b></td>
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
<!-- table narasumber -->
<table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0">
    <thead>
        <tr>
            <td style="border: 1px solid;text-align: center;" width="5%"><b>NO</b></td>
            <td style="border: 1px solid;text-align: center;" width="35%"><b>NAMA</b></td>
            <td style="border: 1px solid;text-align: center;"><b>MATERI</b></td>
            <td style="border: 1px solid;text-align: center;" width="25%"><b>JADWAL</b></td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $qnarasumber = mysqli_query($dbsurat, "SELECT * FROM sknarsum WHERE token='$token'");
        while ($dnarasumber = mysqli_fetch_array($qnarasumber)) {
            $namanarsum = $dnarasumber['nama'];
            $materi = $dnarasumber['materi'];
            $jadwal = $dnarasumber['jadwal'];
            $jammulai = $dnarasumber['jammulai'];
            $jamselesai = $dnarasumber['jamselesai'];
        ?>
            <tr>
                <td style="border: 1px solid;"><?= $no; ?></td>
                <td style="border: 1px solid;"><?= $namanarsum; ?></td>
                <td style="border: 1px solid;"><?= $materi; ?></td>
                <td style="border: 1px solid;"><?= tgl_indo($jadwal); ?> <br> jam <?= $jammulai; ?> - <?= $jamselesai; ?></td>
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
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">DEKAN,</td>
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
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%" style="text-align: center;">^</td>
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
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">SRI HARINI</td>
        </tr>
    </tbody>
</table>

</html>
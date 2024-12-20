<?php
session_start();
require('../system/dbconn.php');
require('../system/myfunc.php');
$user = $_SESSION['user'];
$nip = $_SESSION['nip'];
$nama = $_SESSION['nama'];
$prodi = $_SESSION['prodi'];
$hakakses = $_SESSION['hakakses'];
$jabatan = $_SESSION['jabatan'];
if ($hakakses != "subsatker") {
    header("location:../deauth.php");
}
$tglsekarang = date('Y-m-d');
$tahun = date('Y');
$bulan = date('m');
$no = 1;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAINTEK e-Office</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="../template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

<body class="hold-transition sidebar-mini text-sm">
    <div class="wrapper">
        <?php
        require('navbar.php');
        require('sidebar.php');
        ?>

        <div class="content-wrapper">
            <!-- ambil data SK dari database -->
            <?php
            $token = mysqli_real_escape_string($dbsurat, $_GET['token']);
            $qsk = mysqli_query($dbsurat, "SELECT * FROM sk WHERE token='$token' AND verifikasi1=1 AND verifikator2='$nip' AND verifikasi2=0");
            $dsk = mysqli_fetch_array($qsk);
            $tanggal = $dsk['tanggal'];
            $prodi = $dsk['prodi'];
            $nimmhs = $dsk['nim'];
            $jenissk = $dsk['jenissk'];
            $namakegiatan = $dsk['namakegiatan'];
            $ormas = $dsk['ormas'];
            $tema = $dsk['tema'];
            $nosurat = $dsk['nosurat'];
            $verifikator1 = $dsk['verifikator1'];
            $verifikasi1 = $dsk['verifikasi1'];
            $tglverifikasi1 = $dsk['tglverifikasi1'];
            $keterangan = $dsk['keterangan'];
            $token = $dsk['token'];
            $bulanverifikasi1 = date('m', strtotime($tglverifikasi1));
            ?>

            <!-- tabel pengajuan pribadi -->
            <section class="content">
                <!--alert-->
                <?php
                if (isset($_GET['pesan'])) {
                    $pesan = $_GET['pesan'];
                    $hasil = $_GET['hasil'];
                    if ($hasil == 'ok') {
                ?>
                        <script>
                            swal('BERHASIL!', '<?= $pesan; ?>', 'success');
                        </script>

                    <?php
                    } else {
                    ?>
                        <script>
                            swal('ERROR!', '<?= $pesan; ?>', 'error');
                        </script>
                <?php
                    }
                }
                ?>
                <!-- Pengajuan Surat Mahasiswa -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Draft SK</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
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
                                        <td colspan="5" style="text-align: center;"><b>Nomor : <input type="number" name="nosurat" style="width: 7em" value="<?= $nosurat; ?>" required>/FST/<?= $bulanverifikasi1; ?>/<?= $tahun; ?></b></td>
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
                                        <td colspan="5" style="text-align: center;">Tentang</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: center;"><b>PENETAPAN PANITIA </b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: center;"><b>KEGIATAN <?= strtoupper($namakegiatan); ?> </b></td>
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
                                        <td colspan="5" style="text-align: center;"><b>TAHUN ANGGARAN <?= $tahun; ?></b></td>
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
                                        <td colspan="2" style="text-align: justify;">bahwa guna mendukung Kegiatan <input type="text" name="namakegiatan" value="<?= $namakegiatan; ?>" style="width: 20em" required> yang dilaksanakan oleh <input type="text" name="ormas" value="<?= strtoupper($ormas); ?>" style="width: 10em" required> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<input type="text" name="tema" value="<?= $tema; ?>" style="width: 30em" required>”, maka perlu adanya Panitia;</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;">b.</td>
                                        <td colspan="2" style="text-align: justify;">bahwa berdasarkan poin a, maka perlu ditetapkan dengan Keputusan Dekan tentang Penetapan Panitia Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= strtoupper($ormas); ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”.</td>
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
                                        <td colspan="2" style="text-align: justify;">Keputusan Direktur Jenderal Pendidikan Islam Nomor 3814 Tahun 2024 tentang Petunjuk Teknis Organisasi Kemahasiswaan pada Perguruan Tinggi Keagamaan Islam;</td>
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
                                        <td colspan="5" style="text-align: center;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;"><b>Memperhatikan</b></td>
                                        <td style="vertical-align:top;">:</td>
                                        <td style="vertical-align:top;">1.</td>
                                        <td colspan="2" style="text-align: justify;">Surat Permohonan dari <?= strtoupper($ormas); ?> tanggal <?= tgl_indo($tanggal); ?>;</td>
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
                                        <td colspan="3" style="text-align: justify;"><b>Keputusan Dekan Fakultas Sains dan Teknologi tentang Penetapan Panitia Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= strtoupper($ormas); ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”.</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;"><b>Pertama</b></td>
                                        <td style="vertical-align:top;">:</td>
                                        <td colspan="3" style="text-align: justify;">Menetapkan Panitia Kegiatan <?= $namakegiatan; ?> yang dilaksanakan oleh <?= strtoupper($ormas); ?> Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang dengan tema “<?= $tema; ?>”, seperti yang tersebut dalam daftar keputusan ini.</td>
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
                                        <td colspan="3" style="text-align: justify;">Segala pembiayaan yang dikeluarkan sebagai akibat pelaksanaan Keputusan ini dibebankan kepada <br><textarea name="pembiayaan" rows="2" class="form-control" required>DIPA Universitas Islam Negeri Maulana Malik Ibrahim Malang Nomor DIPA- 025.04.2.423812/2023 Tanggal 28 November 2023.</textarea></td>
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
                            <hr>
                            <table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align:top;">Lampiran</td>
                                        <td style="vertical-align:top;">:</td>
                                        <td colspan="3" style="text-align: justify;">Surat Keputusan Dekan Fakultas Sains dan Teknologi Universitas Islam Negeri Maulana Malik Ibrahim Malang</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">Nomor</td>
                                        <td style="vertical-align:top;">:</td>
                                        <td colspan="3" style="text-align: justify;"><?= $nosurat; ?>/FST/<?= $bulanverifikasi1; ?>/<?= $tahun; ?></td>
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
                                        <td colspan="5" style="text-align: center;"><b>PENETAPAN PANITIA KEGIATAN </b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: center;"><b>KEGIATAN <?= strtoupper($namakegiatan); ?> </b></td>
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
                                        <td colspan="5" style="text-align: center;"><b>TAHUN ANGGARAN <?= $tahun; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- table panitia -->
                            <table style="width:80%; margin-left:auto;margin-right:auto;" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td style="border: 1px solid;text-align: center;"><b>No.</b></td>
                                        <td style="border: 1px solid;text-align: center;"><b>Sie Kepanitiaan</b></td>
                                        <td style="border: 1px solid;text-align: center;"><b>Nama</b></td>
                                        <td style="border: 1px solid;text-align: center;"><b>NIM</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $qpanitia = mysqli_query($dbsurat, "SELECT * FROM skpanitia WHERE token='$token'");
                                    while ($dpanitia = mysqli_fetch_array($qpanitia)) {
                                        $namapanitia = $dpanitia['nama'];
                                        $nimpanitia = $dpanitia['nim'];
                                        $siepanitia = $dpanitia['siepanitia'];
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
                                        <td width="40%">&nbsp;</td>
                                    </tr>
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
                            <hr>
                            <div class=" row">
                                <div class="col-2">
                                    <a href="index.php" class="btn btn-lg btn-block btn-secondary"><i class="fas fa-backward"></i> Kembali</a>
                                </div>
                                <div class="col">
                                    <input type="hidden" name="token" value="<?= $token; ?>">
                                    <button type="submit" formaction="skpanitia-bagumum-setujui.php" class="btn btn-lg btn-block btn-success" onclick="return confirm ('Apakah anda sudah melakukan pengecekan terhadap dokumen ini ?')"><i class="fas fa-save"></i> SIMPAN</button>
                                </div>
                                <div class="col">
                                    <button type="submit" formaction="skpanitia-bagumum-update.php" class="btn btn-lg btn-block btn-warning" onclick="return confirm('Update data ?')"><i class="fas fa-refresh"></i> Update Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </section>
        </div>
    </div>
    <?php
    require('footer.php');
    ?>

    <script src="../template/plugins/jquery/jquery.min.js"></script>
    <script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../template/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../template/plugins/jszip/jszip.min.js"></script>
    <script src="../template/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../template/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="../template/dist/js/adminlte.min.js"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

</body>

</html>
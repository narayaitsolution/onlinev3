<html>

<head>
    <link rel="stylesheet" href="../system/surat.css">
</head>

<script>
    window.print();
</script>

<!-- connect to db -->
<?php require_once('../system/dbconn.php'); ?>
<!-- ./db -->

<?php
$token = mysqli_real_escape_string($dbsurat, $_GET['token']);
$datamhs = mysqli_query($dbsurat, "SELECT * FROM ijinpenelitian WHERE token='$token'");
$row = mysqli_fetch_array($datamhs);
$nosurat = $row['no'];
$nama = $row['nama'];
$nim = $row['nim'];
$prodi = $row['prodi'];
$judulskripsi = $row['judulskripsi'];
$dosen = $row['dosen'];
$instansi = $row['instansi'];
$alamat = $row['alamat'];
$tglmulai = $row['tglmulai'];
$tglselesai = $row['tglselesai'];
$tglvalidasi3 = $row['tglvalidasi3'];
$validator3 = $row['validator3'];
$validasi3 = $row['validasi3'];
$tgl = date('Y-m-d', strtotime($tglvalidasi3));
$jam = date('His');
$keterangan = $row['keterangan'];

//data wd
$datawd = mysqli_query($dbsurat, "SELECT * FROM pejabat where nip='$validator3'");
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
$namafile = $nim . "_" . $tgl . "_" . $jam;
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
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Lampiran </td>
            <td colspan="2">: -</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Hal </td>
            <td colspan="2">: Permohonan Penelitian </td>
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
            <td colspan="3">Yth. Pimpinan <?= $instansi; ?></td>
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
            <td colspan="3">Dengan hormat,</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">Sehubungan dengan penelitian mahasiswa Jurusan <?= $prodi; ?> Fakultas Sains dan Teknologi UIN Maulana Malik Ibrahim Malang atas nama:</td>
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
            <td>Judul Penelitian</td>
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
            <td colspan="3">Maka kami mohon Bapak/Ibu berkenan memberikan izin pada mahasiswa tersebut untuk melakukan penelitian di <?= $instansi; ?> dengan waktu pelaksanaan pada tanggal <?= tgl_indo($tglmulai); ?> sampai dengan <?= tgl_indo($tglselesai); ?>.</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3">Demikian permohonan ini, atas perhatian dan kerjasamanya disampaikan terimakasih.</td>
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
            <td colspan="3">&nbsp;</td>
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
            <td style="text-align:center">Malang, <?php echo tgl_indo($tgl); ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align:center">a.n Dekan</td>
            <td>&nbsp;</td>
        </tr>
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
            if ($validasi3 == 1) {
                $sql = mysqli_query($dbsurat, "SELECT * FROM pejabat WHERE nip = '$validator3'");
                $hasil = mysqli_fetch_array($sql);
                $ttd = $hasil['ttd'];
            ?>
                <td style="text-align:center"><img src="../ttd/<?= $ttd; ?>" width="300" /></td>
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


<?php
function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tahun
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tanggal

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

</html>
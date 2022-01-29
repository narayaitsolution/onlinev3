<?php
require('dbconn.php');

function tgl_indo($tanggal)
{
    if (isset($tanggal)) {
        $bulan = array(
            1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );
        $pecahkan = explode('-', substr($tanggal, 0, 10));
        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }
}

function tgljam_indo($tanggal)
{
    if (isset($tanggal)) {
        $bulan = array(
            1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );
        $pecahkan = explode('-', substr($tanggal, 0, 10));
        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0] . ' pukul ' . (substr($tanggal, 11, 8)) . ' WIB';
    }
}

function jam($tanggal)
{
    $jam = date('H:i', strtotime($tanggal));
    return $jam;
}

function huruf($angka)
{
    $hur = array(
        0 =>   'Nol', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan'
    );
    return $hur[$angka];
}

function bulan($angka)
{
    $angka = (int)$angka;
    $bul = array(
        1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    return $bul[$angka];
}

function hari($angka)
{
    $angka = (int)$angka;
    $har = array(
        1 =>   'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
    );
    return $har[$angka];
}

function semester($tahun, $bulan)
{
    $tahunlalu = $tahun - 1;
    $tahundepan = $tahun + 1;
    if ($bulan < 7) {
        return "Genap Tahun Akademik " . $tahunlalu . "/" . $tahun;
    } else {
        return "Ganjil Tahun Akademik " . $tahun . "/" . $tahundepan;
    }
}

function nilai($nilai)
{
    if ($nilai > 85) {
        $angka = 'A';
    } elseif ($nilai > 75) {
        $angka = 'B+';
    } elseif ($nilai > 70) {
        $angka = 'B';
    } elseif ($nilai > 65) {
        $angka = 'C+';
    } elseif ($nilai > 60) {
        $angka = 'C';
    } elseif ($nilai > 50) {
        $angka = 'D';
    } else {
        $angka = 'E';
    };
    return $angka;
}

function namadosen($conn, $nip)
{
    require_once('../system/dbconn.php');
    $qdosen = mysqli_query($conn, "SELECT * FROM pengguna WHERE nip='$nip'");
    $ddosen = mysqli_fetch_array($qdosen);
    $nama = $ddosen['nama'];
    return $nama;
}

function nipdosen($conn, $iduser)
{
    require_once('../system/dbconn.php');
    $qdosen = mysqli_query($conn, "SELECT * FROM pengguna WHERE user='$iduser'");
    $ddosen = mysqli_fetch_array($qdosen);
    $nip = $ddosen['nip'];
    return $nip;
}

function multibaris($pesan)
{
    str_replace(["\r\n", "\r", "\n"], "<br/>", $pesan);
    return $pesan;
}
?>

<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
</script>

<!-- cari dosen -->
<script src="../system/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.search-box input[type="text"]').on("keyup input", function() {
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if (inputVal.length) {
                $.get("cari-proses.php", {
                    term: inputVal
                }).done(function(data) {
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else {
                resultDropdown.empty();
            }
        });
        // Set search input value on click of result item
        $(document).on("click", ".result p", function() {
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
        });
    });
</script>

<!-- disable button once it clicked -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#my-form").submit(function(e) {
            $("#btn-submit").attr("disabled", true);
            return true;
        });
    });
</script>
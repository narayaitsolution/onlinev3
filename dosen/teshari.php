<?php
require('../system/dbconn.php');
global $libur;

$tgl1 = $_POST['tgl1'];
$tgl2 = $_POST['tgl2'];
$harikerja = jmlcuti($tgl1, $tgl2, $dbsurat);

echo 'tgl1 = ' . $tgl1;
echo '<br/>';
echo 'tgl2 = ' . $tgl2;
echo '<br/>';
echo 'jml hari kerja = ' . $harikerja;
echo '<br/>';

function jmlcuti($date1, $date2, $conn)
{
    $start = strtotime($date1);
    $end   = strtotime($date2);
    // hari libur nasional
    $qlibur = mysqli_query($conn, "SELECT * FROM liburnasional");
    while ($dlibur = mysqli_fetch_array($qlibur)) {
        $libur[] = $dlibur['tanggal'];
    }

    $workdays = 0;
    for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
        $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
        $tgl = date('Y-m-d', $i);
        if ($day != 6 && $day != 0 && $day = !in_array($tgl, $libur)) {
            $workdays++;
        }
    }
    return intval($workdays);
}

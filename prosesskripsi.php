<?php
require('system/dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAINTEK e-Office</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="template/plugins/fontawesome6/css/all.css">
    <link rel="stylesheet" href="template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="template/dist/css/adminlte.min.css">

</head>

<body class="hold-transition text-sm">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 style="text-align: center;">Monitoring Proses Skripsi Mahasiswa</h1>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div id="piechart" style="width: 200%;height: 200%"></div>
            </div>
        </div>
    </section>
    <hr>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Data Proses Skripsi Mahasiswa</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered text-sm">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Program Studi</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">NIM</th>
                                <th class="text-center">Seminar Proposal</th>
                                <th class="text-center">Ujian Komprehensif</th>
                                <th class="text-center">Seminar Hasil</th>
                                <th class="text-center">Ujian Skripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $jmlsempro = 0;
                            $jmlkompre = 0;
                            $jmlsemhas = 0;
                            $jmlskripsi = 0;
                            //sempro
                            $qsempro = mysqli_query($dbsurat, "SELECT * FROM sempro ORDER BY tglujian DESC, nim ASC");
                            while ($data = mysqli_fetch_array($qsempro)) {
                                $nim = $data['nim'];
                                $nodata = $data[0];
                                $prodi = $data['prodi'];
                                $sempro = tgl_indo($data['tglujian']);
                                $jmlsempro++;

                                //kompre
                                $qkompre = mysqli_query($dbsurat, "SELECT * FROM kompre WHERE nim='$nim'");
                                $jkompre = mysqli_num_rows($qkompre);
                                if ($jkompre > 0) {
                                    $dkompre = mysqli_fetch_array($qkompre);
                                    $kompre = tgl_indo($dkompre['tglujian']);
                                    $jmlkompre++;
                                } else {
                                    $kompre = 'Belum Terjadwal';
                                }

                                //semhas
                                $qsemhas = mysqli_query($dbsurat, "SELECT * FROM semhas WHERE nim='$nim'");
                                $jsemhas = mysqli_num_rows($qsemhas);
                                if ($jsemhas > 0) {
                                    $dsemhas = mysqli_fetch_array($qsemhas);
                                    $semhas = tgl_indo($dsemhas['tglujian']);
                                    $jmlsemhas++;
                                } else {
                                    $semhas = 'Belum Terjadwal';
                                }

                                //skripsi
                                $qskripsi = mysqli_query($dbsurat, "SELECT * FROM skripsi WHERE nim='$nim'");
                                $jskripsi = mysqli_num_rows($qskripsi);
                                if ($jskripsi > 0) {
                                    $dskripsi = mysqli_fetch_array($qskripsi);
                                    $skripsi = tgl_indo($dskripsi['tglujian']);
                                    $jmlskripsi++;
                                } else {
                                    $skripsi = 'Belum Terjadwal';
                                }

                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $prodi; ?></td>
                                    <td><?= namadosen($dbsurat, $nim); ?></td>
                                    <td><?= $nim; ?></td>
                                    <td><?= $sempro; ?></td>
                                    <td><?= $kompre; ?></td>
                                    <td><?= $semhas; ?></td>
                                    <td><?= $skripsi; ?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <hr />
                    <div class="row">
                        <!-- itung prosentase -->
                        <?php
                        $totalmhs = $jmlsempro;
                        $prosentasesemhas = ceil(($jmlsemhas / $jmlsempro) * 100);
                        $prosentasekompre = ceil(($jmlkompre / $jmlsempro) * 100);
                        $prosentaseskripsi = ceil(($jmlskripsi / $jmlsempro) * 100);
                        ?>
                        <div class="col">
                            Seminar Proposal = <?= $jmlsempro; ?>
                        </div>
                        <div class="col">
                            Seminar Hasil = <?= $prosentasesemhas; ?>
                        </div>
                        <div class="col">
                            Ujian Komprehensif = <?= $prosentasekompre; ?>
                        </div>
                        <div class="col">
                            Ujian Skripsi = <?= $prosentaseskripsi; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Proses', 'Jumlah Mahasiswa'],
                ['Seminar Proposal', <?= $jmlsempro; ?>],
                ['Ujian Komprehensif', <?= $prosentasekompre; ?>],
                ['Seminar Hasil', <?= $prosentasesemhas; ?>],
                ['Ujian Skripsi', <?= $prosentaseskripsi; ?>]
            ]);

            var options = {
                title: '',
                legend: 'none'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>

    <script src="template/plugins/jquery/jquery.min.js"></script>
    <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="template/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="template/plugins/jszip/jszip.min.js"></script>
    <script src="template/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="template/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="template/dist/js/adminlte.min.js"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <?php
    function namadosen($conn, $nip)
    {
        require_once('system/dbconn.php');
        $qdosen = mysqli_query($conn, "SELECT * FROM pengguna WHERE nip='$nip'");
        $ddosen = mysqli_fetch_array($qdosen);
        $nama = $ddosen['nama'];
        return $nama;
    };
    function tgl_indo($tanggal)
    {
        if (isset($tanggal)) {
            $bulan = array(
                1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );
            $pecahkan = explode('-', substr($tanggal, 0, 10));
            return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
        }
    };
    ?>
</body>

</html>
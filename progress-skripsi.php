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
    <section class="content">
        <div class="container-fluid">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Data Progress Mahasiswa</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered text-sm">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Tahapan</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">NIM</th>
                                <th class="text-center">Tanggal Ujian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            //sempro
                            $qprestasi = mysqli_query($dbsurat, "SELECT * FROM sempro ORDER BY tglujian DESC, nim ASC");
                            while ($data = mysqli_fetch_array($qprestasi)) {
                                $nodata = $data[0];
                                $nim = $data['nim'];
                                $pembimbing1 = $data['pembimbing1'];
                                $pembimbing2 = $data['pembimbing2'];
                                $penguji1 = $data['penguji1'];
                                $penguji2 = $data['penguji2'];
                                $tglujian = $data['tglujian'];
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td>Seminar Proposal</td>
                                    <td><?= namadosen($dbsurat, $nim); ?></td>
                                    <td><?= $nim; ?></td>
                                    <td><?= tgl_indo($tglujian); ?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                            <?php
                            //kompre
                            $qprestasi = mysqli_query($dbsurat, "SELECT * FROM kompre ORDER BY tglujian DESC, nim ASC");
                            while ($data = mysqli_fetch_array($qprestasi)) {
                                $nodata = $data[0];
                                $nim = $data['nim'];
                                $pembimbing1 = $data['pembimbing1'];
                                $pembimbing2 = $data['pembimbing2'];
                                $penguji1 = $data['penguji1'];
                                $penguji2 = $data['penguji2'];
                                $tglujian = $data['tglujian'];
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td>Ujian Komprehensif</td>
                                    <td><?= namadosen($dbsurat, $nim); ?></td>
                                    <td><?= $nim; ?></td>
                                    <td><?= tgl_indo($tglujian); ?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                            <?php
                            //semhas
                            $qprestasi = mysqli_query($dbsurat, "SELECT * FROM semhas ORDER BY tglujian DESC, nim ASC");
                            while ($data = mysqli_fetch_array($qprestasi)) {
                                $nodata = $data[0];
                                $nim = $data['nim'];
                                $pembimbing1 = $data['pembimbing1'];
                                $pembimbing2 = $data['pembimbing2'];
                                $penguji1 = $data['penguji1'];
                                $penguji2 = $data['penguji2'];
                                $tglujian = $data['tglujian'];
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td>Seminar Hasil</td>
                                    <td><?= namadosen($dbsurat, $nim); ?></td>
                                    <td><?= $nim; ?></td>
                                    <td><?= tgl_indo($tglujian); ?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                            <?php
                            //skripsi
                            $qprestasi = mysqli_query($dbsurat, "SELECT * FROM skripsi ORDER BY tglujian DESC, nim ASC");
                            while ($data = mysqli_fetch_array($qprestasi)) {
                                $nodata = $data[0];
                                $nim = $data['nim'];
                                $pembimbing1 = $data['pembimbing1'];
                                $pembimbing2 = $data['pembimbing2'];
                                $penguji1 = $data['penguji1'];
                                $penguji2 = $data['penguji2'];
                                $tglujian = $data['tglujian'];
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td>Ujian Skripsi</td>
                                    <td><?= namadosen($dbsurat, $nim); ?></td>
                                    <td><?= $nim; ?></td>
                                    <td><?= tgl_indo($tglujian); ?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        </div>
    </section>

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
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
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
<?php
require('system/myfunc.php');
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
        <!-- Pengajuan Surat Mahasiswa -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Penghargaan Mahasiswa</h3>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-sm">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th style="text-align: center;">Semester</th>
                            <th style="text-align: center;">Peringkat</th>
                            <th style="text-align: center;">Tingkat</th>
                            <th style="text-align: center;">Kegiatan</th>
                            <th style="text-align: center;">Nama</th>
                            <th style="text-align: center;">NIM</th>
                            <th style="text-align: center;">Prodi</th>
                            <th style="text-align: center;">Nama Kegiatan</th>
                            <th style="text-align: center;">Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>

                        <!-- PKL Koordinator-->
                        <?php
                        $query = mysqli_query($dbsurat, "SELECT * FROM penghargaan WHERE validasi2='1' AND statussurat<'2' ORDER BY tanggal DESC, peringkat,tingkat,prodi ASC");
                        $jmldata = mysqli_num_rows($query);
                        while ($data = mysqli_fetch_array($query)) {
                            $nodata = $data['no'];
                            $tanggal = $data['tanggal'];
                            $nim = $data['nim'];
                            $nama = $data['nama'];
                            $prodi = $data['prodi'];
                            $kegiatan = $data['kegiatan'];
                            $tingkat = $data['tingkat'];
                            $peringkat = $data['peringkat'];
                            $bukti = $data['bukti'];
                            $namakegiatan = $data['namakegiatan'];
                            $token = $data['token'];
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= semester(date('Y', strtotime($tanggal)), date('m', strtotime($tanggal))); ?></td>
                                <td><?= $peringkat; ?></td>
                                <td><?= $tingkat; ?></td>
                                <td><?= $kegiatan; ?></td>
                                <td><?= $nama; ?></td>
                                <td><?= $nim; ?></td>
                                <td><?= $prodi; ?></td>
                                <td><?= $namakegiatan; ?></td>
                                <td><a href="<?= $bukti; ?>" class="btn btn-sm btn-primary" target="_blank">Lihat</a></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <a href="https://saintek.uin-malang.ac.id" class="btn btn-primary btn-lg btn-block"><i class="fa-solid fa-backward-fast"></i> Kembali</a>
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
                "buttons": ["excel", "pdf", "print", "colvis"]
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
</body>

</html>
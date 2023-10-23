<?php
require('../system/dbconn.php');
require('../system/myfunc.php');

$no = 1;
$query = mysqli_query($dbsurat, "SELECT * FROM pkl WHERE statussurat='1' and year(tanggal)='2023' ORDER BY tanggal DESC");
$jmldata = mysqli_num_rows($query);
echo $jmldata . '<br>';
while ($data = mysqli_fetch_array($query)) {
  $nodata = $data['no'];
  $tanggal = $data['tanggal'];
  $nim = $data['nim'];
  $nama = $data['nama'];
  $prodi = $data['prodi'];
  $instansi = $data['instansi'];
  $tempatpkl = $data['tempatpkl'];
  $alamat = $data['alamat'];
  $validasi1 = $data['validasi1'];
  $validator1 = $data['validator1'];
  $validasi2 = $data['validasi2'];
  $validator2 = $data['validator2'];
  $validasi3 = $data['validasi3'];
  $validator3 = $data['validator3'];
  $tglvalidasi3 = $data['tglvalidasi3'];
  $keterangan = $data['keterangan'];
  $token = $data['token'];
  $statussurat = $data['statussurat'];
  echo $no . ' ' . $nim . ' ' . $tglvalidasi3 . ' ' . $keterangan . '<br/>';
  $no++;
}

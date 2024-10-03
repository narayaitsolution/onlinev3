<?php
session_start();
require('../system/dbconn.php');
require('../system/phpmailer/sendmail.php');
$nip = $_SESSION['nip'];
$nim = $_POST['nim'];
$namamhs = $_POST['nama'];
$prodi = $_POST['prodi'];
$kemampuankerja = $_POST['kemampuankerja'];
$penguasaanpengetahuan = $_POST['penguasaanpengetahuan'];
$SikapKhusus = $_POST['SikapKhusus'];

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:i:s');

//cari nip kajur
$kdjabatan = 'kaprodi';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE prodi=? AND kdjabatan=?");
$stmt->bind_param("ss", $prodi, $kdjabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipkaprodi = $dhasil['nip'];

//cari nip wd-1
$jabatan = 'wadek1';
$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
$stmt->bind_param("s", $jabatan);
$stmt->execute();
$result = $stmt->get_result();
$dhasil = $result->fetch_assoc();
$nipwd1 = $dhasil['nip'];

foreach ($kemampuankerja as $kerja) {
    $qcpl = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE no='$kerja' ");
    $data = mysqli_fetch_array($qcpl);
    $cpl = $data[2];
    $indonesia = $data[3];
    $english = $data[4];
    $status = 1;
    $stmt = $dbsurat->prepare("INSERT INTO skpi (nim,nama,jurusan,cpl,indonesia,english,verifikasi1,verifikator1,tglverifikasi1,verifikator2,verifikator3)
                                VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssss", $nim, $nama, $prodi, $cpl, $indonesia, $english, $status, $nip, $tgl, $nipkaprodi, $nipwd1);
    $stmt->execute();
}

foreach ($penguasaanpengetahuan as $pengetahuan) {
    $qcpl2 = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE no='" . $pengetahuan . "' ");
    $data2 = mysqli_fetch_array($qcpl2);
    $cpl = $data2[2];
    $indonesia = $data2[3];
    $english = $data2[4];
    $status = 1;
    $stmt = $dbsurat->prepare("INSERT INTO skpi (nim,nama,jurusan,cpl,indonesia,english,verifikasi1,verifikator1,tglverifikasi1,verifikator2,verifikator3)
                                VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssss", $nim, $nama, $prodi, $cpl, $indonesia, $english, $status, $nip, $tgl, $nipkaprodi, $nipwd1);
    $stmt->execute();
}

foreach ($SikapKhusus as $khusus) {
    $qcpl3 = mysqli_query($dbsurat, "SELECT * FROM skpi_cpl WHERE no='" . $khusus . "' ");
    $data3 = mysqli_fetch_array($qcpl3);
    $cpl = $data3[2];
    $indonesia = $data3[3];
    $english = $data3[4];
    $status = 1;
    $stmt = $dbsurat->prepare("INSERT INTO skpi (nim,nama,jurusan,cpl,indonesia,english,verifikasi1,verifikator1,tglverifikasi1,verifikator2,verifikator3)
                                VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssss", $nim, $nama, $prodi, $cpl, $indonesia, $english, $status, $nip, $tgl, $nipkaprodi, $nipwd1);
    $stmt->execute();
}

//setujui sertifikat
$qsimpan5 = mysqli_query($dbsurat, "UPDATE skpi_prestasipenghargaan 
										SET verifikasi1=1,
											tglverifikasi1='$tgl'
										WHERE nim='$nim'");

//kirim email ke kajur
//cari email kajur dari NIP
$sql2 = mysqli_query($dbsurat, "SELECT * FROM skpi_prestasipenghargaan WHERE nim='$nim'");
$dsql2 = mysqli_fetch_array($sql2);
$nama = $dsql2['nama'];
$nipkajur = $dsql2['verifikator2'];
$sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipkajur'");
$dsql3 = mysqli_fetch_array($sql3);
$namakajur = $dsql3['nama'];
$emailkajur = $dsql3['email'];

//kirim email
$surat = 'Keterangan Pendamping Ijazah';
$subject = "Pengajuan Surat " . $surat;
$pesan = "Yth. " . $namakajur . "<br/>
        <br/>
		Assalamualaikum wr. wb.
        <br />
		<br />
		Dengan hormat,
		<br />
        Terdapat pengajuan surat " . $surat . " atas nama " . $namamhs . " di sistem SAINTEK e-Office.<br/>
        Silahkan klik tombol dibawah ini untuk melakukan verifikasi surat di website SAINTEK e-Office<br/>
        <br/>
        <a href='https://eoffice.saintek.uin-malang.ac.id/' style=' background-color: #0045CE;border: none;color: white;padding: 8px 16px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;'>SAINTEK e-Office</a><br/>
        <br/>
        atau klik URL berikut ini <a href='https://eoffice.saintek.uin-malang.ac.id/'>https://eoffice.saintek.uin-malang.ac.id/</a> apabila tombol diatas tidak berfungsi.<br/>
        <br/>
        Wassalamualaikum wr. wb.
		<br/>
        <br/>
        <b>SAINTEK e-Office</b>";
sendmail($emailkajur, $namakajur, $subject, $pesan);

header("location:index.php?hasil=ok&pesan=Berhasil menyetujui pengajuan SKPI");

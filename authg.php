<?php
require('system/dbconn.php');
require('system/myfunc.php');
require('system/phpmailer/sendmail.php');

// Include file gpconfig
include 'gpconfig.php';

if (isset($_GET['code'])) {
	$gclient->authenticate($_GET['code']);
	$_SESSION['token'] = $gclient->getAccessToken();
	header('Location: ' . filter_var($redirect_url, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gclient->setAccessToken($_SESSION['token']);
}

if ($gclient->getAccessToken()) {

	include 'system/dbconn.php';

	// Get user profile data from google
	$gpuserprofile = $google_oauthv2->userinfo->get();

	$gnama = $gpuserprofile['given_name'] . " " . $gpuserprofile['family_name']; // Ambil nama dari Akun Google
	$gemail = $gpuserprofile['email']; // Ambil email Akun Google nya
	$pecahemail = explode('@', $gemail);
	$nip = $pecahemail[0];

	//cek apakah menggunakan email UIN, jika bukan out!!
	//$cekdomain = substr($pecahemail[1], -16);
	//if ($cekdomain == 'uin-malang.ac.id') {

	// Buat query untuk mengecek apakah data user dengan email tersebut sudah ada atau belum
	// Jika ada, ambil id, username, dan nama dari user tersebut

	$qpengguna = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE email='$gemail' OR nip='$nip'");
	$jpengguna = mysqli_num_rows($qpengguna);
	//jika data pengguna di temukan, langsung login ke dashboard
	if ($jpengguna > 0) {
		$dpengguna = mysqli_fetch_array($qpengguna);

		//ambil data pengguna
		$nama = $dpengguna['nama'];
		$nip = $dpengguna['nip'];
		$nohp = $dpengguna['nohp'];
		$email = $dpengguna['email'];
		$prodi = $dpengguna['prodi'];
		$hakakses = $dpengguna['hakakses'];

		//cari jabatan
		$stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE nip=?");
		$stmt->bind_param("s", $nip);
		$stmt->execute();
		$result = $stmt->get_result();
		$jhasil = $result->num_rows;
		if ($jhasil > 0) {
			$dhasil = $result->fetch_array();
			$jabatan = $dhasil['kdjabatan'];
		} else {
			$jabatan = $hakakses;
		};

		$_SESSION['user'] = $gnama;
		$_SESSION['nama'] = $nama;
		$_SESSION['nip'] = $nip;
		$_SESSION['prodi'] = $prodi;
		$_SESSION['hakakses'] = $hakakses;
		$_SESSION['jabatan'] = $jabatan;

		if ($hakakses == 'dosen') {
			header('location:dosen/index.php');
		} elseif ($hakakses == 'tendik') {
			header('location:staf/index.php');
		} elseif ($hakakses == 'subsatker') {
			header('location:subsatker/index.php');
		} else {
			header('location:mahasiswa/index.php');
		}
	} else {
		//jika data pengguna tidak ditemukan, insert data dan lempar ke profile user

		$hakakses = 'mahasiswa';
		$aktif = 1;
		$nama = $gnama;
		$nip = $pecahemail[0];
		$email = $gemail;
		$prodi = cariprodi($dbsurat, $nip);
		if (empty($prodi)) {
			header('location:index.php?pesan=Mohon Maaf, Sistem ini hanya untuk Mahasiswa & Dosen SAINTEK!!');
		}
		$fakultas = 'Sains dan Teknologi';
		$username = $nip;
		$passmd5 = md5('oauth');
		$token = md5(uniqid());

		$stmt = $dbsurat->prepare("INSERT INTO pengguna (nama, nip, nohp, email, prodi, fakultas, user, pass,hakakses,token,aktif) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param("sssssssssss", $nama, $nip, $nohp, $email, $prodi, $fakultas, $username, $passmd5, $hakakses, $token, $aktif);
		$stmt->execute();

		//kirim email admin
		$namaadmin = 'Admin SAINTEK e-Office';
		$emailadmin = 'saintekonline@gmail.com';
		$subject = "Pendaftaran Akun SAINTEK e-Office Baru";
		$pesan = "Yth. " . $namaadmin . "<br/>
			 <br/>
			 Assalamualaikum wr. wb.<br />
			 <br />
			 Terdapat pendaftaran akun baru di sistem SAINTEK e-Office atas nama <b>" . $nama . " dari Prodi " . $prodi . " melalui Google OAuth</b>.<br/>
			 <br/>        
			 Wassalamualaikum wr. wb.
			 <br/>
			 <br/>
			 <b>SAINTEK e-Office</b>";
		sendmail($emailadmin, $namaadmin, $subject, $pesan);

		$_SESSION['user'] = $username;
		$_SESSION['nama'] = $nama;
		$_SESSION['nip'] = $nip;
		$_SESSION['prodi'] = $prodi;
		$_SESSION['hakakses'] = $hakakses;
		$_SESSION['jabatan'] = $hakakses;

		header('location:mahasiswa/index.php');
	}
	//} else {
	//	header('location: index.php?pesan=harus menggunakan email UIN Malang');
	//}
} else {
	$authUrl = $gclient->createAuthUrl();
	header("location: " . $authUrl);
}

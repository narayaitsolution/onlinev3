<?php
// Include file gpconfig
include_once 'gpconfig.php';

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

	// Buat query untuk mengecek apakah data user dengan email tersebut sudah ada atau belum
	// Jika ada, ambil id, username, dan nama dari user tersebut

	$qpengguna = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE email='$gemail'");
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
		header("location:daftar.php?nama=$gnama&email=$gemail");
	}
} else {
	$authUrl = $gclient->createAuthUrl();
	header("location: " . $authUrl);
}

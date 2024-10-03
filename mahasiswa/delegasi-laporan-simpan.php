<?php
session_start();
require_once('../system/dbconn.php');
require_once('../system/myfunc.php');
require_once('../system/phpmailer/sendmail.php');

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');

$token = $_POST['token'];
$noktp = $_POST['noktp'];
$norek = $_POST['norek'];
$bank = $_POST['bank'];
$nimketua = $_SESSION['nip'];

$statuslaporan = 0;

$target_dir = "../lampiran/";
$allowedfileExtensions = array('jpg', 'jpeg', 'pdf');

// Function to check and upload file
function checkAndUploadFile($file, $allowedExtensions, $maxSize, $targetDir, $newFileName)
{
    $tmpPath = $file['tmp_name'];
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileParts = explode(".", $fileName);
    $fileExtension = strtolower(end($fileParts));

    if ($fileSize > $maxSize) {
        return array('status' => false, 'message' => "Ukuran file maksimal " . ($maxSize / 1048576) . "MB!!");
    }

    if (!in_array($fileExtension, $allowedExtensions)) {
        return array('status' => false, 'message' => "Format file tidak sesuai!!");
    }

    $filePath = $targetDir . $newFileName . '.' . $fileExtension;
    if (move_uploaded_file($tmpPath, $filePath)) {
        $info = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filePath);
        $expectedMimeType = ($fileExtension == 'pdf') ? 'application/pdf' : 'image/jpeg';
        if ($info == $expectedMimeType) {
            return array('status' => true, 'path' => $filePath);
        } else {
            unlink($filePath);
            return array('status' => false, 'message' => "File tidak valid!");
        }
    }

    return array('status' => false, 'message' => "Gagal mengupload file!");
}

// Check and upload each file
$fileChecks = array(
    'laporan' => array('extensions' => array('pdf'), 'maxSize' => 5242880, 'newFileName' => random_str(12)),
    'ktp' => array('extensions' => array('jpg', 'jpeg'), 'maxSize' => 1048576, 'newFileName' => random_str(12)),
    'ktm' => array('extensions' => array('jpg', 'jpeg'), 'maxSize' => 1048576, 'newFileName' => random_str(12)),
    'butab' => array('extensions' => array('jpg', 'jpeg'), 'maxSize' => 1048576, 'newFileName' => random_str(12))
);

$uploadResults = array();
$allFilesValid = true;

foreach ($fileChecks as $fileType => $fileParams) {
    $result = checkAndUploadFile($_FILES[$fileType], $fileParams['extensions'], $fileParams['maxSize'], $target_dir, $fileParams['newFileName']);
    $uploadResults[$fileType] = $result;
    if (!$result['status']) {
        $allFilesValid = false;
        header("location:delegasi-laporan-isi.php?hasil=notok&token=$token&pesan=" . urlencode($result['message']));
        exit;
    }
}

// If all files are valid, proceed with database operations
if ($allFilesValid) {
    // Update tabel delegasi
    $stmt = $dbsurat->prepare("UPDATE delegasi 
                                SET laporan=?, tgllaporan=?, statuslaporan=?
                                WHERE token=?");
    $stmt->bind_param("ssss", $uploadResults['laporan']['path'], $tanggal, $statuslaporan, $token);
    $stmt->execute();

    // Insert data tabel delegasiupload
    $stmt = $dbsurat->prepare("INSERT INTO delegasiupload (tanggal, token, nimketua, laporan, noktp, fotoktp, fotoktm, norek, bank, butab) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssss",
        $tanggal,
        $token,
        $nimketua,
        $uploadResults['laporan']['path'],
        $noktp,
        $uploadResults['ktp']['path'],
        $uploadResults['ktm']['path'],
        $norek,
        $bank,
        $uploadResults['butab']['path']
    );
    $stmt->execute();

    // Cari nip wd-3
    $jabatan = 'wadek3';
    $stmt = $dbsurat->prepare("SELECT * FROM pejabat WHERE kdjabatan=?");
    $stmt->bind_param("s", $jabatan);
    $stmt->execute();
    $result = $stmt->get_result();
    $dhasil = $result->fetch_assoc();
    $nipwd = $dhasil['nip'];

    // Kirim email ke koordinator
    $sql3 = mysqli_query($dbsurat, "SELECT * FROM pengguna WHERE nip='$nipwd'");
    $dsql3 = mysqli_fetch_array($sql3);
    $namakoor = $dsql3['nama'];
    $emailkoor = $dsql3['email'];

    // Kirim email
    $jenissurat = "Laporan Kegiatan Delegasi";
    $subject = "Pengajuan " . $jenissurat;
    $pesan = "Yth. " . $namakoor . "<br/>
              <br/>
              Assalamualaikum wr. wb.
              <br />
              <br />
              Dengan hormat,
              <br />
              Terdapat pengajuan " . $jenissurat . " di sistem SAINTEK e-Office.<br/>
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
    sendmail($emailkoor, $namakoor, $subject, $pesan);

    header("location:index.php?hasil=ok&pesan=Upload laporan berhasil");
}

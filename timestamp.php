<?php
require('system/dbconn.php');

$nip = '09650073';
$token = md5(microtime());
$qupdate = mysqli_query($dbsurat, "UPDATE pengguna SET token='$token' WHERE nip='$nip'");
echo 'done <br/>';

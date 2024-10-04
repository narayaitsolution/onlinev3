<?php
session_start();
session_unset();
session_destroy();
//setcookie("usertoken", "", time() - 60, "/");
?>
<!DOCTYPE html>
<html>

<body>

    <?php
    header('location:index.php?hasil=ok&pesan=Anda telah keluar dari SAINTEK e-Office');
    ?>

</body>

</html>
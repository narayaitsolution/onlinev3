<?php
//manajemen skripsi fisika
$dbfis = mysqli_connect("10.10.7.109", "manajemenskripsi", "Cg6_vg25", "fisika_manajemenskripsi");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo "Connected to db manajemenskripsi fisika";
}

//skripsi perpustakaan dan ilmu informasi
$dbpii = mysqli_connect("10.10.7.109", "skripsi", "gtZx169_2", "skripsi");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo "Connected to db skripsi pii";
}

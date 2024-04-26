<?php
//$dbsurat = mysqli_connect("narayaitsolution.web.id", "narayait_online", "N-bf2lXrt()6", "narayait_online");
$dbsurat = mysqli_connect("localhost", "saintek_online", "N-bf2lXrt()6", "saintek_online");
// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
	//echo "Connected to db";
}

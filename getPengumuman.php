<?php
header('Content-Type: application/json');
include 'config.php';

$res = mysqli_query($con, "SELECT setting_value as json from demil_settings where setting_key = 'infographic_pengumuman'") or die(mysqli_error($con));

$pengumuman = (object)mysqli_fetch_assoc($res);
if($pengumuman->json != ''){
	echo $pengumuman->json;
}else{
	echo "[]";
}
?>
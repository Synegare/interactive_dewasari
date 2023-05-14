<?php
$arr = array();
$pikocis = file_get_contents('http://pikcovid19.ciamiskab.go.id/statistik');
header('Content-Type: application/json');

// Get Confirmed
$get_confirmed = explode('TOTAL TERKONFIRMASI', $pikocis);
if(isset($get_confirmed[1]) && $get_confirmed[1] != ''){
	$get_confirmed = explode('SEMBUH', $get_confirmed[1]);
	if(isset($get_confirmed[0]) && $get_confirmed[0] != ''){
		$confirmed_count = preg_replace("/[^0-9]/", "", strip_tags($get_confirmed[0]));
	}else{
		$confirmed_count = 'N/A';
	}
	
	$arr['confirmed_count'] = $confirmed_count;

	
}else{
	$arr['confirmed_count'] = 'N/A';
}

// Get Recovered Count
$get_recovered = explode('<h6 class="font-weight-bold">SEMBUH</h6>', $pikocis);
if(isset($get_recovered[1]) && $get_recovered[1] != ''){
	$get_recovered = explode('POSITIF AKTIF', $get_recovered[1]);

	if(isset($get_recovered[0]) && $get_recovered[0] != ''){
		$recovered_count = preg_replace("/[^0-9]/", "", strip_tags($get_recovered[0]));
	}else{
		$recovered_count = 'N/A';
	}

	$arr['recovered_count'] = $recovered_count;

}else{
	$arr['recovered_count'] = 'N/A';
}

// Get Active
$get_active = explode('<h6 class="font-weight-bold">POSITIF AKTIF</h6>', $pikocis);
if(isset($get_active[1]) && $get_active[1] != ''){
	$get_active = explode('<h5 class="font-weight-bold" style="color: #CEB546;">', $get_active[1]);

	if(isset($get_active[0]) && $get_active[0] != ''){
		$active_count = preg_replace("/[^0-9]/", "", strip_tags($get_active[0]));
	}else{
		$active_count = 'N/A';
	}

	$arr['active_count'] = $active_count;

}else{
	$arr['active_count'] = 'N/A';
}

// Get Death
$get_death = explode('<h6 class="font-weight-bold">MENINGGAL DUNIA</h6>', $pikocis);
if(isset($get_death[1]) && $get_death[1] != ''){
	$get_death = explode('</h2>', $get_death[1]);

	if(isset($get_death[0]) && $get_death[0] != ''){
		$death_count = preg_replace("/[^0-9]/", "", strip_tags($get_death[0]));
	}else{
		$death_count = 'N/A';
	}

	$arr['death_count'] = $death_count;

}else{
	$arr['death_count'] = 'N/A';
}

// Get Suspect
$get_suspect = explode('TOTAL SUSPEK', $pikocis);
if(isset($get_suspect[1]) && $get_suspect[1] != ''){
	$get_suspect = explode('</h1>', $get_suspect[1]);

	if(isset($get_suspect[0]) && $get_suspect[0] != ''){
		$suspect_count = preg_replace("/[^0-9]/", "", strip_tags($get_suspect[0]));
	}else{
		$suspect_count = 'N/A';
	}

	$arr['suspect_count'] = $suspect_count;

}else{
	$arr['suspect_count'] = 'N/A';
}

echo json_encode($arr, JSON_FORCE_OBJECT);
?>
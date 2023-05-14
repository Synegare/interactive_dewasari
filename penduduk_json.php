<?php
include('config.php');
$arr = array();
header('Content-Type: application/json');

// Get Jumlah KK
$get_kk = mysqli_query($con, "SELECT COUNT(DISTINCT penduduk_no_kk) as jumlah_kk FROM `demil_penduduk`") or die(mysqli_error($con));
$kk = mysqli_fetch_assoc($get_kk);

if($kk['jumlah_kk'] != ''){
	$arr['jumlah_kk'] = $kk['jumlah_kk'];
}

// Get Jumlah Penduduk
$get_penduduk = mysqli_query($con, "SELECT COUNT(DISTINCT penduduk_nik) as jumlah_penduduk FROM `demil_penduduk`") or die(mysqli_error($con));
$penduduk = mysqli_fetch_assoc($get_penduduk);

if($penduduk['jumlah_penduduk'] != ''){
	$arr['jumlah_penduduk'] = $penduduk['jumlah_penduduk'];
}

// Get Jumlah Penduduk Laki-laki
$get_penduduk_male = mysqli_query($con, "SELECT COUNT(penduduk_gender) as jumlah_penduduk_male FROM `demil_penduduk` where penduduk_gender = 'LAKI-LAKI'") or die(mysqli_error($con));
$penduduk_male = mysqli_fetch_assoc($get_penduduk_male);

if($penduduk_male['jumlah_penduduk_male'] != ''){
	$arr['jumlah_penduduk_male'] = $penduduk_male['jumlah_penduduk_male'];
}

// Get Jumlah Penduduk Perempuan
$get_penduduk_female = mysqli_query($con, "SELECT COUNT(penduduk_gender) as jumlah_penduduk_female FROM `demil_penduduk` where penduduk_gender = 'PEREMPUAN'") or die(mysqli_error($con));
$penduduk_female = mysqli_fetch_assoc($get_penduduk_female);

if($penduduk_female['jumlah_penduduk_female'] != ''){
	$arr['jumlah_penduduk_female'] = $penduduk_female['jumlah_penduduk_female'];
}

// Get Jumlah Penduduk Tidak / Belum Sekolah

$get_penduduk_tidak_belum_sekolah = mysqli_query($con, "SELECT COUNT(penduduk_pendidikan) as pendidikan_tidak_belum_sekolah FROM `demil_penduduk` where (penduduk_pendidikan = 'Tidak tamat SD/sederajat' OR penduduk_pendidikan = 'Tidak pernah sekolah' OR penduduk_pendidikan = 'Tidak/Belum Sekolah') ") or die(mysqli_error($con));
$penduduk_tidak_belum_sekolah = mysqli_fetch_assoc($get_penduduk_tidak_belum_sekolah);

if($penduduk_tidak_belum_sekolah['pendidikan_tidak_belum_sekolah'] != ''){
	$arr['pendidikan_tidak_belum_sekolah'] = $penduduk_tidak_belum_sekolah['pendidikan_tidak_belum_sekolah'];
}

// Get Jumlah Penduduk SD / Tidak Tamat SD / Tidak Sekolah
$get_penduduk_sd_sederajat = mysqli_query($con, "SELECT COUNT(penduduk_pendidikan) as pendidikan_sd_sederajat FROM `demil_penduduk` where penduduk_pendidikan = 'Tamat SD/sederajat' OR penduduk_pendidikan = 'Belum Tamat SD/Sederajat'") or die(mysqli_error($con));
$penduduk_sd_sederajat = mysqli_fetch_assoc($get_penduduk_sd_sederajat);

if($penduduk_sd_sederajat['pendidikan_sd_sederajat'] != ''){
	$arr['pendidikan_sd_sederajat'] = $penduduk_sd_sederajat['pendidikan_sd_sederajat'];
}

// Get Jumlah Penduduk SMP / Sederajat
$get_penduduk_smp_sederajat = mysqli_query($con, "SELECT COUNT(penduduk_pendidikan) as pendidikan_smp_sederajat FROM `demil_penduduk` where penduduk_pendidikan = 'Tamat SLTP/sederajat' OR penduduk_pendidikan = 'SLTP/sederajat' ") or die(mysqli_error($con));
$penduduk_smp_sederajat = mysqli_fetch_assoc($get_penduduk_smp_sederajat);

if($penduduk_smp_sederajat['pendidikan_smp_sederajat'] != ''){
	$arr['pendidikan_smp_sederajat'] = $penduduk_smp_sederajat['pendidikan_smp_sederajat'];
}

// Get Jumlah Penduduk SMA / Sederajat
$get_penduduk_sma_sederajat = mysqli_query($con, "SELECT COUNT(penduduk_pendidikan) as pendidikan_sma_sederajat FROM `demil_penduduk` where penduduk_pendidikan = 'Tamat SLTA/sederajat' OR penduduk_pendidikan = 'SLTA/sederajat' ") or die(mysqli_error($con));
$penduduk_sma_sederajat = mysqli_fetch_assoc($get_penduduk_sma_sederajat);

if($penduduk_sma_sederajat['pendidikan_sma_sederajat'] != ''){
	$arr['pendidikan_sma_sederajat'] = $penduduk_sma_sederajat['pendidikan_sma_sederajat'];
}

// Get Jumlah Penduduk D1 / D1 / D3 / D4
$get_penduduk_diploma = mysqli_query($con, "SELECT COUNT(penduduk_pendidikan) as pendidikan_diploma FROM `demil_penduduk` where (penduduk_pendidikan = 'Tamat D-2/sederajat' OR penduduk_pendidikan = 'Tamat D-4/sederajat' OR penduduk_pendidikan = 'Akademi/Diploma III/S. Muda' OR penduduk_pendidikan = 'Diploma I/II')") or die(mysqli_error($con));
$penduduk_diploma = mysqli_fetch_assoc($get_penduduk_diploma);

if($penduduk_diploma['pendidikan_diploma'] != ''){
	$arr['pendidikan_diploma'] = $penduduk_diploma['pendidikan_diploma'];
}

// Get Jumlah Penduduk S1 / S2
$get_penduduk_sarjana = mysqli_query($con, "SELECT COUNT(penduduk_pendidikan) as pendidikan_sarjana FROM `demil_penduduk` where (penduduk_pendidikan = 'Tamat S-1/sederajat' OR penduduk_pendidikan = 'Tamat S-2/sederajat' OR penduduk_pendidikan = 'Diploma IV/Strata I' OR penduduk_pendidikan = 'Strata II')") or die(mysqli_error($con));
$penduduk_sarjana = mysqli_fetch_assoc($get_penduduk_sarjana);

if($penduduk_sarjana['pendidikan_sarjana'] != ''){
	$arr['pendidikan_sarjana'] = $penduduk_sarjana['pendidikan_sarjana'];
}

echo json_encode($arr, JSON_FORCE_OBJECT);

?>
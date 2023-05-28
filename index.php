<?php
require('config.php');
// if($_SERVER['HTTPS'] != 'on'){
//   header('HTTP/1.1 301 Moved Permanently');
//   header('Location: '.$home_url.'interactive/');
//   exit;
// }


// Get Settings
$getSettings = mysqli_query($con, "SELECT * FROM demil_settings") or die(mysqli_error($con));
$setting = array();
while($set = mysqli_fetch_assoc($getSettings)){
    $setting[$set['setting_key']] = $set['setting_value'];
}

$setting = (object)$setting;

// Get Profile
$getProfile = mysqli_query($con, "SELECT * FROM demil_profile") or die(mysqli_error($con));
$profile = array();
while($pro = mysqli_fetch_assoc($getProfile)){
    $profile[$pro['profile_key']] = $pro['profile_value'];
}

$profile = (object)$profile;

?>
<!DOCTYPE html>
<html lang="id-ID">
<head>
    <meta charset="utf-8" />
    <title>Dewasari - Demil Infographic Board</title>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Demil.id" name="generator" />
    <link href="assets/css/infographic.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/css/interactive.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
    <script type="text/javascript">
        WebFont.load({ google: { families: ["Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic", "Sen:regular,700,800", "Raleway:300,regular,500,600,700,800,900"] } });
    </script>
    <script type="text/javascript" src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=60fe9c591692c667fe76ba7e"></script>
    <script type="text/javascript" src="marquee.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/percircle@1.0.25/dist/js/percircle.js"></script>

    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif]-->
</head>
<body>
    <div class="demilinteractive_main_box">
        <div class="demilinteractive_header">
            <div class="demilinteractive_footer_left"><img src="assets/images/logo-full-white.png" loading="lazy" alt="" class="main-logo" /></div>
            <div class="demilinteractive_footer_lright">
                <div class="main-title-box">
                    <img src="assets/images/stats-graphic-zig-zag-line.svg" loading="lazy" alt="" class="main-title-icon" />
                    <h1 class="main-title">Infographic Board<strong class="xtrbold"></strong></h1>
                </div>
                <div class="clock-wather">
                    <div class="clock">
                        <h2 class="clock-time"><span class="jam"></span><span class="menit"></span></h2>
                        <div class="clock-date"><span class="hari"></span><span class="tanggal"></span></div>
                    </div>

                    <script type="text/javascript">
                    jQuery(document).ready(function(){
                        
                        // Clock System
                        setInterval(updateClock, 1000);


                        function updateClock(){
                            let today = new Date();
                            if(today.getHours() == 0){
                                jQuery('.jam').html('00');
                            }else{
                                jQuery(".jam").html(String(today.getHours()).padStart(2, '0'));
                            }

                            if(today.getMinutes() == 0){
                                jQuery('.menit').html(':00');
                            }else{
                                jQuery(".menit").html(':'+String(today.getMinutes()).padStart(2, '0'));
                            }
                            
                            let daftar_hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            let daftar_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                            jQuery(".hari").html(daftar_hari[today.getDay()]);
                            jQuery(".tanggal").html(', '+today.getDate()+' '+daftar_bulan[today.getMonth()]+' '+today.getFullYear());
                            return false;
                        }

                        // Weather System
                        function checkWeather(){
                            console.log('Weather Checked');
                            jQuery.ajax({
                                type: "GET",
                                url: 'https://api.openweathermap.org/data/2.5/weather?q=Dewasari&APPID=dc36197b8e5e87efcdd5e288fe8f1406',
                                cache: false,
                                success: function(w) {
                                    jQuery(".loader-weather").hide();
                                    jQuery(".weather-content").fadeIn();
                                    jQuery(".weather-content").css('display', 'flex');
                                    
                                    // Update weather
                                    let w_icon = w.weather[0].icon;
                                    if(w_icon == '01d'){
                                        jQuery(".weather-icon-p").html('<img src="assets/images/sun.svg" loading="lazy" alt="" class="weather-icon" />');
                                    }else{
                                        if(w_icon == '01n'){
                                            jQuery(".weather-icon-p").html('<img src="assets/images/moon.svg" loading="lazy" alt="" class="weather-icon" />');
                                        }else{
                                            jQuery(".weather-icon-p").html('<img src="https://openweathermap.org/img/wn/'+w_icon+'@2x.png" loading="lazy" alt="" class="weather-icon" />');
                                        }
                                    }
                                    
                                    jQuery(".weather-temp").html(k_to_c(w.main.temp)+'°C');
                                    jQuery(".placeName").html(w.name);

                                }
                            }); 
                        }
                        checkWeather();
                        setInterval(checkWeather, 60000); // Check every 60 seconds

                        function k_to_c(temp) {
                            return Math.round(Number(temp - 273.15));
                        }
                    });
                    </script>
                    <div class="weather">
                        <div class="loader-weather"><img src="assets/images/loader-interactive-1.svg" alt="Memuat.."></div>
                        <div class="weather-content">
                        <div class="weather-icon-p"></div>
                        <div class="weather-detail">
                            <div class="weather-temp"></div>
                            <div class="clock-date placeName"></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="demilinteractive_main_content">
            <div class="demilinteractive_main_content_box">
                <div class="demilinteractive_main_content_box_left">
                    <div class="demilinteractive_rows">
                        <div class="big-card" style="padding:0px;border-radius:10px 15px 15px 10px;overflow:hidden;">
                            <video
                            id="mainVideo"
                            class="video-js"
                            style="border-radius:10px;"
                            poster="assets/images/thumb_holder.png"
                          >
                            <source src="" class="mainVideoSource" type="video/mp4" />
                            <p class="vjs-no-js">
                              Tolong aktifkan JavaScript untuk dapat memutar video.
                            </p>
                          </video>
                          <span style="display:none" class="listPengumuman">video1.mp4|video2.mp4|video3.mp4|video4.mp4|video5.mp4</span>
                          <span style="display:none" class="playedPengumumanIndex">1</span>
                          <script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
                          <script type="text/javascript">
                          jQuery(document).ready(function(){
                            var listPengumuman = jQuery(".listPengumuman").text().split('|');
                                 jQuery(".mainVideoSource").attr('src', listPengumuman[0]);
                                 jQuery(".playedPengumumanIndex").html('1');

                                videoPengumuman = videojs('mainVideo', {
                                    controls:false,
                                    autoplay:true,
                                    height: '250',
                                    loop: false
                                  });

                                videoPengumuman.on('ended', () => {
                                    let currentPlayedIndex = jQuery(".playedPengumumanIndex").text();
                                    let nextIndexToPlay = Number(currentPlayedIndex)+1;
                                    if(nextIndexToPlay > listPengumuman.length){
                                        console.log('kembali ke awal');
                                        jQuery(".playedPengumumanIndex").html(0);
                                        videoPengumuman.src({ type: 'video/mp4', src: listPengumuman[0] });
                                    }else{
                                        jQuery(".playedPengumumanIndex").html(nextIndexToPlay);
                                        videoPengumuman.src({ type: 'video/mp4', src: listPengumuman[currentPlayedIndex] });
                                        
                                    }
                                    
                                    videoPengumuman.load();
                                    videoPengumuman.play();
                                    

                                     // var id_next_video = Number(index)+1;
                                     //    if(id_next_video <= listPengumuman.length){
                                     //        playPengumuman(listPengumuman[id_next_video-1], id_next_video);
                                     //        videoPengumuman.initChildren();
                                     //    }
                                });

                                // playPengumuman();
                          });

                          function playPengumuman(vid, index){
                            console.log(jQuery(".mainVideoSource").attr('src'));

                            var listPengumuman = jQuery(".listPengumuman").text().split('|');

                            if(vid == undefined && index == undefined){
                                jQuery(".mainVideoSource").attr('src', listPengumuman[0]);
                                index = 1;
                            }else{
                                jQuery(".mainVideoSource").attr('src', vid);
                            }

                            /*
                            videoPengumuman.ready(function() {
                                let cekPengumumanDuration = setInterval(function(){
                                    if(videoPengumuman.currentTime() >= videoPengumuman.duration()){
                                        console.log('Player selesai');
                                        var id_next_video = Number(index)+1;
                                        if(id_next_video <= listPengumuman.length){
                                            playPengumuman(listPengumuman[id_next_video-1], id_next_video);
                                            videoPengumuman.initChildren();
                                        }else{
                                            playPengumuman();
                                        }
                                        clearInterval(cekPengumumanDuration);
                                        cekPengumumanDuration = null;
                                    }
                                }, 100);
                                
                            }); */
                          }
                          </script>
                        </div>
                        <div class="medium-card" style="overflow: hidden;height: 250px;">

                            <div class="stats-card-header">
                                <img src="assets/images/avatar.svg" loading="lazy" alt="" class="stats-card-header-icon" />
                                <h3 class="stats-card-header-title">Status Perangkat Desa</h3>
                            </div>

                            <div class="staff-bar-box" id="staffBar" data-title="Status Perangkat Desa" style="">
                            <div class="list-staff-box">
                                <?php
                                $get_all_staff = mysqli_query($con, "SELECT * 
                                    FROM demil_staffs LEFT JOIN demil_jabatan ON demil_staffs.staff_jabatan_id = demil_jabatan.jabatan_id where demil_staffs.staff_username <> 'operator' ORDER BY demil_staffs.staff_id ASC") or die(mysqli_error($con));
                                while($staff=mysqli_fetch_assoc($get_all_staff)):
                            ?>
                                <div class="team-member-list-1" data-staffID="<?=$staff['staff_id']; ?>">
                                    <div class="team-member-list-1-main">
                                        <img src="/DesaMilenial-Uploads/<?=isset($staff['staff_avatar']) ? $staff['staff_avatar'] : ''; ?>" loading="lazy" alt="" class="team-member-list-1-avatar" />
                                        <div class="team-member-list-1-main-detail">
                                            <h3 class="team-member-list-1-name"><?=isset($staff['staff_name']) ? $staff['staff_name'] : ''; ?></h3>
                                            <div class="team-member-list-1-jabatan"><?=isset($staff['jabatan_name']) ? $staff['jabatan_name'] : ''; ?></div>
                                        </div>
                                    </div>
                                    <div id="staff-status-<?=$staff['staff_id']; ?>">
                                        
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            </div>
                        </div>


                        </div>
                    </div>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js" integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                            
                            <script type="text/javascript">
                            
                            jQuery.ajax({
                                type: "GET",
                                url: 'getpikocis.php',
                                cache: true,
                                beforeSend: function(){
                                    jQuery(".covid-kab-loader").fadeIn();
                                },
                                success: function(pikocis) {
                                    jQuery(".covid-kab-loader").fadeOut();
                                    jQuery("#total_confirmed_kab").html(formatNum(pikocis.confirmed_count)+' kasus');
                                    jQuery("#total_recovered_kab").html(formatNum(pikocis.recovered_count)+' Sembuh');
                                    jQuery("#total_active_kab").html(formatNum(pikocis.active_count)+' Positif Aktif');
                                    jQuery("#total_death_kab").html(formatNum(pikocis.death_count)+' Meninggal dunia');
                                    jQuery("#total_suspect_kab").html(formatNum(pikocis.suspect_count)+' Suspek');
                                    jQuery(".covid-city-stats").css('display', 'flex');
                                    jQuery(".covid-city-stats").fadeIn();

                                    // Make Chart
                                    var ctx = document.getElementById('covid-desa');
                                    var ctx2 = ctx.getContext("2d");

                                    var warna_positif = ctx2.createLinearGradient(0, 0, 0, 100);
                                    warna_positif.addColorStop(0, 'rgba(255,132,45,1)');
                                    warna_positif.addColorStop(0.5, 'rgba(254,95,69,0.9)');   
                                    warna_positif.addColorStop(1, 'rgba(249,53,95,1)');  

                                    var warna_sembuh = ctx2.createLinearGradient(0, 0, 0, 100);
                                    warna_sembuh.addColorStop(0, 'rgba(173,231,43,0.6)');   
                                    warna_sembuh.addColorStop(0.7, 'rgba(211,247,129,0.9)');
                                    warna_sembuh.addColorStop(1, 'rgba(173,231,43,1)'); 

                                    var warna_kasus = ctx2.createLinearGradient(0, 0, 0, 100);
                                    warna_kasus.addColorStop(0, 'rgba(255,255,255,0.6)');   
                                    warna_kasus.addColorStop(0.4, 'rgba(255,255,255,0.9)');
                                    warna_kasus.addColorStop(1, 'rgba(255,255,255,1)'); 

                                    var warna_meninggal = ctx2.createLinearGradient(0, 0, 0, 100);
                                    warna_meninggal.addColorStop(0, 'rgba(42,27,66,1)');   
                                    warna_meninggal.addColorStop(0.7, 'rgba(255,255,255,0.1)');
                                    warna_meninggal.addColorStop(1, 'rgba(71,43,109,1)'); 

                                    var warna_suspek = ctx2.createLinearGradient(0, 0, 0, 100);
                                    warna_suspek.addColorStop(0, 'rgba(223,137,33,1)');   
                                    warna_suspek.addColorStop(0.4, 'rgba(238,137,15,0.8)');
                                    warna_suspek.addColorStop(1, 'rgba(244,179,100,1)'); 

                                    var myChart = new Chart(ctx, {
                                        type: 'pie',
                                        data: {
                                            labels: [
                                                'Sembuh',
                                                'Positif',
                                                'Meninggal',
                                                'Suspek'
                                              ],
                                              datasets: [{
                                                label: 'Covid Datasheet Kabupaten Ciamis',
                                                data: [pikocis.recovered_count, pikocis.active_count,  pikocis.death_count, pikocis.suspect_count],
                                                backgroundColor: [
                                                  warna_sembuh,
                                                  warna_positif,
                                                  warna_meninggal,
                                                  // 'rgb(255, 205, 86)'
                                                  warna_suspek
                                                ],
                                                hoverOnlineset: 4
                                              }]
                                        },
                                        options: {
                                            responsive: true,
                                            borderWidth: 1,
                                            borderColor: 'rgba(255,255,255,0.3)',
                                            plugins: {
                                              legend: {
                                                display: false,
                                              },
                                              title: {
                                                display: false,
                                                text: 'Desa Dewasari'
                                              }
                                            }
                                        },
                                    });

                                }
                            });

                            function formatNum(value) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                            </script>
                    <div class="demilinteractive_rows">
                        <div class="stats-card kependudukan">
                            <div class="stats-card-header">
                                <img src="assets/images/group.svg" loading="lazy" alt="" class="stats-card-header-icon" />
                                <h3 class="stats-card-header-title">Kependudukan &amp; Pendidikan</h3>
                            </div>
                            <div class="penduduk-loader"><img src="assets/images/loader-interactive-1.svg" alt="Memuat.."></div>
                                
                            <div class="penduduk-boxes" style="display:none">
                                <div class="penduduk-box">
                                    <img src="assets/images/parent.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="jumlah_kk">0</div>
                                        <div class="penduduk-box-title">Kepala Keluarga</div>
                                    </div>
                                </div>
                                <div class="penduduk-box">
                                    <img src="assets/images/group.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="jumlah_penduduk">0</div>
                                        <div class="penduduk-box-title">Penduduk</div>
                                    </div>
                                </div>
                                <div class="penduduk-box">
                                    <img src="assets/images/male.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="jumlah_penduduk_male">0</div>
                                        <div class="penduduk-box-title">Laki-laki</div>
                                    </div>
                                </div>
                                <div class="penduduk-box">
                                    <img src="assets/images/femenine.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="jumlah_penduduk_female">0</div>
                                        <div class="penduduk-box-title">Perempuan</div>
                                    </div>
                                </div>
                                <div class="penduduk-box">
                                    <img src="assets/images/baby-boy.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="pendidikan_tidak_belum_sekolah">0</div>
                                        <div class="penduduk-box-title">Tidak / Belum&nbsp;Sekolah</div>
                                    </div>
                                </div>
                                <div class="penduduk-box">
                                    <img src="assets/images/school.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="pendidikan_sd_sederajat">0</div>
                                        <div class="penduduk-box-title">SD / Sederajat</div>
                                    </div>
                                </div>
                                <div class="penduduk-box">
                                    <img src="assets/images/university.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="pendidikan_smp_sederajat">0</div>
                                        <div class="penduduk-box-title">SLTP / Sederajat</div>
                                    </div>
                                </div>
                                <div class="penduduk-box">
                                    <img src="assets/images/university.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="pendidikan_sma_sederajat">0</div>
                                        <div class="penduduk-box-title">SLTA / Sederajat</div>
                                    </div>
                                </div>
                                <div class="penduduk-box">
                                    <img src="assets/images/bachelor.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="pendidikan_diploma">0</div>
                                        <div class="penduduk-box-title">DI / DII / DIII / DIV</div>
                                    </div>
                                </div>
                                <div class="penduduk-box">
                                    <img src="assets/images/graduation-hat.svg" loading="lazy" alt="" class="penduduk-box-icon" />
                                    <div class="penduduk-box-content">
                                        <div class="penduduk-box-num" id="pendidikan_sarjana">0</div>
                                        <div class="penduduk-box-title">S1 / S2 / S3</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                        jQuery(document).ready(function(){
                            jQuery.ajax({
                                type: "GET",
                                url: '<?=$home_url; ?>interactive/penduduk_json.php',
                                cache: true,
                                beforeSend: function(){
                                    jQuery(".penduduk-loader").fadeIn();
                                },
                                success: function(penduduk) {
                                   jQuery(".penduduk-loader").hide();
                                   jQuery(".penduduk-boxes").css('display', 'flex');
                                   jQuery(".penduduk-boxes").fadeIn();
                                   jQuery("#jumlah_kk").html(formatNum(penduduk.jumlah_kk));
                                   jQuery("#jumlah_penduduk").html(formatNum(penduduk.jumlah_penduduk));
                                   jQuery("#jumlah_penduduk_male").html(formatNum(penduduk.jumlah_penduduk_male));
                                   jQuery("#jumlah_penduduk_female").html(formatNum(penduduk.jumlah_penduduk_female));
                                   jQuery("#pendidikan_tidak_belum_sekolah").html(formatNum(penduduk.pendidikan_tidak_belum_sekolah));
                                   jQuery("#pendidikan_sd_sederajat").html(formatNum(penduduk.pendidikan_sd_sederajat));
                                   jQuery("#pendidikan_smp_sederajat").html(formatNum(penduduk.pendidikan_smp_sederajat));
                                   jQuery("#pendidikan_sma_sederajat").html(formatNum(penduduk.pendidikan_sma_sederajat));
                                   jQuery("#pendidikan_diploma").html(formatNum(penduduk.pendidikan_diploma));
                                   jQuery("#pendidikan_sarjana").html(formatNum(penduduk.pendidikan_sarjana));
                                }
                            });
                        });
                        </script>

                        <?php
                            $total_anggaran = 2047058001;
                        ?>

                        <div class="stats-card">
                            <div class="stats-card-header">
                                <img src="assets/images/money.svg" loading="lazy" alt="" class="stats-card-header-icon" />
                                <h3 class="stats-card-header-title">APBDes <span style="font-family: Sen">(<?=rupiah($total_anggaran); ?>)</span></h3>
                            </div>

                            <?php

                            function rupiah($angka){
                                    $hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
                                    return $hasil_rupiah;
                                }

                            // Pendapatan
                            $pendapatan_apbdes = 2047058001;


                            $penyelenggaraan_pemerintahan = 865804912;
                            $pelaksanaan_pembangunan = 789688150;
                            $pembinaan_kemasyarakatan = 14400000;
                            $pemberdayaan_kemasyarakatan = 25554800;
                            $penanggulangan_bencana = 240655090;
                            $surplus = 110955049;

                            ?>

                            <div class="keuangan-box">
                                <div class="keuangan-percentage" style="margin-right:4px;">
                                    <div id="penyelenggaraan_pemerintahan" class="purple extra-small" style=""></div>
                                </div>
                                <div class="keuangan-content">
                                    <div class="keuangan-name">Penyelenggaraan Pemerintahan</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($penyelenggaraan_pemerintahan); ?></h3>
                                </div>
                            </div>

                            <div class="keuangan-box">
                                <div class="keuangan-percentage" style="margin-right:4px;">
                                    <div id="pelaksanaan_pembangunan" class="purple extra-small" style=""></div>
                                </div>
                                <div class="keuangan-content">
                                    <div class="keuangan-name">Pelaksanaan Pembangunan</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($pelaksanaan_pembangunan); ?></h3>
                                </div>
                            </div>

                            <div class="keuangan-box">
                                <div class="keuangan-percentage" style="margin-right:4px;">
                                    <div id="pembinaan_kemasyarakatan" class="purple extra-small" style=""></div>
                                </div>
                                <div class="keuangan-content">
                                    <div class="keuangan-name">Pembinaan Kemasyarakatan</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($pembinaan_kemasyarakatan); ?></h3>
                                </div>
                            </div>

                            <div class="keuangan-box">
                                <div class="keuangan-percentage" style="margin-right:4px;">
                                    <div id="pemberdayaan_kemasyarakatan" class="purple extra-small" style=""></div>
                                </div>
                                <div class="keuangan-content">
                                    <div class="keuangan-name">Pemberdayaan Masyarakat</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($pemberdayaan_kemasyarakatan); ?></h3>
                                </div>
                            </div>

                            <div class="keuangan-box">
                                <div class="keuangan-percentage" style="margin-right:4px;">
                                    <div id="penanggulangan_bencana" class="purple extra-small" style=""></div>
                                </div>
                                <div class="keuangan-content">
                                    <div class="keuangan-name">Penanggulangan Bencana</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($penanggulangan_bencana); ?></h3>
                                </div>
                            </div>

                            <div class="keuangan-box" style="margin-top:-5px">
                                <div class="keuangan-content">
                                    <div class="keuangan-name">Surplus <?=rupiah($surplus); ?></div>
                                </div>
                            </div>




                            <!--
                            <?php
                                

                                $anggaran_pendapatan = 2058727000;
                                $realisasi_pendapatan = 961053262;
                                $anggaran_belanja = 1951412370;
                                $realisasi_belanja = 884449030;
                                $anggaran_pembiayaan = 107314630;
                                $realisasi_pembiayaan = 5141630;
                            ?>
                            
                            <div class="keuangan-box">
                                <div class="keuangan-percentage">
                                    <div id="pendapatan-desa" class="purple small" style=""></div>
                                </div>
                                <div class="keuangan-content">
                                    <div class="keuangan-name">Pendapatan</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($anggaran_pendapatan); ?></h3>
                                    <div class="keuangan-name">Realisasi</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($realisasi_pendapatan); ?></h3>
                                </div>
                            </div>

                            <div class="keuangan-box">
                                <div class="keuangan-percentage">
                                    <div id="belanja-desa" class="purple small" style=""></div>
                                </div>
                                <div class="keuangan-content">
                                    <div class="keuangan-name">Belanja</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($anggaran_belanja); ?></h3>
                                    <div class="keuangan-name">Realisasi</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($realisasi_belanja); ?></h3>
                                </div>
                            </div>

                            <div class="keuangan-box">
                                <div class="keuangan-percentage">
                                    <div id="pembiayaan-desa" class="purple small" style=""></div>
                                </div>
                                <div class="keuangan-content">
                                    <div class="keuangan-name">Pembiayaan</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($anggaran_pembiayaan); ?></h3>
                                    <div class="keuangan-name">Realisasi</div>
                                    <h3 class="keuangan-nominal"><?=rupiah($realisasi_pembiayaan); ?></h3>
                                </div>
                            </div>
                            -->
                        </div>

                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                <?php
                                /*    $pendapatan_desa_percentage = ($realisasi_pendapatan / $anggaran_pendapatan) * 100;
                                    $pendapatan_desa_percentage = number_format($pendapatan_desa_percentage, 1, ".", "");
                                    $belanja_desa_percentage = ($realisasi_belanja / $anggaran_belanja) * 100;
                                    $belanja_desa_percentage = number_format($belanja_desa_percentage, 1, ".", "");
                                    $pembiayaan_desa_percentage = ($realisasi_pembiayaan / $anggaran_pembiayaan) * 100;
                                    $pembiayaan_desa_percentage = number_format($pembiayaan_desa_percentage, 1, ".", "");

                                ?>
                                jQuery("#pendapatan-desa").percircle({percent: <?=$pendapatan_desa_percentage; ?>,text: "<?=$pendapatan_desa_percentage; ?>%"});
                                jQuery("#belanja-desa").percircle({percent: <?=$belanja_desa_percentage; ?>,text: "<?=$belanja_desa_percentage; ?>%"});
                                jQuery("#pembiayaan-desa").percircle({percent: <?=$pembiayaan_desa_percentage; ?>,text: "<?=$pembiayaan_desa_percentage; ?>%"});
                                */

                                $penyelenggaraan_pemerintahan_percentage = ($penyelenggaraan_pemerintahan / $pendapatan_apbdes) * 100;
                                $penyelenggaraan_pemerintahan_percentage = number_format($penyelenggaraan_pemerintahan_percentage, 1, ".", "");

                                $pelaksanaan_pembangunan_percentage = ($pelaksanaan_pembangunan / $pendapatan_apbdes) * 100;
                                $pelaksanaan_pembangunan_percentage = number_format($pelaksanaan_pembangunan_percentage, 1, ".", "");
                                
                                $pembinaan_kemasyarakatan_percentage = ($pembinaan_kemasyarakatan / $pendapatan_apbdes) * 100;
                                $pembinaan_kemasyarakatan_percentage = number_format($pembinaan_kemasyarakatan_percentage, 1, ".", "");
                                
                                $pemberdayaan_kemasyarakatan_percentage = ($pemberdayaan_kemasyarakatan / $pendapatan_apbdes) * 100;
                                $pemberdayaan_kemasyarakatan_percentage = number_format($pemberdayaan_kemasyarakatan_percentage, 1, ".", "");
                                
                                $penanggulangan_bencana_percentage = ($penanggulangan_bencana / $pendapatan_apbdes) * 100;
                                $penanggulangan_bencana_percentage = number_format($penanggulangan_bencana_percentage, 1, ".", "");
                                
                                ?>

                                jQuery("#penyelenggaraan_pemerintahan").percircle({percent: <?=$penyelenggaraan_pemerintahan_percentage; ?>,text: "<?=$penyelenggaraan_pemerintahan_percentage; ?>%"});
                                jQuery("#pelaksanaan_pembangunan").percircle({percent: <?=$pelaksanaan_pembangunan_percentage; ?>,text: "<?=$pelaksanaan_pembangunan_percentage; ?>%"});
                                jQuery("#pembinaan_kemasyarakatan").percircle({percent: <?=$pembinaan_kemasyarakatan_percentage; ?>,text: "<?=$pembinaan_kemasyarakatan_percentage; ?>%"});
                                jQuery("#pemberdayaan_kemasyarakatan").percircle({percent: <?=$pemberdayaan_kemasyarakatan_percentage; ?>,text: "<?=$pemberdayaan_kemasyarakatan_percentage; ?>%"});
                                jQuery("#penanggulangan_bencana").percircle({percent: <?=$penanggulangan_bencana_percentage; ?>,text: "<?=$penanggulangan_bencana_percentage; ?>%"});

                            });
                        </script>

                        <div class="stats-card" style="min-width:270px">
                            <div class="stats-card-header">
                                <img src="assets/images/shining.svg" loading="lazy" alt="" class="stats-card-header-icon">
                                <h3 class="stats-card-header-title">IDM Desa Dewasari</h3>
                            </div>

                            <div class="idm-loader"><img src="assets/images/loader-interactive-1.svg" alt="Memuat.."></div>
                            
                            <div class="idm-desa-box" style="display:none">

                            <div class="idm-box">
                                <div class="idm-chart" style="width:80px;">
                                    <div class="chart-container covid-desa" style="position: relative;width:80px;height:80px;">
                                    <canvas id="idm-desa"></canvas>
                                    </div>
                                </div>
                                
                                <div class="keuangan-content">

                                    <div class="idm-tag">
                                        <img src="assets/images/medal%20(1).svg" loading="lazy" alt="" class="idm-icon">
                                        <div class="idm-tag-content">
                                            <div class="idm-tag-sub-title">Status IDM</div>
                                            <h3 class="idm-tag-name status-idm-desa"></h3>
                                            <div class="idm-tag-sub-title nilai-idm"></div>
                                        </div>
                                    </div>

                                    <div class="idm-datasheets" style="display:none"></div>
                                    <div id="idm-legends"></div>
                                </div>
                            </div>

                            </div>

                        </div>

                    </div>
                </div>


                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        let getIDM = function(){
                            jQuery.ajax({
                                type: "GET",
                                url: 'getidm.php?username=<?=$profile->kode_wilayah; ?>&pass=idm-kemendesa_<?=Date('Y'); ?><?php if(isset($setting->infographic_idm_year) AND $setting->infographic_idm_year != ''): echo '&year='.$setting->infographic_idm_year; endif;?>',
                                cache: true,
                                beforeSend: function(){
                                    jQuery(".idm-loader").fadeIn();
                                },
                                success: function(idm) {
                                    if(idm.status == 'error'){
                                        console.log(idm);
                                        getIDM();
                                    }

                                    if(idm.status == 'success'){
                                        jQuery(".idm-loader").hide();
                                        jQuery(".idm-desa-box").fadeIn();
                                        jQuery(".idm-desa-box").css('display', 'flex');
                                        jQuery(".status-idm-desa").html('Desa '+(idm.idm_status).replace(':', ': '));
                                        jQuery(".nilai-idm").html('Nilai '+(idm.idm_value).replace(':', ': '));

                                        // Make Chart
                                        var total_point = 0;
                                        for(let data in idm.idm_data){
                                            data = idm.idm_data[data];
                                            total_point = total_point+data.point;
                                        }

                                        var idm_legend = '';
                                        var idm_datasheets = [];
                                        var idm_labels = [];
                                        var no_indicator = 1;
                                        for(let data in idm.idm_data){
                                            data = idm.idm_data[data];
                                            let percentage = (data.point/total_point)*100;
                                            percentage = (Math.round(percentage * 100) / 100).toFixed(2)+'%';
                                            
                                            let legend_color = '';
                                            if(no_indicator == 1){
                                                legend_color = 'rgb(174, 66, 179)';
                                            }
                                            if(no_indicator == 2){
                                                legend_color = 'rgb(135, 35, 138)';
                                            }
                                            if(no_indicator == 3){
                                                legend_color = 'rgb(103, 17, 106)';
                                            }

                                            idm_legend += '<div class="idm-legend"> <div class="idm-indicator-circle" style="background:'+legend_color+'"></div> <div class="idm-indicator-name">'+data.series+' '+data.point+' / '+percentage+' </div> </div>'; 
                                            idm_datasheets.push(data.point);
                                            idm_labels.push(data.series);
                                            no_indicator = no_indicator+1;
                                        }

                                        // Update IDM Legends
                                        jQuery('#idm-legends').html(idm_legend);

                                        // Make chart
                                        if(idm_labels == undefined){
                                            console.log('belum ada labelnya');
                                        }
                                        var ctx = document.getElementById('idm-desa');
                                        var ctx2 = ctx.getContext("2d");

                                        // Colors of IDM chart
                                        var idm_1 = 'rgb(174, 66, 179)';
                                        var idm_2 = 'rgb(135, 35, 138)';
                                        var idm_3 = 'rgb(103, 17, 106)';

                                        var myChart = new Chart(ctx, {
                                            type: 'doughnut',
                                            data: {
                                                labels: idm_labels,
                                                  datasets: [{
                                                    label: 'IDM Datasheet Dewasari',
                                                    data: idm_datasheets,
                                                    backgroundColor: [
                                                      idm_1,
                                                      idm_2,
                                                      idm_3,
                                                    ],
                                                    hoverOnlineset: 4
                                                  }]
                                            },
                                            options: {
                                                responsive: true,
                                                borderWidth: 0,
                                                borderColor: 'rgba(255,255,255,0.3)',
                                                plugins: {
                                                  legend: {
                                                    display: false,
                                                  },
                                                  title: {
                                                    display: false,
                                                    text: 'Desa Dewasari'
                                                  }
                                                }
                                            },
                                        });
                                        
                                    }
                                }
                            });
                        };
                    getIDM();
                });
                </script>

                <div class="staff_bar">
                    <div class="stats-card stats-card-100">
                        <div class="stats-card-header">
                            <img src="assets/images/avatar.svg" loading="lazy" alt="" class="stats-card-header-icon" />
                            <h3 class="stats-card-header-title" id="bar-title">-</h3>
                        </div>
                        

                        <?php
                        // Get LKD
                        $idx_lkd = 0;
                        $get_all_lkd = mysqli_query($con, "SELECT * 
                            FROM demil_lkd") or die(mysqli_error($con));
                        while($lkd=mysqli_fetch_assoc($get_all_lkd)):
                            ?>
                        <div class="staff-bar-box" id="bar-<?=$idx_lkd; ?>" data-title="<?=$lkd['lkd_title']; ?>" style="display: none;">
                            
                            <div class="list-staff-box">
                                <?php
                                $id_lkd = $lkd['lkd_id'];
                                $get_lkd_content = mysqli_query($con, "SELECT * 
                                    FROM demil_lkd where lkd_id = '{$id_lkd}'") or die(mysqli_error($con));
                                while($content=mysqli_fetch_assoc($get_lkd_content)):

                                    $content = (object)$content;

                                    if($content->lkd_content != '' AND $content->lkd_content != '[]'): 
                                        $anggotas = json_decode($content->lkd_content);

                                        foreach ($anggotas as $anggota) : 
                            ?>

                            <div class="team-member-list-1">
                                <div class="team-member-list-1-main">
                                    <div class="team-member-list-1-avatar"></div>
                                    
                                    <div class="team-member-list-1-main-detail">
                                        <h3 class="team-member-list-1-name"><?=$anggota->nama; ?></h3>
                                        <div class="team-member-list-1-jabatan"><?=$anggota->jabatan; ?></div>
                                    </div>
                                </div>
                            </div>

                            <?php endforeach; endif; ?>

                            <?php endwhile; ?>
                            </div>

                        </div>
                        <?php $idx_lkd++; endwhile; ?>

                        
                    </div>
                </div>

            </div>
        </div>

        <!-- Staff Status -->
        <script type="text/javascript">
            // Bar staff
            jQuery(document).ready(function(){
                autoPlayBar();
                autoPlayStaff();
            });

            function autoPlayStaff(){

                jQuery("#staffBar").fadeIn();

                totalActiveBarChildStaff = jQuery("#staffBar .list-staff-box .team-member-list-1").length;

                indexSlideUpStaff = 0;
                window.staffBarSlideUp = setInterval(function(){

                    // Kalau totalchild kurang dari 12
                    if(totalActiveBarChildStaff <= 7){
                        clearInterval(window.staffBarSlideUp);
                        window.staffBarSlideUp = null;

                        setTimeout(autoPlayStaff, 10000);

                    }else{
                        let totalVisibleChildStaff = jQuery("#staffBar .list-staff-box .team-member-list-1:visible").length;

                        console.log(totalVisibleChildStaff);

                        if(totalVisibleChildStaff > 7){
                            // SlideUp
                            jQuery("#staffBar .list-staff-box .team-member-list-1").eq(indexSlideUpStaff).slideUp();
                            indexSlideUpStaff++;
                        }else{
                            // Reset current bar
                            jQuery("#staffBar").fadeOut();

                            jQuery("#staffBar .list-staff-box .team-member-list-1:hidden").slideDown();

                            clearInterval(window.staffBarSlideUp);
                            window.staffBarSlideUp = null;

                            autoPlayStaff();

                        }
                    }
                    
                }, 3000);

                return false;
            }

            function autoPlayBar(activeBar){
                if(activeBar == undefined){
                    activeBar = 0;
                }

                // Update the title
                let titleBar = jQuery("#bar-"+activeBar).data('title');
                jQuery("#bar-title").hide();
                jQuery("#bar-title").html(titleBar);
                jQuery("#bar-title").fadeIn();

                // Show the bar
                jQuery("#bar-"+activeBar).fadeIn();

                // Jumlah Bar
                let totalBar = jQuery(".staff-bar-box").length;
                nextBar = activeBar+1;
                if(nextBar >= totalBar){
                    nextBar = 0;
                }

                totalActiveBarChild = jQuery("#bar-"+activeBar+" .list-staff-box .team-member-list-1").length;

                indexSlideUp = 0;
                window.activeBarSlideUp = setInterval(function(){

                    // Kalau totalchild kurang dari 12
                    if(totalActiveBarChild <= 13){
                        clearInterval(window.activeBarSlideUp);
                        window.activeBarSlideUp = null;

                        setTimeout(slideBarWithoutAnimation, 10000, activeBar, nextBar);

                    }else{
                        let totalVisibleChild = jQuery("#bar-"+activeBar+" .list-staff-box .team-member-list-1:visible").length;

                        if(totalVisibleChild > 13){
                            // SlideUp
                            jQuery("#bar-"+activeBar+" .list-staff-box .team-member-list-1").eq(indexSlideUp).slideUp();
                            indexSlideUp++;
                        }else{
                            // Reset current bar
                            jQuery("#bar-"+activeBar).hide();

                            jQuery("#bar-"+activeBar+" .list-staff-box .team-member-list-1:hidden").slideDown();

                            clearInterval(window.activeBarSlideUp);
                            window.activeBarSlideUp = null;

                            autoPlayBar(nextBar);

                        }
                    }
                    
                }, 3000);
            }

            function slideBarWithoutAnimation(activeBar, nextBar){
                console.log('10 detik');
                // Hide current activeBar
                jQuery("#bar-"+activeBar).hide();

                autoPlayBar(nextBar);

                return false;
            }

            // Get all staff id
            let staffIds = [];
            jQuery('.team-member-list-1').each(function(i, me) {
                let id_staff = jQuery(this).attr('data-staffID');
                staffIds.push(id_staff);
            });

            staffIds = staffIds.join('|');
            // Check staff status periodically
            setInterval(function(){
                updateStaffStatus(staffIds);
            }, 3000);
            

            function updateStaffStatus(staffIds){
                jQuery.ajax({
                    type: "GET",
                    url: '<?=$home_url; ?>presensi/getInfographicStaffStatus?ids='+staffIds,
                    success: function(response) {
                        if(response.status == 'success'){
                            // Itterate through statuses
                            jQuery.each(response.staff_statuses, function(index, status) {
                                jQuery("#staff-status-"+status.staff_id).html('<div class="'+status.staff_status.className+'">'+status.staff_status.statusName+'</div>');
                            });


                        }
                        
                    }
                });


                return false;
            }
        </script>

        <div class="demilinteractive_footer" style="overflow:hidden">
            <div class="running-text-title"><div class="runing-text-title-name"></div></div>
            <div class="running-text-footer">
            <span class="pengumuman"></span></div>
        </div>
        <span id="id_pengumuman" style="display:none">0</span>
    </div>


<script type="text/javascript">

    jQuery(document).ready(function(){
        let reload_pengumuman = function(){
            console.log('[LOG] Reload Pengumuman');
            jQuery.ajax({
                type: "GET",
                url: 'getPengumuman.php',
                cache: true,
                success: function(pengumuman){
                    // console.log(pengumuman);
                    // Start index 0
                    jQuery(".runing-text-title-name").html(pengumuman[0].author);
                    jQuery(".pengumuman").html(pengumuman[0].message);

                    startPengumuman(0, pengumuman);

                },
                error: function(){
                    console.log('[LOG] Error Load Pengumuman, Retry.');
                    reload_pengumuman();
                }
            });
        }

        reload_pengumuman();

        function startPengumuman(index, pengumuman){
            index_pengumuman = index;

            if((index_pengumuman+1) > pengumuman.length){
                reload_pengumuman();
            }else{
                // Start based on index
                jQuery(".runing-text-title-name").html(pengumuman[index_pengumuman].author);
                jQuery(".pengumuman").html(pengumuman[index_pengumuman].message);

                jQuery('.pengumuman').marquee({
                    count: 1,
                    speed: 20
                }).done(function() {
                    startPengumuman(index_pengumuman+1, pengumuman);
                });
            }
            
        }

    });
</script>
</body>
</html>

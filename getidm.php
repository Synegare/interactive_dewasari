<?php
$arr = array();
header('Content-Type: application/json');
$url = "https://idm.kemendesa.go.id/login";

// Get IDM Session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0',
    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
    'Accept-Language' => 'en-US,en;q=0.5',
    'Accept-Encoding' => 'gzip, deflate, br',
    'Referer' => 'https://idm.kemendesa.go.id/login',
    'Connection' => 'keep-alive',
    'Upgrade-Insecure-Requests' => '1',
    'Sec-Fetch-Dest' => 'document',
    'Sec-Fetch-Mode' => 'navigate',
    'Sec-Fetch-Site' => 'same-origin',
]);


$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);



$header = explode('Set-Cookie: idm_session=', $header); // tadinya idm_session




if(isset($header[1]) && $header[1] != ''){
   $header = explode('; expires=', $header[1])[0];
   $idm_session = $header;
}else{
   $idm_session = 'N/A';
}

// If fail to catch idm sesion
if($idm_session == 'N/A'){
   $arr = array(
         'status' => 'error',
         'msg'    => 'Failed to obtain IDM session.'
   );
}else{

   $username = isset($_GET['username']) ? $_GET['username'] : '';
   $pass = isset($_GET['pass']) ? $_GET['pass'] : '';

   if($username != '' && $pass != ''){

      $headers = array(
         "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:90.0) Gecko/20100101 Firefox/90.0",
         "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
         "Accept-Language: en-US,en;q=0.5",
         "Content-Type: application/x-www-form-urlencoded",
         "Origin: https://idm.kemendesa.go.id",
         "Connection: keep-alive",
         "Referer: https://idm.kemendesa.go.id/login",
         "Cookie: ci_csrf_token=ipayganteng; idm_session=".$idm_session,
         "Upgrade-Insecure-Requests: 1",
         "Sec-Fetch-Dest: document",
         "Sec-Fetch-Mode: navigate",
         "Sec-Fetch-Site: same-origin",
         "Sec-Fetch-User: ?1",
      );

      $data = "ci_csrf_token=ipayganteng&login=".$username."&password=".$pass."&log-me-in=Sign+In";

      // $url = 'https://idm.kemendesa.go.id/admin/content?y=2021';
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($curl, CURLOPT_ENCODING, '');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_HEADER, 1);
      curl_setopt($curl, CURLOPT_VERBOSE, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));

      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

      $resp = curl_exec($curl);
      
      curl_close($curl);

      // Set Resp Status
      $arr['status'] = 'success';

      // Get IDM tahun 2021
      $url_dash = "https://idm.kemendesa.go.id/admin/content?y=2022";

      $curl_dash = curl_init($url_dash);
      curl_setopt($curl_dash, CURLOPT_URL, $url_dash);
      curl_setopt($curl_dash, CURLOPT_RETURNTRANSFER, true);

      curl_setopt($curl_dash, CURLOPT_HTTPHEADER, $headers);

      curl_setopt($curl_dash, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl_dash, CURLOPT_SSL_VERIFYPEER, false);

      $resp = curl_exec($curl_dash);
      curl_close($curl_dash);


      // Get Village Name
      
      $get_village_name = explode('<li class="dropdown user user-menu">', $resp);
      if(isset($get_village_name[1]) && $get_village_name[1] != ''){
         $get_village_name = explode('<!-- User image -->', $get_village_name[1]);
         if(isset($get_village_name[0]) && $get_village_name[0] != ''){
            $village_name = preg_replace('/\s+/', '', strip_tags($get_village_name[0]));
         }else{
            $village_name = 'N/A';
         }

         $arr['village_name'] = ucfirst(strtolower($village_name));
      }else{
         $arr['village_name'] = 'N/A';
      }
         

      // Get IDM Status
      $get_status_idm = explode('<td>STATUS IDM</td>', $resp);
      if(isset($get_status_idm[0]) && $get_status_idm[0] != ''){
         $get_status_idm = explode('<td>NILAI IDM</td>', $get_status_idm[1]); 
         if(isset($get_status_idm[0]) && $get_status_idm[0] != ''){
            $idm_status = preg_replace('/\s+/', '', strip_tags($get_status_idm[0]));
         }else{
            $idm_status = 'N/A';
         }

         $arr['idm_status'] = ucfirst(strtolower($idm_status));

      }else{
         $arr['idm_status'] = 'N/A';
      }

      // Get IDM Value
      $get_value_idm = explode('<td>NILAI IDM</td>', $resp);
      if(isset($get_value_idm[1]) && $get_value_idm[1] != ''){

         $get_value_idm = explode('<div class="col-xl-6 col-lg-6 col-md-6 box-body">', $get_value_idm[1]);

         if(isset($get_value_idm[0]) && $get_value_idm[0] != ''){
            $idm_value = preg_replace('/\s+/', '', strip_tags($get_value_idm[0]));
         }else{
            $idm_value = 'N/A';
         }

         $arr['idm_value'] = $idm_value;

      }else{
         $arr['idm_value'] = 'N/A';
      }

      // Get Data Variables
      $get_data_idm = explode('"piechart_status", "PieChart");', $resp);
      if(isset($get_data_idm[0]) && $get_data_idm[0] != ''){

         $get_data_idm = explode('"data": ', $get_data_idm[0]);
         if(isset($get_data_idm[1]) && $get_data_idm[1] != ''){
            $idm_data = preg_replace('/\s+/', '', $get_data_idm[1]);
            $idm_data = str_replace(",},", '', $idm_data);
            $idm_data = json_decode($idm_data, true);
         }else{
            $idm_data = 'N/A';
         }

         $arr['idm_data'] = $idm_data;

      }else{
         $arr['idm_data'] = 'N/A';
      }
   }else{
      $arr = array(
               'status' => 'error',
               'msg'    => 'Username & Password are invalid!'
         );
   }

}


echo json_encode($arr, JSON_FORCE_OBJECT);

?>


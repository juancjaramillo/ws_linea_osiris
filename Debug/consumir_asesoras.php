<?php

$array = array(
			"rootAsesoras"=> array(
				"asesora"=> array(
					array(
						
					),
					array(
						
					),
					array(
						
					)
				)					
			)
		);		



$postData = json_encode($array);

/*
echo '<pre>';
echo 'Parámetro enviado======> '.$postData;
//echo '</br>';
echo '</pre>';
die();
*/

$curl = curl_init("http://10.1.x.xx/JCJC/ws_crmLINXX_osiris/index.php/setAsesoras");
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($curl, CURLOPT_HTTPHEADER,array("application/json"));
//curl_setopt($curl, CURLOPT_HTTPHEADER,array("X-TOKEN-AUTH: 123456789ABCDEFG"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

//curl_setopt($curl, 'TOKEN-AUTH', '123456789ABCDEFG');


$json_response = curl_exec($curl);
print_r($json_response);

curl_close($curl);


?>
<?php

$recordatorios='{
		"rootRecordatorios": {
		"recordatorio": [{
			
			
		}, {
			
		}, {
			
		}]
	}
	}';




/*
echo '<pre>';
echo 'Parámetro enviado======> '.$recordatorios;
//echo '</br>';
echo '</pre>';
die();
*/


$curl = curl_init("http://10.1.x.xx/JCJC/ws_crmLINXX_osiris/index.php/setRecordatorios");
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($curl, CURLOPT_HTTPHEADER,array("application/json"));
//curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $recordatorios);

$json_response = curl_exec($curl);
print_r($json_response);

curl_close($curl);


?>
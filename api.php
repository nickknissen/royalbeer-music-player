<?php  
//URL parameter proxy fordi endpointet ikke gør brug af JSONP/CORS 
header('Content-Type: application/json');

$apiUrl = 'http://royalbeer.dk/wp-admin/admin-ajax.php?';
$queryParameters = $_SERVER['QUERY_STRING'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl . $queryParameters);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

echo curl_exec($ch);

curl_close($ch);  

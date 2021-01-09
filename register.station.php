<?php

 /**
 * @author Robert Byrnes
 * @created 01/01/2021
 * @source openweathermap.org
 * @action: register a weather station
 **/

 /*
 * The return from this request will look like this:
{
    "ID":"5ff8f74b09e7430001b9d356",
    "updated_at":"2021-01-09T00:22:35.289489979Z",
    "created_at":"2021-01-09T00:22:35.289489816Z",
    "user_id":"5fee3da73da20c00075eb2d0",
    "external_id":"CRED_STAT_01",
    "name":"Crediton Meterological Station",
    "latitude":50.78,
    "longitude":-3.65,
    "altitude":70,
    "rank":10,
    "source_type":5
}
*/

$url = 'http://api.openweathermap.org/data/3.0/stations?appid=bf2351e66f80a2980c1886fc9b396ec9';
$data = array(
    "external_id"   => "CRED_STAT_01",
    "name"          => "Crediton Meterological Station",
    "latitude"      => 50.78,
    "longitude"     => -3.65,
    "altitude"      => 70
);

$postdata = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
curl_close($ch);
print_r ($result);
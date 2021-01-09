<?php
 /**
 * @author Robert Byrnes
 * @created 01/01/2021
 * @source openweathermap.org
 * @action: register a weather station
 * @licence: GNU
 **/
/*
* Set up the following variables to enable access to the open weather map api and to create a database connection
* Create open weather map account, generate an app id/api key and copy it here...
*/
$apiKey = 'copy api key here';
$database = 'replace with database name';
$host = 'localhost'; // replace if different
$username = 'replace with database username';
$password = 'replace with database user password';
$data = array(
    "external_id"   => "any id you want your station to have",
    "name"          => "a name for your station",
    "latitude"      => 50.78, // replace with your own data - ensure a 'float'
    "longitude"     => -3.65, // replace with your own data - ensure a 'float'
    "altitude"      => 70 // replace with your own data - 'integer' works fine
);


// Send the cURL request to register the station 
$url = 'http://api.openweathermap.org/data/3.0/stations?appid='.$apiKey;
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

 /* The return from a successful request will be a json object and look like this:
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

// Convert return data from json object to php array and print to the page for easy reading 
$insertArray = json_decode($result,true);
if (preg_match('/wamp64|repositories/i', __DIR__) || !empty($_REQUEST['debug'])) {
    echo '<pre>'.str_repeat('=', 14)."\nSTATION ARRAY:\n".str_repeat('=', 14)."\n  FILE: ".__FILE__."\n  LINE: ".__LINE__."\n".
    str_repeat('=', 14)."\n".print_r($newArray, true).'</pre>';
}

// Create the database connection to store the return data
$dsn = 'mysql:host='.$host.';dbname='.$database.'';
try {
    $db = new PDO($dsn, $username, $password);

} catch (PDOException $ex) {
    $exception = $ex->getMessage();
    echo $exception;
}

// Store the return data - this will be useful when sending future requests to the api
stashRegistration($insertArray, $db);
function stashRegistration($insertArray, $db)
{
    $sql = "INSERT INTO open_weather_registrations (open_weather_id	, updated_at, created_at, `user_id`, external_id, `name`, latitude, longitude, `rank`, source_type) 
    VALUES (:ID, :updated_at, :created_at, :user_id, :external_id, :name, :latitude, :longitude, :rank, :source_type)";
    $stmt = $db->prepare($sql);
     
    try {
        $success = $stmt->execute($newArray);
    
    } catch (PDOException $ex) {
        $exception = $ex->getMessage();
        echo $exception;
    }
   if ($success) {
       echo "DB Success.";
   } else {
       echo "DB insert failed.";
   }
   return $success;
}
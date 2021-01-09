<?php

include('db.config.php');

$return = array(
    "ID"                => "5ff8f74b09e7430001b9d356",  
    "updated_at"        => "2021-01-09T00:22:35.289489979Z",
    "created_at"        => "2021-01-09T00:22:35.289489816Z",
    "user_id"           => "5fee3da73da20c00075eb2d0",
    "external_id"       => "CRED_STAT_01",
    "name"              => "Crediton Meterological Station",
    "latitude"          => 50.78,
    "longitude"         => -3.65,
    "rank"              => 70,
    "source_type"       => 5
);

$registered = json_encode($return);

$newArray = json_decode($registered,true);

if (preg_match('/mamp|repositories/i', __DIR__) || !empty($_REQUEST['debug'])) {echo '<pre>'.str_repeat('=', 14)."\nPRINT_R DEBUG:\n".str_repeat('=', 14)."\n  FILE: ".__FILE__."\n  LINE: ".__LINE__."\n".str_repeat('=', 14)."\n".print_r($newArray, true).'</pre>';}

stashRegistration($newArray, $db);

function stashRegistration($newArray, $db)
{
    $sql = "INSERT INTO open_weather_registrations (open_weather_id	, updated_at, created_at, `user_id`, external_id, `name`, latitude, longitude, `rank`, source_type) VALUES (:ID, :updated_at, :created_at, :user_id, :external_id, :name, :latitude, :longitude, :rank, :source_type)";
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
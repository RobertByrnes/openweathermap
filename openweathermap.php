<?php

/**
 * @author Robert Byrnes
 * @created 31/12/2020
 * @source openweathermap.org
 **/

// pollution response
// list
// dt Date and time, Unix, UTC
// main
// main.aqi Air Quality Index. Possible values: 1, 2, 3, 4, 5. Where 1 = Good, 2 = Fair, 3 = Moderate, 4 = Poor, 5 = Very Poor.
// components
// components.co Сoncentration of CO (Carbon monoxide), μg/m3
// components.no Сoncentration of NO (Nitrogen monoxide), μg/m3
// components.no2 Сoncentration of NO2 (Nitrogen dioxide), μg/m3
// components.o3 Сoncentration of O3 (Ozone), μg/m3
// components.so2 Сoncentration of SO2 (Sulphur dioxide), μg/m3
// components.pm2_5 Сoncentration of PM2.5 (Fine particles matter), μg/m3
// components.pm10 Сoncentration of PM10 (Coarse particulate matter), μg/m3
// components.nh3 Сoncentration of NH3 (Ammonia), μg/m3 -->


Class OpenWeatherMap {

    private $apiKey = "321e61c9fe6752c436a074bbe75381fc";
    
    public function __construct()
    {
        return $this->apiKey;
    }

    public function getForecast()
    {
        return $this->sendRequest($googleApiUrl = "api.openweathermap.org/data/2.5/forecast?q=crediton&appid=" . $this->apiKey);
    }

    public function getAirPollution()
    {
        return $this->sendRequest($googleApiUrl = "api.openweathermap.org/data/2.5/air_pollution?lat=50.78&lon=-3.65&appid=" . $this->apiKey);
    }

    public function getAirPollutionForecast()
    {
        return $this->sendRequest($googleApiUrl = "api.openweathermap.org/data/2.5/air_pollution/forecast?lat=50.78&lon=-3.65&appid=" . $this->apiKey);
    }

    public function sendRequest($googleApiUrl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);

        if (preg_match('/wamp64|repositories/i', __DIR__) || !empty($_REQUEST['debug'])) {echo '<pre>'.str_repeat('=', 14)."\nPRINT_R DEBUG:\n".str_repeat('=', 14)."\n  FILE: ".__FILE__."\n  LINE: ".__LINE__."\n".str_repeat('=', 14)."\n".print_r(json_decode($response), true).'</pre>';}

        return $response;
    }
}

new OpenWeatherMap;
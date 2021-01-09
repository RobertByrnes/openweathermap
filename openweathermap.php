<?php

/**
 * @author Robert Byrnes
 * @created 31/12/2020
 * @source openweathermap.org
 **/

Class OpenWeatherMap {

    private $apiKey = "321e61c9fe6752c436a074bbe75381fc";
    private $city = "crediton";
    private $latitude = 50.78;
    private $longitude = -3.65;
    private $units = 'metric'; // If farenheit required change to imperial
    
    public function __construct()
    {
        return $this->apiKey;
    }


    /*
    lat, lon    required	Geographical coordinates (latitude, longitude)
    appid	    required	Your unique API key (you can always find it on your account page under the "API key" tab)
    exclude	    optional	By using this parameter you can exclude some parts of the weather data from the API response. 
    It should be a comma-delimited list (without spaces).
    Available values for exclude:
        current
        minutely
        hourly
        daily
        alerts
    */
    public function oneCall ()
    {
        return $this->sendRequest($url = 'https://api.openweathermap.org/data/2.5/onecall?lat='.$this->latitude.'&lon='.$this->longitude.'&exclude={part}&appid='.$this->apiKey);
    }

    public function currentWeather()
    {
        return $this->sendRequest($url = 'http:/api.openweathermap.org/data/2.5/weather?q='.$this->city.'&units='.$this->units.'&appid='.$this->apiKey);
    }

    public function getForecast()
    {
        return $this->sendRequest($url = 'http://api.openweathermap.org/data/2.5/forecast?q='.$this->city.'&units='.$this->units.'&appid='.$this->apiKey);
    }


    // air pollution response
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

    public function getAirPollution()
    {
        return $this->sendRequest($url = 'http://api.openweathermap.org/data/2.5/air_pollution?lat=50.78&lon=-3.65&units='.$this->units.'&appid='.$this->apiKey);
    }

    public function getAirPollutionForecast()
    {
        return $this->sendRequest($url = 'http://api.openweathermap.org/data/2.5/air_pollution/forecast?lat=50.78&lon=-3.65&units='.$this->units.'&appid='.$this->apiKey);
    }

    public function sendRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);

        if (preg_match('/wamp64|repositories/i', __DIR__) || !empty($_REQUEST['debug'])) {
            echo '<pre>'.str_repeat('=', 14)."\nPRINT_R DEBUG:\n".str_repeat('=', 14)."\n  FILE: "
            .__FILE__."\n  LINE: ".__LINE__."\n".str_repeat('=', 14)."\n".print_r(json_decode($response), true)
            .'</pre>';
        }

        return $response;
    }
}

new OpenWeatherMap;
<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weather;

    public function __construct(WeatherService $weather)
    {
        $this->weather = $weather;
    }

    public function index()
    {
        $countries = Country::all();

        $weatherData = [];

        foreach ($countries as $country) {

            if ($country->code == "ID") {

                $weather = $this->weather->getCurrentWeather(-6.2,106.8);

            } elseif ($country->code == "CN") {

                $weather = $this->weather->getCurrentWeather(31.2,121.5);

            } else {

                $weather = $this->weather->getCurrentWeather(40.7,-74.0);

            }

            $weatherData[] = [
    'country' => $country->name,
    'temperature' => $weather['current']['temperature_2m'] ?? 0,
    'rainfall' => $weather['current']['rain'] ?? 0,
    'wind' => $weather['current']['wind_speed_10m'] ?? 0
];
        }

        return view('weather.index',compact('weatherData'));
    }
}
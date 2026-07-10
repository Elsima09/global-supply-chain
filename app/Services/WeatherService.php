<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getCurrentWeather($latitude, $longitude)
    {
        try {
            $response = Http::timeout(8)->get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current' => 'temperature_2m,wind_speed_10m,rain'
                ]
            );

            return $response->json();

        } catch (\Exception $e) {
            return [
                'current' => [
                    'temperature_2m' => 0,
                    'wind_speed_10m' => 0,
                    'rain' => 0
                ]
            ];
        }
    }
}
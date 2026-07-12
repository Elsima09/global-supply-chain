<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\WeatherData;
use App\Services\WeatherService;


class UpdateWeatherData extends Command
{

    protected $signature = 'weather:update';

    protected $description = 'Update weather data all countries';


    public function handle(WeatherService $weatherService)
    {

        $countries = Country::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();


        foreach($countries as $country)
        {


            try{


                $weather = $weatherService->getCurrentWeather(
                    $country->latitude,
                    $country->longitude
                );


                WeatherData::updateOrCreate(

                    [
                        'country_id'=>$country->id
                    ],

                    [

                    'temperature'=>$weather['temperature'] ?? 0,

                    'rainfall'=>$weather['rainfall'] ?? 0,

                    'wind_speed'=>$weather['wind_speed'] ?? 0,

                    'storm_risk'=>$weather['storm_risk'] ?? 0

                    ]

                );


                $this->info(
                    "Updated ".$country->name
                );


            }
            catch(\Throwable $e){


                $this->error(
                    $country->name." failed"
                );


            }


        }


        return Command::SUCCESS;

    }


}
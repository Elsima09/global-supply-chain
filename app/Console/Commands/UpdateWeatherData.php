<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Country;
use App\Models\WeatherData;
use App\Services\WeatherService;


class UpdateWeatherData extends Command
{

    protected $signature = 'weather:update';


    protected $description = 'Update weather data from Open Meteo API';



    public function handle(WeatherService $weatherService)
    {


        $this->info("Starting weather update...");



        $countries = Country::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();



        foreach($countries as $country)
        {


            try
            {


                $response = $weatherService->getCurrentWeather(

                    $country->latitude,

                    $country->longitude

                );



                $current = $response['current'] ?? [];



                $temperature = $current['temperature_2m'] ?? 0;

                $rainfall = $current['rain'] ?? 0;

                $windSpeed = $current['wind_speed_10m'] ?? 0;



                /*
                |--------------------------------------------------------------------------
                | STORM RISK CALCULATION
                |--------------------------------------------------------------------------
                */


                if($rainfall > 10 || $windSpeed > 50)
                {

                    $stormRisk = 80;

                }
                elseif($rainfall > 5 || $windSpeed > 30)
                {

                    $stormRisk = 50;

                }
                else
                {

                    $stormRisk = 20;

                }




                WeatherData::updateOrCreate(

                    [

                        'country_id'=>$country->id

                    ],

                    [

                        'temperature'=>$temperature,

                        'rainfall'=>$rainfall,

                        'wind_speed'=>$windSpeed,

                        'storm_risk'=>$stormRisk

                    ]

                );



                $this->info(

                    "Updated : ".$country->name

                );


            }
            catch(\Throwable $e)
            {


                $this->error(

                    "Failed ".$country->name.
                    " : ".
                    $e->getMessage()

                );


            }


        }



        $this->info(
            "Weather update completed."
        );


        return Command::SUCCESS;


    }


}
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


        $countries = Country::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();



        foreach($countries as $country)
        {


            try {


                $data = $weatherService->getCurrentWeather(

                    $country->latitude,

                    $country->longitude

                );



                $current = $data['current'] ?? [];



                WeatherData::updateOrCreate(

                    [
                        'country_id'=>$country->id
                    ],

                    [

                        'temperature'=>
                            $current['temperature_2m'] ?? 0,


                        'rainfall'=>
                            $current['rain'] ?? 0,


                        'wind_speed'=>
                            $current['wind_speed_10m'] ?? 0,


                        /*
                        Storm Risk sederhana
                        berdasarkan kondisi cuaca
                        */

                        'storm_risk'=>

                            ($current['rain'] ?? 0) > 10
                            ? 70
                            :
                            (
                                ($current['wind_speed_10m'] ?? 0) > 40
                                ? 60
                                : 20
                            )

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
            "Weather update completed"
        );


        return Command::SUCCESS;

    }

}
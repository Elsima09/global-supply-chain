<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\EconomicData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class EconomicDataSeeder extends Seeder
{


    public function run(): void
    {


        /*
        |--------------------------------------------------------------------------
        | ISO 2 TO ISO 3
        |--------------------------------------------------------------------------
        */


        $library = new \League\ISO3166\ISO3166();


        $iso3=[];


        foreach($library->all() as $item){

            $iso3[$item['alpha2']] = $item['alpha3'];

        }





        $skipCountries=[

            'HM',
            'TF',
            'GU',
            'GF',
            'GI',
            'UM',
            'PN',
            'TK',
            'NU',
            'WF',
            'BV'

        ];




        foreach(Country::all() as $country)
        {


            echo "\nProcessing {$country->name}\n";



            if(in_array($country->code,$skipCountries)){

                echo "Skipped Territory\n";

                continue;

            }



            if(!isset($iso3[$country->code])){

                echo "Skipped ISO\n";

                continue;

            }



            $code=$iso3[$country->code];




            try {



                /*
                |--------------------------------------------------------------------------
                | GET 6 YEARS DATA
                |--------------------------------------------------------------------------
                */


                $gdp =
                $this->getHistory(
                    $code,
                    'NY.GDP.MKTP.CD'
                );


                $inflation =
                $this->getHistory(
                    $code,
                    'FP.CPI.TOTL.ZG'
                );


                $exports =
                $this->getHistory(
                    $code,
                    'NE.EXP.GNFS.CD'
                );


                $imports =
                $this->getHistory(
                    $code,
                    'NE.IMP.GNFS.CD'
                );




                /*
                |--------------------------------------------------------------------------
                | SAVE PER YEAR
                |--------------------------------------------------------------------------
                */


                foreach($gdp as $year=>$value)
                {


                    EconomicData::updateOrCreate(

                        [

                            'country_id'=>$country->id,

                            'year'=>$year

                        ],


                        [

                            'gdp'=>$value ?? 0,


                            'inflation'=>$inflation[$year] ?? 0,


                            'exports'=>$exports[$year] ?? 0,


                            'imports'=>$imports[$year] ?? 0

                        ]

                    );


                }



                echo "SUCCESS {$country->name}\n";



            }



            catch(\Throwable $e){


                echo "FAILED {$country->name} : ".$e->getMessage()."\n";


            }



        }


        echo "\nEconomic Seeder Finished\n";


    }








    /*
    |--------------------------------------------------------------------------
    | WORLD BANK HISTORY
    |--------------------------------------------------------------------------
    */


    private function getHistory($country,$indicator)
    {


        $cacheKey =
        "wb_history_{$country}_{$indicator}";



        return Cache::remember(

            $cacheKey,

            now()->addHours(24),


            function() use ($country,$indicator){



                try {


                    $response = Http::connectTimeout(5)
                    ->timeout(15)
                    ->get(

"https://api.worldbank.org/v2/country/{$country}/indicator/{$indicator}?date=2020:2025&format=json&per_page=100"

                    );



                    if(!$response->successful()){

                        return [];

                    }



                    $json=$response->json();



                    if(!isset($json[1])){

                        return [];

                    }



                    $result=[];



                    foreach($json[1] as $item){



                        if(
                            isset($item['value'])
                            &&
                            $item['value'] !== null
                        ){


                            $result[
                                $item['date']
                            ] =
                            $item['value'];


                        }


                    }



                    return $result;



                }


                catch(\Throwable $e){


                    return [];


                }



            }


        );


    }



}
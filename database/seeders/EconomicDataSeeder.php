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

        $iso3 = [];


        foreach($library->all() as $item){

            $iso3[$item['alpha2']] = $item['alpha3'];

        }



        $skipCountries = [

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



        $countries = Country::all();



        foreach($countries as $country)
        {


            echo "\nProcessing : {$country->name}\n";



            /*
            |--------------------------------------------------------------------------
            | SKIP SMALL TERRITORIES
            |--------------------------------------------------------------------------
            */


            if(in_array($country->code,$skipCountries)){


                echo "Skipped territory\n";

                continue;

            }




            /*
            |--------------------------------------------------------------------------
            | CHECK ISO
            |--------------------------------------------------------------------------
            */


            if(!isset($iso3[$country->code])){


                echo "Skipped ISO\n";

                continue;


            }



            $code = $iso3[$country->code];



            try {



                echo "GDP...\n";


                $gdp = $this->getIndicator(
                    $code,
                    'NY.GDP.MKTP.CD'
                );



                echo "Inflation...\n";


                $inflation = $this->getIndicator(
                    $code,
                    'FP.CPI.TOTL.ZG'
                );



                echo "Export...\n";


                $exports = $this->getIndicator(
                    $code,
                    'NE.EXP.GNFS.CD'
                );



                echo "Import...\n";


                $imports = $this->getIndicator(
                    $code,
                    'NE.IMP.GNFS.CD'
                );




                /*
                |--------------------------------------------------------------------------
                | DEFAULT VALUE
                |--------------------------------------------------------------------------
                */


                $gdp = $gdp ?? 0;

                $inflation = $inflation ?? 0;

                $exports = $exports ?? 0;

                $imports = $imports ?? 0;




                /*
                |--------------------------------------------------------------------------
                | SAVE
                |--------------------------------------------------------------------------
                */


                EconomicData::updateOrCreate(

                    [

                        'country_id'=>$country->id,

                        'year'=>2025

                    ],

                    [

                        'gdp'=>$gdp,

                        'inflation'=>$inflation,

                        'exports'=>$exports,

                        'imports'=>$imports

                    ]

                );



                echo "SUCCESS {$country->name}\n";



            }

            catch(\Throwable $e){


                echo "FAILED {$country->name} : ".$e->getMessage()."\n";


                /*
                tetap insert kosong
                */

                EconomicData::updateOrCreate(

                    [

                        'country_id'=>$country->id,

                        'year'=>2025

                    ],

                    [

                        'gdp'=>0,

                        'inflation'=>0,

                        'exports'=>0,

                        'imports'=>0

                    ]

                );


            }


        }



        echo "\nEconomic Data Finished\n";


    }





    /*
    |--------------------------------------------------------------------------
    | WORLD BANK API
    |--------------------------------------------------------------------------
    */


    private function getIndicator($country,$indicator)
    {


        $cacheKey = "worldbank_{$country}_{$indicator}";



        return Cache::remember(

            $cacheKey,

            now()->addHours(24),


            function() use ($country,$indicator){


                try {



                    $response = Http::connectTimeout(3)
                        ->timeout(5)
                        ->get(

                            "https://api.worldbank.org/v2/country/{$country}/indicator/{$indicator}?format=json"

                        );




                    if(!$response->successful()){

                        return 0;

                    }



                    $data = $response->json();



                    if(!isset($data[1])){

                        return 0;

                    }




                    foreach($data[1] as $item){



                        if(

                            isset($item['value'])

                            &&

                            $item['value'] !== null

                        ){

                            return $item['value'];

                        }


                    }



                }


                catch(\Throwable $e){


                    return 0;


                }



                return 0;


            }


        );


    }



}
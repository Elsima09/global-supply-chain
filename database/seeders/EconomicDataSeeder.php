<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\EconomicData;
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



        $countries = Country::all();



        foreach($countries as $country)
        {


            if(!isset($iso3[$country->code])){

                echo "Skip ISO {$country->name}\n";

                continue;

            }



            $code = $iso3[$country->code];



            try {


                /*
                |--------------------------------------------------------------------------
                | GDP
                |--------------------------------------------------------------------------
                */


                $gdp = $this->getIndicator(
                    $code,
                    'NY.GDP.MKTP.CD'
                );



                /*
                |--------------------------------------------------------------------------
                | INFLATION
                |--------------------------------------------------------------------------
                */


                $inflation = $this->getIndicator(
                    $code,
                    'FP.CPI.TOTL.ZG'
                );



                /*
                |--------------------------------------------------------------------------
                | EXPORT
                |--------------------------------------------------------------------------
                */


                $exports = $this->getIndicator(
                    $code,
                    'NE.EXP.GNFS.CD'
                );



                /*
                |--------------------------------------------------------------------------
                | IMPORT
                |--------------------------------------------------------------------------
                */


                $imports = $this->getIndicator(
                    $code,
                    'NE.IMP.GNFS.CD'
                );




                /*
                |--------------------------------------------------------------------------
                | DEFAULT VALUE
                |--------------------------------------------------------------------------
                */


                if($gdp === null){

                    $gdp = 0;

                }


                if($inflation === null){

                    $inflation = 0;

                }


                if($exports === null){

                    $exports = 0;

                }


                if($imports === null){

                    $imports = 0;

                }




                /*
                |--------------------------------------------------------------------------
                | SAVE DATA
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



                echo "Inserted {$country->name}\n";



            }


            catch(\Exception $e){


                echo "Failed {$country->name}: ".$e->getMessage()."\n";


            }



        }



    }




    /*
    |--------------------------------------------------------------------------
    | WORLD BANK API
    |--------------------------------------------------------------------------
    */


    private function getIndicator($country,$indicator)
{

    try {


        $response = Http::timeout(60)
            ->retry(3,2000)
            ->get(
                "https://api.worldbank.org/v2/country/{$country}/indicator/{$indicator}?format=json"
            );


        $data = $response->json();



        if(!isset($data[1])){

            return null;

        }



        foreach($data[1] as $item){


            if(
                isset($item['value']) &&
                $item['value'] !== null
            ){

                return $item['value'];

            }


        }



    }
    catch(\Exception $e){

        return null;

    }


    return null;


}


}
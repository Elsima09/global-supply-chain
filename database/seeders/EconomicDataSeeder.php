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
        | ISO 2 -> ISO 3
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
) ?? 0;



                /*
                |--------------------------------------------------------------------------
                | IMPORT
                |--------------------------------------------------------------------------
                */

$imports = $this->getIndicator(
    $code,
    'NE.IMP.GNFS.CD'
) ?? 0;



                /*
                |--------------------------------------------------------------------------
                | Jika GDP tidak ada skip
                |--------------------------------------------------------------------------
                */

                if($gdp === null){

                    echo "No GDP {$country->name}\n";

                    continue;

                }




                EconomicData::updateOrCreate(

                    [
                        'country_id'=>$country->id,
                        'year'=>2025
                    ],


                    [

                        'gdp'=>$gdp ?? 0,

                        'inflation'=>$inflation ?? 0,

                        'exports'=>$exports ?? 0,

                        'imports'=>$imports ?? 0

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
    | GET WORLD BANK INDICATOR
    |--------------------------------------------------------------------------
    */

private function getIndicator($country,$indicator)
{

    try {


        $response = Http::timeout(10)
            ->get(
                "https://api.worldbank.org/v2/country/{$country}/indicator/{$indicator}?format=json"
            );


        $data = $response->json();



        if(
            isset($data[1][0]['value'])
            &&
            $data[1][0]['value'] !== null
        ){

            return $data[1][0]['value'];

        }


    }
    catch(\Exception $e){

        return null;

    }


    return null;

}


}
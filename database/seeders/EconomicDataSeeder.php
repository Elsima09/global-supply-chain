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
        | Ambil semua data World Bank sekaligus
        |--------------------------------------------------------------------------
        */


        echo "Downloading GDP...\n";

        $gdp = $this->getWorldBankIndicator(
            'NY.GDP.MKTP.CD'
        );


        echo "Downloading Inflation...\n";

        $inflation = $this->getWorldBankIndicator(
            'FP.CPI.TOTL.ZG'
        );


        echo "Downloading Export...\n";

        $exports = $this->getWorldBankIndicator(
            'NE.EXP.GNFS.CD'
        );


        echo "Downloading Import...\n";

        $imports = $this->getWorldBankIndicator(
            'NE.IMP.GNFS.CD'
        );



        echo "Saving countries...\n";



        foreach(Country::all() as $country)
        {


            $code = $country->code;



            /*
            |--------------------------------------------------------------------------
            | ISO 2 ke ISO 3
            |--------------------------------------------------------------------------
            */

            $iso3 = $this->convertISO($code);



            if(!$iso3){

                echo "Skip {$country->name}\n";

                continue;

            }




            /*
            |--------------------------------------------------------------------------
            | Tahun 2020-2025
            |--------------------------------------------------------------------------
            */


            for($year=2020;$year<=2025;$year++)
            {


                EconomicData::updateOrCreate(

                    [

                        'country_id'=>$country->id,

                        'year'=>$year

                    ],


                    [

                        'gdp'=>$gdp[$iso3][$year] ?? 0,

                        'inflation'=>$inflation[$iso3][$year] ?? 0,

                        'exports'=>$exports[$iso3][$year] ?? 0,

                        'imports'=>$imports[$iso3][$year] ?? 0

                    ]

                );


            }



            echo "Saved {$country->name}\n";


        }



        echo "Economic data finished\n";


    }






    private function getWorldBankIndicator($indicator)
    {


        $result=[];


        try {


            $response = Http::timeout(60)
            ->get(

"https://api.worldbank.org/v2/country/all/indicator/{$indicator}?date=2020:2025&format=json&per_page=20000"

            );



            $data=$response->json();



            if(!isset($data[1])){

                return [];

            }




            foreach($data[1] as $item)
            {


                if(
                    isset($item['value'])
                    &&
                    $item['value'] !== null
                )
                {


                    $result[
                        $item['countryiso3code']
                    ][
                        $item['date']
                    ]
                    =
                    $item['value'];


                }


            }



        }
        catch(\Throwable $e){


            echo $e->getMessage();


        }



        return $result;


    }







    private function convertISO($code)
    {


        $library =
        new \League\ISO3166\ISO3166();



        foreach($library->all() as $item)
        {

            if($item['alpha2']==$code)
            {

                return $item['alpha3'];

            }

        }



        return null;


    }



}
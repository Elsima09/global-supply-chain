<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Country;
use App\Models\RiskScore;
use App\Models\RiskHistory;

use App\Services\RiskService;


class CalculateRiskCommand extends Command
{

    protected $signature = 'risk:calculate';


    protected $description = 'Calculate all country supply chain risks';



    public function handle(RiskService $riskService)
    {


        $this->info("Starting risk calculation...");



        $countries = Country::all();



        foreach($countries as $country)
        {


            try {


                /*
                |--------------------------------------------------------------------------
                | CALCULATE RISK
                |--------------------------------------------------------------------------
                */


                $data = $riskService
                    ->calculateByCountry($country);





                /*
                |--------------------------------------------------------------------------
                | UPDATE CURRENT RISK SCORE
                |--------------------------------------------------------------------------
                */


                RiskScore::updateOrCreate(

                    [

                        'country_id'=>$country->id

                    ],


                    [

                        'weather_score'=>$data['weather_score'],

                        'economic_score'=>$data['economic_score'],

                        'inflation_score'=>$data['inflation_score'],

                        'currency_score'=>$data['currency_score'],

                        'news_score'=>$data['news_score'],

                        'logistics_score'=>$data['logistics_score'],

                        'total_score'=>$data['total_score'],

                        'risk_level'=>$data['risk_level']

                    ]

                );





                /*
                |--------------------------------------------------------------------------
                | SAVE HISTORY
                |--------------------------------------------------------------------------
                */


                RiskHistory::create(

                    [

                        'country_id'=>$country->id,


                        'risk_score'=>$data['total_score'],


                        'risk_level'=>$data['risk_level'],


                        'recorded_at'=>now()

                    ]

                );






                $this->info(

                    "Updated : ".$country->name.
                    " | Score : ".$data['total_score']

                );



            }


            catch(\Throwable $e){


                $this->error(

                    "Failed ".$country->name.
                    " : ".
                    $e->getMessage()

                );


            }



        }



        $this->info(
            "Risk calculation completed."
        );



        return Command::SUCCESS;


    }


}
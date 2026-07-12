<?php

namespace App\Services;

use App\Models\WeatherData;
use App\Models\EconomicData;
use App\Models\ExchangeRate;
use App\Models\SentimentResult;
use App\Services\LogisticsRiskService;


class RiskService
{


    /*
    |--------------------------------------------------------------------------
    | TOTAL RISK CALCULATION
    |--------------------------------------------------------------------------
    */

    public function calculate(
        $weather,
        $economic,
        $currency,
        $sentiment,
        $logistics
    )
    {


        $score =

            ($weather * 0.20) +

            ($economic * 0.25) +

            ($currency * 0.15) +

            ($sentiment * 0.15) +

            ($logistics * 0.25);



        return round($score);


    }





    /*
    |--------------------------------------------------------------------------
    | RISK LEVEL
    |--------------------------------------------------------------------------
    */

    public function level($score)
    {


        if($score >= 50){

            return "High";

        }


        elseif($score >= 30){

            return "Medium";

        }


        return "Low";


    }





    /*
    |--------------------------------------------------------------------------
    | CALCULATE COUNTRY RISK
    |--------------------------------------------------------------------------
    */

    public function calculateByCountry($country)
    {



        /*
        |--------------------------------------------------------------------------
        | WEATHER RISK
        |--------------------------------------------------------------------------
        */


        $weather = WeatherData::where(
            'country_id',
            $country->id
        )
        ->latest()
        ->first();



        if($weather){


            $weatherRisk = $weather->storm_risk ?? 40;


        }
        else{


            $weatherRisk = 40;


        }





        /*
        |--------------------------------------------------------------------------
        | ECONOMIC RISK
        |--------------------------------------------------------------------------
        */


        $economic =
        EconomicData::where(
            'country_id',
            $country->id
        )
        ->latest('year')
        ->first();



        $inflationScore = 40;



        if($economic)
        {


            $gdp =
            $economic->gdp ?? 0;


            $inflation =
            $economic->inflation ?? 0;


            $export =
            $economic->exports ?? 0;


            $import =
            $economic->imports ?? 0;




            /*
            GDP RISK
            */

            if($gdp >= 1000000000000){

                $gdpScore = 15;

            }

            elseif($gdp >= 100000000000){

                $gdpScore = 30;

            }

            elseif($gdp >= 10000000000){

                $gdpScore = 50;

            }

            else{

                $gdpScore = 70;

            }





            /*
            Inflation Risk
            */


            if($inflation >= 10){

                $inflationScore = 90;

            }

            elseif($inflation >= 5){

                $inflationScore = 60;

            }

            elseif($inflation >= 3){

                $inflationScore = 40;

            }

            else{

                $inflationScore = 20;

            }






            /*
            Trade Balance
            */


            if($export > 0 && $import > 0)
            {


                $trade =
                $export - $import;



                if($trade >= 0){

                    $tradeScore = 20;

                }

                else{

                    $tradeScore = 70;

                }


            }
            else{


                $tradeScore = 50;


            }




            $economicScore = round(

                (
                    $gdpScore +
                    $inflationScore +
                    $tradeScore
                )
                /
                3

            );



        }
        else
        {


            $economicScore = 70;


        }





        /*
        |--------------------------------------------------------------------------
        | CURRENCY RISK
        |--------------------------------------------------------------------------
        */


        $rate = ExchangeRate::where(

            'currency_code',

            $country->currency_code

        )
        ->value('rate');



        if(!$rate){


            $currencyRisk = 50;


        }

        else{


            /*
            Semakin tidak stabil kurs
            */

            if($rate >= 15000){

                $currencyRisk = 70;

            }

            elseif($rate >= 5000){

                $currencyRisk = 50;

            }

            elseif($rate >= 1000){

                $currencyRisk = 30;

            }

            else{

                $currencyRisk = 20;

            }


        }






        /*
        |--------------------------------------------------------------------------
        | NEWS SENTIMENT
        |--------------------------------------------------------------------------
        */


        $negative =
        SentimentResult::where(
            'sentiment',
            'Negative'
        )
        ->count();



        $total =
        SentimentResult::count();



        if($total > 0)
        {


            $newsRisk =
            round(
                ($negative/$total)*100
            );


        }

        else
        {


            $newsRisk = 30;


        }







        /*
        |--------------------------------------------------------------------------
        | LOGISTICS
        |--------------------------------------------------------------------------
        */


        $logisticsRisk =
        app(LogisticsRiskService::class)
        ->calculate($country);







        /*
        |--------------------------------------------------------------------------
        | FINAL SCORE
        |--------------------------------------------------------------------------
        */


        $totalScore =
        $this->calculate(

            $weatherRisk,

            $economicScore,

            $currencyRisk,

            $newsRisk,

            $logisticsRisk

        );







        return [


            'weather_score'=>$weatherRisk,


            'economic_score'=>$economicScore,


            'inflation_score'=>$inflationScore,


            'currency_score'=>$currencyRisk,


            'news_score'=>$newsRisk,


            'logistics_score'=>$logisticsRisk,


            'total_score'=>$totalScore,


            'risk_level'=>$this->level($totalScore)


        ];



    }


}
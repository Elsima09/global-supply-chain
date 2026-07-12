<?php

namespace App\Services;

use App\Models\TransportHistory;

class TransportPredictionService
{

    public function predict($portIds)
    {

        /*
        |--------------------------------------------------------------------------
        | AMBIL 7 DATA TERAKHIR
        |--------------------------------------------------------------------------
        */

        $history = TransportHistory::whereIn(
                'port_id',
                $portIds
            )
            ->orderByDesc('created_at')
            ->limit(7)
            ->get()
            ->sortBy('created_at')
            ->values();



        if($history->count()==0){

            return [

                'score'=>0,

                'level'=>'Unknown',

                'trend'=>'No Data',

                'forecast'=>[
                    0,0,0,0,0,0,0
                ]

            ];

        }



        /*
        |--------------------------------------------------------------------------
        | HITUNG SCORE DASAR
        |--------------------------------------------------------------------------
        */


        $scores = $history
            ->pluck('risk_score')
            ->map(fn($value)=>intval($value));



        $average = round(
            $scores->avg()
        );



        $first = $scores->first();

        $last = $scores->last();



        $difference = $last - $first;



        /*
        |--------------------------------------------------------------------------
        | ANALISIS TREND
        |--------------------------------------------------------------------------
        */


        if($difference > 5){

            $trend="Increasing";

        }
        elseif($difference < -5){

            $trend="Decreasing";

        }
        else{

            $trend="Stable";

        }



        /*
        |--------------------------------------------------------------------------
        | PREDICTION SCORE
        |--------------------------------------------------------------------------
        */


        $predictionScore = $average;



        if($trend=="Increasing"){

            $predictionScore += 10;

        }


        elseif($trend=="Decreasing"){

            $predictionScore -= 10;

        }



        $predictionScore = max(
            0,
            min(
                100,
                $predictionScore
            )
        );




        /*
        |--------------------------------------------------------------------------
        | LEVEL
        |--------------------------------------------------------------------------
        */


        if($predictionScore >=70){

            $level="High";

        }
        elseif($predictionScore >=40){

            $level="Medium";

        }
        else{

            $level="Low";

        }




        /*
        |--------------------------------------------------------------------------
        | FORECAST 7 HARI
        |--------------------------------------------------------------------------
        */


        $forecast=[];


        $current=$predictionScore;



        for($i=1;$i<=7;$i++){


            if($trend=="Increasing"){

                $current += rand(2,5);

            }


            elseif($trend=="Decreasing"){

                $current -= rand(2,5);

            }


            else{

                $current += rand(-2,2);

            }



            $current=max(
                0,
                min(
                    100,
                    $current
                )
            );


            $forecast[]=$current;


        }




        return [

            'score'=>$predictionScore,

            'level'=>$level,

            'trend'=>$trend,

            'forecast'=>$forecast

        ];

    }

}
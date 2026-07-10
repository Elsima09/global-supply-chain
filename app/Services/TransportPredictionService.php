<?php

namespace App\Services;

use App\Models\TransportHistory;

class TransportPredictionService
{

    public function predict($portIds)
    {


        $history = TransportHistory::whereIn(
            'port_id',
            $portIds
        )
        ->orderBy('created_at')
        ->latest()
        ->limit(7)
        ->get()
        ->reverse();



if($history->count()==0){

    return [

        'score' => 0,

        'level' => 'Unknown',

        'trend' => 'No Data',

        'forecast' => [0,0,0,0,0,0,0]

    ];

}



        $scores = $history
            ->pluck('risk_score')
            ->values();



        // rata-rata risiko

        $average = round(
            $scores->avg()
        );



        // ambil data awal dan akhir

        $first = $scores->first();

        $last = $scores->last();



        $difference = $last - $first;



        if($difference >= 10){

            $trend = "Increasing";

            $predictionScore = $average + 10;


        }
        elseif($difference <= -10){

            $trend = "Decreasing";

            $predictionScore = $average - 10;


        }
        else{

            $trend = "Stable";

            $predictionScore = $average;

        }



        // batas nilai

        $predictionScore = max(
            0,
            min(
                100,
                $predictionScore
            )
        );




        if($predictionScore >=70){

            $level="High";

        }
        elseif($predictionScore>=40){

            $level="Medium";

        }
        else{

            $level="Low";

        }




$forecast = [];


$current = $predictionScore;


for($i = 1; $i <= 7; $i++){

    if($trend == "Increasing"){

        $current += 3;

    }
    elseif($trend == "Decreasing"){

        $current -= 3;

    }


    $current = max(
        0,
        min(100,$current)
    );


    $forecast[] = $current;

}



return [

    'score'=>$predictionScore,

    'level'=>$level,

    'trend'=>$trend,

    'forecast'=>$forecast

];


    }


}
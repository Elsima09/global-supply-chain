<?php

namespace App\Services;

use App\Models\Port;
use App\Models\TransportHistory;


class LogisticsRiskService
{

    public function calculate($country = null)
    {


        /*
        |--------------------------------------------------------------------------
        | AMBIL PORT NEGARA
        |--------------------------------------------------------------------------
        */


        $query = Port::query();


        if($country){

            $query->where(
                'country_id',
                $country->id
            );

        }



        $ports = $query->get();



        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK ADA PORT
        |--------------------------------------------------------------------------
        */


        if($ports->count()==0){

            return 70;

        }





        /*
        |--------------------------------------------------------------------------
        | 1. PORT AVAILABILITY SCORE
        |--------------------------------------------------------------------------
        */


        $activePorts = $ports
            ->where('status','active')
            ->count();



        $totalPorts = $ports->count();



        $availabilityRisk = 100 -
        (
            ($activePorts / $totalPorts)
            *100
        );





        /*
        |--------------------------------------------------------------------------
        | 2. PORT DIVERSITY RISK
        |--------------------------------------------------------------------------
        */


        if($totalPorts >= 5){

            $portRisk = 20;

        }
        elseif($totalPorts >=3){

            $portRisk = 35;

        }
        else{

            $portRisk = 60;

        }





        /*
        |--------------------------------------------------------------------------
        | 3. TRANSPORT HISTORY
        |--------------------------------------------------------------------------
        */


        $historyRisk = 40;



        if($country){


            $history = TransportHistory::whereHas(

                'port',

                function($q) use ($country){

                    $q->where(
                        'country_id',
                        $country->id
                    );

                }

            )
            ->avg('risk_score');



            if($history){

                $historyRisk = $history;

            }


        }




        /*
        |--------------------------------------------------------------------------
        | FINAL LOGISTICS SCORE
        |--------------------------------------------------------------------------
        */


        $finalScore =

        (

            $availabilityRisk * 0.35

        )

        +

        (

            $portRisk * 0.35

        )

        +

        (

            $historyRisk * 0.30

        );




        return round($finalScore);



    }

}
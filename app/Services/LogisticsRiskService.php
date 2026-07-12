<?php

namespace App\Services;

use App\Models\Port;
use App\Models\TransportHistory;


class LogisticsRiskService
{

    public function calculate($country=null)
    {


        /*
        |--------------------------------------------------------------------------
        | Ambil Port
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



        if($ports->count()==0){

            return 50;

        }





        /*
        |--------------------------------------------------------------------------
        | 1. PORT AVAILABILITY
        |--------------------------------------------------------------------------
        */


        $portRisk = 0;



        foreach($ports as $port)
        {


            if($port->status == "active"){

                $portRisk += 20;

            }

            else{

                $portRisk += 60;

            }


        }



        $portRisk = $portRisk / $ports->count();





        /*
        |--------------------------------------------------------------------------
        | 2. TRANSPORT HISTORY
        |--------------------------------------------------------------------------
        */


        $historyRisk = 30;



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
        | FINAL LOGISTICS RISK
        |--------------------------------------------------------------------------
        */


        $risk = (

            ($portRisk * 0.5)

            +

            ($historyRisk * 0.5)

        );



        return round($risk);



    }


}
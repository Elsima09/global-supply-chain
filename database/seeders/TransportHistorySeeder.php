<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;
use App\Models\TransportHistory;

class TransportHistorySeeder extends Seeder
{

    public function run()
    {

        $ports = Port::all();


        foreach($ports as $port){


            for($i = 6; $i >= 0; $i--){


                TransportHistory::create([

                    'port_id' => $port->id,

                    'risk_score' => rand(
                        max(0,$port->transport_risk-20),
                        min(100,$port->transport_risk+20)
                    ),

                    'delay_hours' => rand(
                        1,
                        24
                    ),

                    'capacity' => rand(
                        60,
                        100
                    ),

                    'congestion' => [
                        'Low',
                        'Medium',
                        'High'
                    ][rand(0,2)],


                    'created_at'=>now()->subDays($i),

                    'updated_at'=>now()->subDays($i)

                ]);


            }


        }

    }

}
<?php

namespace App\Services;

use App\Models\Port;

class LogisticsRiskService
{
    public function calculate($country = null)
    {

        $query = Port::query();

        if($country){

            $query->where('country',$country->name);

        }

        $average = $query->avg('transport_risk');

        if($average === null){

            return 20;

        }

        return round($average);

    }
}
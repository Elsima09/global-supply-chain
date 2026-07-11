<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\RiskScore;
use App\Services\RiskService;

class CalculateRiskCommand extends Command
{
    protected $signature = 'risk:calculate';

    protected $description = 'Calculate all country supply chain risks';

    public function handle(RiskService $riskService)
    {

        $countries = Country::all();

        foreach($countries as $country){

            $data = $riskService->calculateByCountry($country);

            RiskScore::updateOrCreate(
                [
                    'country_id'=>$country->id
                ],
                $data
            );

            $this->info(
                "Updated ".$country->name
            );
        }


        $this->info("Risk calculation completed.");

    }
}
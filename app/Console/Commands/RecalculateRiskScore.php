<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\RiskScore;
use App\Services\RiskService;

class RecalculateRiskScore extends Command
{
    protected $signature = 'risk:recalculate';

    protected $description = 'Recalculate all country risk scores';

    public function handle(RiskService $riskService)
    {

        $countries = Country::all();

        foreach($countries as $country)
        {

            $score = $riskService->calculateByCountry($country);

            RiskScore::updateOrCreate(
                [
                    'country_id'=>$country->id
                ],
                $score
            );

            $this->info(
                "Updated ".$country->name
            );

        }


        $this->info(
            "Risk calculation completed"
        );


        return Command::SUCCESS;
    }
}
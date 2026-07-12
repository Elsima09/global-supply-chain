<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\RiskScore;
use App\Services\RiskService;

class RiskScoreSeeder extends Seeder
{
    public function run(): void
    {
        $riskService = app(RiskService::class);

        foreach (Country::all() as $country) {

            $result = $riskService->calculateByCountry($country);

            RiskScore::updateOrCreate(

                [
                    'country_id' => $country->id,
                ],

                [
                    'weather_score'   => $result['weather_score'],
                    'economic_score'  => $result['economic_score'],
                    'inflation_score' => $result['inflation_score'],
                    'currency_score'  => $result['currency_score'],
                    'news_score'      => $result['news_score'],
                    'logistics_score' => $result['logistics_score'],
                    'total_score'     => $result['total_score'],
                    'risk_level'      => $result['risk_level'],
                ]

            );

            $this->command->info("Updated {$country->name}");
        }

        $this->command->info('====================================');
        $this->command->info('Risk Score Successfully Generated');
        $this->command->info('====================================');
    }
}
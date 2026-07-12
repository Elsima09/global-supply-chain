<?php

namespace App\Services;

use App\Models\WeatherData;
use App\Models\EconomicData;
use App\Models\ExchangeRate;
use App\Models\SentimentResult;
use App\Services\LogisticsRiskService;

class RiskService
{
    public function calculate(
        $weather,
        $economic,
        $currency,
        $sentiment,
        $logistics
    ) {

        $score =
            ($weather * 0.25) +
            ($economic * 0.20) +
            ($currency * 0.15) +
            ($sentiment * 0.15) +
            ($logistics * 0.25);

        return round($score);
    }

    public function level($score)
    {
        if ($score >= 60) {
            return "High";
        }

        if ($score >= 35) {
            return "Medium";
        }

        return "Low";
    }

    public function calculateByCountry($country)
    {

        /*
        |--------------------------------------------------------------------------
        | WEATHER
        |--------------------------------------------------------------------------
        */

        $weather = WeatherData::where('country_id', $country->id)
            ->latest()
            ->first();

        if ($weather) {

            $weatherRisk = $weather->storm_risk;

        } else {

            $weatherRisk = 40;

        }


        /*
        |--------------------------------------------------------------------------
        | ECONOMIC
        |--------------------------------------------------------------------------
        */

        $economic = EconomicData::where('country_id', $country->id)
            ->latest('year')
            ->first();

        $inflationScore = 40;

        if ($economic) {

            $gdp = $economic->gdp ?? 0;
            $inflation = $economic->inflation ?? 0;
            $export = $economic->exports ?? 0;
            $import = $economic->imports ?? 0;

            // GDP

            if ($gdp >= 10000000000000) {

                $gdpScore = 10;

            } elseif ($gdp >= 1000000000000) {

                $gdpScore = 20;

            } elseif ($gdp >= 100000000000) {

                $gdpScore = 40;

            } else {

                $gdpScore = 70;

            }

            // Inflation

            if ($inflation >= 10) {

                $inflationScore = 90;

            } elseif ($inflation >= 5) {

                $inflationScore = 60;

            } elseif ($inflation >= 3) {

                $inflationScore = 40;

            } else {

                $inflationScore = 20;

            }

            // Trade Balance

            if (($export > 0) && ($import > 0)) {

                $trade = $export - $import;

                if ($trade > 0) {

                    $tradeScore = 20;

                } else {

                    $tradeScore = 60;

                }

            } else {

                $tradeScore = 40;

            }

            $economicScore = round(
                ($gdpScore + $inflationScore + $tradeScore) / 3
            );

        } else {

            $economicScore = 70;

        }


        /*
        |--------------------------------------------------------------------------
        | CURRENCY
        |--------------------------------------------------------------------------
        */

        $rate = ExchangeRate::where(
            'currency_code',
            $country->currency_code
        )->value('rate');

        if (!$rate) {

            $currencyRisk = 50;

        } else {

            if ($rate >= 10000) {

                $currencyRisk = 80;

            } elseif ($rate >= 1000) {

                $currencyRisk = 50;

            } elseif ($rate >= 100) {

                $currencyRisk = 30;

            } else {

                $currencyRisk = 20;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | NEWS
        |--------------------------------------------------------------------------
        | SentimentResult TIDAK memiliki country_id
        |--------------------------------------------------------------------------
        */

        $negative = SentimentResult::where(
            'sentiment',
            'Negative'
        )->count();

        $total = SentimentResult::count();

        if ($total > 0) {

            $newsRisk = round(
                ($negative / $total) * 100
            );

        } else {

            $newsRisk = 30;

        }


        /*
        |--------------------------------------------------------------------------
        | LOGISTICS
        |--------------------------------------------------------------------------
        */

        $logisticsRisk = app(LogisticsRiskService::class)
            ->calculate($country);


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalScore = $this->calculate(
            $weatherRisk,
            $economicScore,
            $currencyRisk,
            $newsRisk,
            $logisticsRisk
        );

        return [

            'weather_score'    => round($weatherRisk),

            'economic_score'   => round($economicScore),

            'inflation_score'  => round($inflationScore),

            'currency_score'   => round($currencyRisk),

            'news_score'       => round($newsRisk),

            'logistics_score'  => round($logisticsRisk),

            'total_score'      => $totalScore,

            'risk_level'       => $this->level($totalScore)

        ];
    }
}
<?php

namespace App\Services;


use App\Models\WeatherData;
use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\SentimentResult;

class RiskService
{
    public function calculate($weather, $inflation, $currency, $sentiment)
{
    $score =
        ($weather * 0.30) +
        ($inflation * 0.20) +
        ($sentiment * 0.40) +
        ($currency * 0.10);

    return round($score, 2);
}

    public function level($score)
    {
        if($score>=70){
            return "High";
        }

        if($score>=40){
            return "Medium";
        }

        return "Low";
    }

    public function calculateAll()
{
    $weatherRisk = WeatherData::avg('storm_risk') ?? 55;

    $inflationRisk = Country::avg('inflation_rate') ?? 5;

    $newsRisk = SentimentResult::where(
        'sentiment',
        'Negative'
    )->count() * 10;

    $newsRisk = min($newsRisk, 100);

    $idrRate = ExchangeRate::where(
        'currency_code',
        'IDR'
    )->value('rate') ?? 0;

    if ($idrRate > 16000) {
        $currencyRisk = 80;
    } elseif ($idrRate > 15000) {
        $currencyRisk = 60;
    } elseif ($idrRate > 10000) {
        $currencyRisk = 40;
    } else {
        $currencyRisk = 20;
    }

    $riskScore = $this->calculate(
        $weatherRisk,
        $inflationRisk,
        $currencyRisk,
        $newsRisk
    );

    $riskLevel = $this->level($riskScore);

    return [
        'weatherRisk' => $weatherRisk,
        'inflationRisk' => $inflationRisk,
        'currencyRisk' => $currencyRisk,
        'newsRisk' => $newsRisk,
        'riskScore' => $riskScore,
        'riskLevel' => $riskLevel
    ];
}

public function calculateByCountry($country)
{
    $weatherRisk = WeatherData::where(
        'country_id',
        $country->id
    )->latest()->value('storm_risk') ?? 30;

    $inflationRisk = $country->inflation_rate ?? 5;

    $newsRisk = SentimentResult::where(
        'sentiment',
        'Negative'
    )->count() * 10;

    $newsRisk = min($newsRisk, 100);

    $rate = ExchangeRate::where(
        'currency_code',
        $country->currency_code
    )->value('rate') ?? 1;

    $currencyRisk = min(log10($rate) * 20, 100);

    $riskScore = $this->calculate(
        $weatherRisk,
        $inflationRisk,
        $currencyRisk,
        $newsRisk
    );

    return [
        'weather_score' => round($weatherRisk),
        'inflation_score' => round($inflationRisk),
        'currency_score' => round($currencyRisk),
        'news_score' => round($newsRisk),
        'total_score' => round($riskScore),
        'risk_level' => $this->level($riskScore)
    ];
}
}
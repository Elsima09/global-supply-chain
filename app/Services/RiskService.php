<?php

namespace App\Services;


use App\Models\WeatherData;
use App\Models\Country;
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
)
{

    $score =
        ($weather * 0.25) +
        ($economic * 0.20) +
        ($currency * 0.15) +
        ($sentiment * 0.15) +
        ($logistics * 0.25);

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
    $weatherRisk = WeatherData::avg('storm_risk');


if($weatherRisk === null){

    $weatherRisk = 50;

}

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
)
->orderByDesc('created_at')
->value('storm_risk');


if($weatherRisk === null){

    $weatherRisk = 30;

}

    $inflation = $country->inflation_rate ?? 5;


// normalisasi inflasi menjadi 0-100

if($inflation >= 10){

    $inflationRisk = 100;

}elseif($inflation >= 7){

    $inflationRisk = 80;

}elseif($inflation >= 5){

    $inflationRisk = 60;

}elseif($inflation >= 3){

    $inflationRisk = 40;

}else{

    $inflationRisk = 20;

}

$economicScore = $inflationRisk;


$gdp = $country->gdp ?? 0;


if($gdp < 100000000000){

    $economicScore += 40;

}
elseif($gdp < 500000000000){

    $economicScore += 20;

}

$economicScore = min($economicScore,100);

$totalNews = SentimentResult::count();


$negativeNews = SentimentResult::where(
    'sentiment',
    'Negative'
)->count();


if($totalNews > 0){

    $newsRisk = ($negativeNews / $totalNews) * 100;

}else{

    $newsRisk = 20;

}


$newsRisk = round($newsRisk);

    $rate = ExchangeRate::where(
        'currency_code',
        $country->currency_code
    )->value('rate') ?? 1;

    if($rate > 15000){

    $currencyRisk = 80;

}elseif($rate > 10000){

    $currencyRisk = 60;

}elseif($rate > 5000){

    $currencyRisk = 40;

}else{

    $currencyRisk = 20;

}
$logisticsRisk = app(LogisticsRiskService::class)
    ->calculate($country);

    $riskScore = $this->calculate(
    $weatherRisk,
    $economicScore,
    $currencyRisk,
    $newsRisk,
    $logisticsRisk
);

    return [

    'weather_score'   => round($weatherRisk),

    'economic_score'  => round($economicScore),

    'inflation_score' => round($inflationRisk),

    'currency_score'  => round($currencyRisk),

    'news_score'      => round($newsRisk),

    'logistics_score' => round($logisticsRisk),

    'total_score'     => round($riskScore),

    'risk_level'      => $this->level($riskScore)

];
}
}
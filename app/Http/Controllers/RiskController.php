<?php

namespace App\Http\Controllers;

use App\Services\RiskService;
use App\Models\RiskScore;
use App\Models\Country;

class RiskController extends Controller
{
    protected $risk;

    public function __construct(RiskService $risk)
{
    $this->risk = $risk;
}

    public function index()
{
    $countries = Country::all();

    foreach ($countries as $country) {

        $riskData = $this->risk->calculateByCountry($country);

        RiskScore::updateOrCreate(
            ['country_id' => $country->id],
            $riskData
        );
    }

    $firstRisk = RiskScore::first();

    return view('risk.index', [

    'weatherRisk'   => $firstRisk->weather_score ?? 0,

    'inflationRisk' => $firstRisk->inflation_score ?? 0,

    'currencyRisk'  => $firstRisk->currency_score ?? 0,

    'newsRisk'      => $firstRisk->news_score ?? 0,

    'logisticsRisk' => $firstRisk->logistics_score ?? 0,

    'riskScore'     => $firstRisk->total_score ?? 0,

    'riskLevel'     => $firstRisk->risk_level ?? 'Low'

]);
}
}
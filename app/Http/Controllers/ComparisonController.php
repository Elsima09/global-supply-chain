<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;
use App\Models\EconomicData;
use App\Models\ExchangeRate;
use App\Models\RiskHistory;

class ComparisonController extends Controller
{
    public function index()
    {

        /*
        |--------------------------------------------------------------------------
        | Country Comparison
        |--------------------------------------------------------------------------
        */

        $comparison = RiskScore::with([
    'country.economic'
])
->whereHas('country.economic', function($query){

    $query->where('gdp','>',0);

})
->get();



        /*
        |--------------------------------------------------------------------------
        | GDP + Inflation Trend Indonesia
        |--------------------------------------------------------------------------
        */

        $gdpTrend = EconomicData::where('country_id', 1)
            ->orderBy('year')
            ->get();



        /*
        |--------------------------------------------------------------------------
        | Currency Trend IDR
        |--------------------------------------------------------------------------
        */

        $currencyTrend = ExchangeRate::where('currency_code','IDR')
            ->orderBy('created_at')
            ->get();



        /*
        |--------------------------------------------------------------------------
        | Risk History Indonesia
        |--------------------------------------------------------------------------
        */

        $riskTrend = RiskHistory::where('country_id',1)
            ->orderBy('recorded_at')
            ->get();



        return view('comparison.index', compact(
            'comparison',
            'gdpTrend',
            'currencyTrend',
            'riskTrend'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;
use App\Models\EconomicData;
use App\Models\ExchangeRate;
use App\Models\RiskHistory;
use App\Models\Country;

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
        | FIND INDONESIA ID
        |--------------------------------------------------------------------------
        */

        $indonesia = Country::where(
            'name',
            'Indonesia'
        )->first();



        $indonesiaId = $indonesia->id ?? null;




        /*
        |--------------------------------------------------------------------------
        | GDP + Inflation Trend Indonesia
        |--------------------------------------------------------------------------
        */


        $gdpTrend = EconomicData::where(
            'country_id',
            $indonesiaId
        )
        ->orderBy('year')
        ->get();





        /*
        |--------------------------------------------------------------------------
        | Currency Trend IDR
        |--------------------------------------------------------------------------
        */


        $currencyTrend = ExchangeRate::where(
            'currency_code',
            'IDR'
        )
        ->orderBy('created_at')
        ->get();






        /*
        |--------------------------------------------------------------------------
        | Risk History Indonesia
        |--------------------------------------------------------------------------
        */


        $riskTrend = RiskHistory::where(
            'country_id',
            $indonesiaId
        )
        ->orderBy('recorded_at')
        ->get();






        return view(
            'comparison.index',
            compact(
                'comparison',
                'gdpTrend',
                'currencyTrend',
                'riskTrend'
            )
        );

    }
}
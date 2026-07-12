<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;
use App\Models\EconomicData;
use App\Models\ExchangeRateHistory;
use App\Models\RiskHistory;
use App\Models\Country;


class ComparisonController extends Controller
{

    public function index()
    {


        /*
        |--------------------------------------------------------------------------
        | COUNTRY COMPARISON
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
        | FIND INDONESIA
        |--------------------------------------------------------------------------
        */


        $indonesia = Country::where(
            'name',
            'Indonesia'
        )->first();



        $indonesiaId = $indonesia?->id;






        /*
        |--------------------------------------------------------------------------
        | GDP + INFLATION TREND
        |--------------------------------------------------------------------------
        */


        $gdpTrend = EconomicData::where(
            'country_id',
            $indonesiaId
        )
        ->orderBy('year','asc')
        ->get();








        /*
        |--------------------------------------------------------------------------
        | CURRENCY TREND IDR
        |--------------------------------------------------------------------------
        */


        $currencyTrend = ExchangeRateHistory::where(
            'currency_code',
            'IDR'
        )
        ->orderBy('created_at','asc')
        ->get();








        /*
        |--------------------------------------------------------------------------
        | RISK TREND
        |--------------------------------------------------------------------------
        */


        $riskTrend = RiskHistory::where(
            'country_id',
            $indonesiaId
        )
        ->orderBy(
            'recorded_at',
            'asc'
        )
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
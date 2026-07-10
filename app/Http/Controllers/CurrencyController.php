<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Collection;

class CurrencyController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | GET ALL COUNTRIES WITH CURRENCY
        |--------------------------------------------------------------------------
        */

        $countries = Country::with('currency')
            ->whereNotNull('currency_code')
            ->orderBy('name')
            ->get();

        $currencyData = [];

        foreach ($countries as $country) {

            if (!$country->currency) {
                continue;
            }

            $rate = (float) $country->currency->rate;

            /*
            |--------------------------------------------------------------------------
            | TREND LEVEL
            |--------------------------------------------------------------------------
            */

            if ($rate >= 1000) {

                $trend = 'High';

            } elseif ($rate >= 10) {

                $trend = 'Medium';

            } else {

                $trend = 'Low';

            }

            /*
            |--------------------------------------------------------------------------
            | STORE DATA
            |--------------------------------------------------------------------------
            */

            $currencyData[] = [

                'country'  => $country->name,

                'region'   => $country->region,

                'currency' => $country->currency_code,

                'rate'     => $rate,

                'trend'    => $trend

            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SORT HIGHEST RATE
        |--------------------------------------------------------------------------
        */

        usort($currencyData, function ($a, $b) {

            return $b['rate'] <=> $a['rate'];

        });

        $currencyData = collect($currencyData);

        /*
        |--------------------------------------------------------------------------
        | SUMMARY CARD
        |--------------------------------------------------------------------------
        */

        $totalCurrency = $currencyData->count();

        $highestCurrency = $currencyData->first();

        $lowestCurrency = $currencyData->last();

        /*
        |--------------------------------------------------------------------------
        | TOP 10 CHART
        |--------------------------------------------------------------------------
        */

        $top10 = $currencyData->take(10);

        $currencyLabels = $top10
            ->pluck('currency')
            ->values();

        $currencyValues = $top10
            ->pluck('rate')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | REGION CHART
        |--------------------------------------------------------------------------
        */

        $regionChart = $currencyData
            ->groupBy('region')
            ->map(function ($item) {

                return $item->count();

            });

        $regionLabels = $regionChart
            ->keys()
            ->values();

        $regionValues = $regionChart
            ->values();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('currency.index', [

            'currencyData' => $currencyData,

            'totalCurrency' => $totalCurrency,

            'highestCurrency' => $highestCurrency,

            'lowestCurrency' => $lowestCurrency,

            'currencyLabels' => $currencyLabels,

            'currencyValues' => $currencyValues,

            'regionLabels' => $regionLabels,

            'regionValues' => $regionValues,

        ]);
    }
}
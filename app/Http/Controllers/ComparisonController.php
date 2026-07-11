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
    $comparison = RiskScore::with('country')->get();

    $gdpTrend = EconomicData::where('country_id', 1)
    ->orderBy('created_at')
    ->get();
$currencyTrend = ExchangeRate::where('currency_code', 'IDR')
    ->orderBy('created_at')
    ->get();
    $riskTrend = RiskHistory::where('country_id', 1)
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
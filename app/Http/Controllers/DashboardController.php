<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\NewsCache;
use App\Models\RiskScore;

class DashboardController extends Controller
{
    public function index()
    {
        $countryCount = Country::count();

        $portCount = Port::count();

        $newsCount = NewsCache::count();

        $highRiskCount = RiskScore::where('risk_level', 'High')->count();

        $riskScores = RiskScore::with('country')->get();
        $avgRisk = round($riskScores->avg('total_score'));

if ($avgRisk >= 70) {
    $recommendation = "Reduce shipments via high-risk ports and switch routes immediately.";
} elseif ($avgRisk >= 40) {
    $recommendation = "Monitor supply chain closely and prepare alternative logistics plans.";
} else {
    $recommendation = "Supply chain is stable. Continue normal operations.";
}

        $ports = Port::all();

        return view('dashboard', compact(
            'countryCount',
            'portCount',
            'newsCount',
            'highRiskCount',
            'riskScores',
            'ports',
            'recommendation'
        ));
    }
}
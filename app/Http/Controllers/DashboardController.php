<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\User;
use App\Models\RiskScore;
use App\Models\NewsCache;
use App\Services\RecommendationService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(
    RecommendationService $recommendationService
)
    {
        // Statistik
        $countryCount = Country::count();
        $portCount = Port::count();
        $userCount = User::count();
        $newsCount = NewsCache::count();

        // Risk Count
        $highRiskCount = RiskScore::where('risk_level', 'High')->count();
        $mediumRiskCount = RiskScore::where('risk_level', 'Medium')->count();
        $lowRiskCount = RiskScore::where('risk_level', 'Low')->count();

        // Semua Risk Score
        $riskScores = RiskScore::with('country')
            ->orderByDesc('total_score')
            ->get();

        // Top 5 Risk
        $topRiskScores = RiskScore::with('country')
            ->orderByDesc('total_score')
            ->take(5)
            ->get();

        // Semua Port
        $ports = Port::all();


        /*
|--------------------------------------------------------------------------
| GDP Trend
|--------------------------------------------------------------------------
*/

$gdpCountries = Country::whereNotNull('gdp')
    ->where('gdp', '>', 0)
    ->orderByDesc('gdp')
    ->take(10)
    ->get();

$gdpLabels = $gdpCountries->pluck('name');

$gdpValues = $gdpCountries->pluck('gdp');

       // AI Recommendation

$avgRisk = round(
    $riskScores->avg('total_score')
);


if($avgRisk >= 70){

    $riskLevel = "High";

}elseif($avgRisk >= 40){

    $riskLevel = "Medium";

}else{

    $riskLevel = "Low";

}


$recommendation = $recommendationService->generate(
    $riskLevel,
    $avgRisk
);

        return view('dashboard', compact(
            'countryCount',
            'portCount',
            'userCount',
            'newsCount',
            'highRiskCount',
            'mediumRiskCount',
            'lowRiskCount',
            'riskScores',
            'topRiskScores',
            'ports',
            'recommendation',
            'gdpLabels',
            'gdpValues'
        ));
    }

    public function refresh()
{
    return response()->json([

        'countryCount' => Country::count(),

        'highRiskCount' => RiskScore::where('risk_level','High')->count(),

        'mediumRiskCount' => RiskScore::where('risk_level','Medium')->count(),

        'lowRiskCount' => RiskScore::where('risk_level','Low')->count(),

        'portCount' => Port::count(),

        'newsCount' => NewsCache::count(),

        'lastUpdate' => now()->format('d M Y H:i:s')

    ]);
}
}
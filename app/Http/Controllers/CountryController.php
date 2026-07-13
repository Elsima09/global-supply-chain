<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\WeatherData;
use App\Models\RiskScore;
use App\Models\Port;
use App\Models\TransportHistory;
use App\Models\EconomicData;
use App\Services\RecommendationService;
use App\Services\TransportPredictionService;

class CountryController extends Controller
{

    private function economicStatus($country)
    {

        $risk = 0;


        // ==========================
        // INFLATION RISK
        // ==========================

        $inflation = $country->inflation_rate ?? 0;


        if($inflation >= 10){

            $risk += 50;

        }
        elseif($inflation >= 5){

            $risk += 30;

        }
        else{

            $risk += 10;

        }



        // ==========================
        // GDP RISK
        // ==========================

        $gdp = $country->gdp ?? 0;


        if($gdp < 100000000000){

            $risk += 40;

        }
        elseif($gdp < 500000000000){

            $risk += 20;

        }



        // ==========================
        // STATUS
        // ==========================

        if($risk >= 70){

            return "High";

        }
        elseif($risk >= 40){

            return "Medium";

        }


        return "Low";

    }



    public function index(
    TransportPredictionService $predictionService,
    RecommendationService $recommendationService
)
    {

        $countries = Country::with([
            'riskScore',
            'weather',
            'currency'
        ])
        ->orderBy('name')
        ->get();



$selectedCountry = Country::with([
    'riskScore',
    'weather',
    'currency'
])
->find(request('country'));

if (!$selectedCountry) {

    $selectedCountry = Country::where('code', 'ID')->first();

}


if (!$selectedCountry) {

    return view('countries.index', [
        'countries' => $countries,
        'selectedCountry' => null,
    ]);

}




        $weather = WeatherData::where(
            'country_id',
            $selectedCountry->id
        )
        ->latest()
        ->first();

        $economicData = \App\Models\EconomicData::where(
    'country_id',
    $selectedCountry->id
)
->latest('year')
->first();




$riskScore = RiskScore::where(
    'country_id',
    $selectedCountry->id
)
->first();
        $recommendation = null;

if ($riskScore) {

    $recommendation = $recommendationService->generate(
        $riskScore->risk_level,
        $riskScore->total_score
    );

}



        // ==========================
        // ECONOMIC STATUS
        // ==========================

        $economicStatus = $this->economicStatus(
            $selectedCountry
        );

        $economicScore = 0;


$inflation = $selectedCountry->inflation_rate ?? 0;


if($inflation >= 10){

    $economicScore += 60;

}
elseif($inflation >= 5){

    $economicScore += 40;

}
elseif($inflation >= 3){

    $economicScore += 20;

}
else{

    $economicScore += 10;

}



// GDP

$gdp = $economicData->gdp ?? 0;


if($gdp < 100000000000){

    $economicScore += 40;

}
elseif($gdp < 500000000000){

    $economicScore += 20;

}


$economicScore = min($economicScore,100);

$ports = Port::where(
    'country_id',
    $selectedCountry->id
)->get();
$prediction = $predictionService->predict(
    $ports->pluck('id')->toArray()
);

$history = \App\Models\TransportHistory::whereHas(
    'port',
    function($query) use ($selectedCountry){

        $query->where(
            'country_id',
            $selectedCountry->id
        );

    }
)
->orderBy('created_at')
->get();


// ==========================
// AI TRANSPORT RECOMMENDATION
// ==========================

if($prediction['trend']=="Increasing"){

    $transportRecommendation = [
        'title' => 'Increasing Transport Risk',
        'type' => 'danger',
        'messages' => [

            'Monitor port congestion frequently.',
            'Prepare alternative shipping routes.',
            'Increase inventory safety stock.',
            'Evaluate delayed shipment risks.'

        ]
    ];

}
elseif($prediction['trend']=="Decreasing"){

    $transportRecommendation = [

        'title' => 'Transport Condition Improving',
        'type' => 'success',
        'messages' => [

            'Transport risk is decreasing.',
            'Normal operation can continue.',
            'Maintain regular monitoring.'

        ]

    ];

}
else{

    $transportRecommendation = [

        'title' => 'Transport Condition Stable',
        'type' => 'warning',
        'messages' => [

            'Continue monitoring port activity.',
            'Maintain current logistics strategy.',
            'Review possible external disruption.'

        ]

    ];

}

/*
|--------------------------------------------------------------------------
| DATA VISUALIZATION
|--------------------------------------------------------------------------
*/

// GDP Trend

$gdpCountries = EconomicData::with('country')
    ->whereNotNull('gdp')
    ->orderByDesc('gdp')
    ->limit(10)
    ->get();


$gdpLabels = $gdpCountries
    ->pluck('country.name')
    ->values();


$gdpValues = $gdpCountries
    ->pluck('gdp')
    ->values();

// Inflation Trend
$inflationCountries = EconomicData::with('country')
    ->whereNotNull('inflation')
    ->latest('year')
    ->get()
    ->unique('country_id');


$inflationLabels = $inflationCountries
    ->pluck('country.name')
    ->values();


$inflationValues = $inflationCountries
    ->pluck('inflation')
    ->values();

// Risk Trend
$riskLabels = RiskScore::with('country')
    ->get()
    ->pluck('country.name');

$riskValues = RiskScore::pluck('total_score');
        return view(
            'countries.index',
compact(

    'countries',

    'selectedCountry',

    'weather',

    'riskScore',

    'economicStatus',

    'economicScore',

    'ports',

    'history',

    'recommendation',
    
    'prediction',

'transportRecommendation',

'gdpLabels',
'gdpValues',

'inflationLabels',
'inflationValues',

'riskLabels',
'riskValues',
'economicData',
)
        );

    }

    public function sync()
{
    \Artisan::call('countries:import');

    return redirect()
        ->back()
        ->with('success', 'Countries synchronized successfully.');
}


}
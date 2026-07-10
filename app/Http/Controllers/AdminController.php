<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\User;
use App\Models\WeatherData;
use App\Models\SentimentResult;
use App\Models\RiskScore;
use App\Services\RiskService;
use App\Services\WeatherService;
use App\Services\CurrencyService;
use App\Services\NewsService;
use App\Models\ExchangeRate;
use App\Models\NewsCache;
use App\Models\PositiveWord;
use App\Models\NegativeWord;
use App\Services\WorldBankService;
use App\Services\TransportRiskService;
use App\Models\ExchangeRateHistory;

class AdminController extends Controller
{
    public function recalculateRisk(RiskService $riskService)
{
    foreach (Country::all() as $country) {

        $riskData = $riskService->calculateByCountry($country);

    }


    return redirect()
        ->back()
        ->with(
            'success',
            'Risk recalculated successfully!'
        );
}
public function refreshApi(
    WeatherService $weatherService,
    CurrencyService $currencyService,
    NewsService $newsService,
    WorldBankService $worldBankService,
    RiskService $riskService,
    TransportRiskService $transportRiskService
)

{
    /*
    |--------------------------------------------------------------------------
    | WEATHER
    |--------------------------------------------------------------------------
    */

    foreach (Country::take(3)->get() as $country) {

        if (!$country->latitude || !$country->longitude) {
            continue;
        }

        $weather = $weatherService->getCurrentWeather(
            $country->latitude,
            $country->longitude
        );

        $temperature = $weather['current']['temperature_2m'] ?? 0;
        $rainfall    = $weather['current']['rain'] ?? 0;
        $wind        = $weather['current']['wind_speed_10m'] ?? 0;

$stormRisk = 20;


// Risiko angin
if ($wind >= 30) {

    $stormRisk += 40;

} elseif ($wind >= 15) {

    $stormRisk += 20;

}


// Risiko hujan
if ($rainfall >= 10) {

    $stormRisk += 40;

} elseif ($rainfall >= 2) {

    $stormRisk += 20;

}


// Risiko suhu ekstrem
if ($temperature > 35 || $temperature < 10) {

    $stormRisk += 30;

}


$stormRisk = min($stormRisk,100);

        $stormRisk = min($stormRisk, 100);

        WeatherData::create([

            'country_id' => $country->id,

            'temperature' => $temperature,

            'rainfall' => $rainfall,

            'wind_speed' => $wind,

            'storm_risk' => $stormRisk

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | CURRENCY
    |--------------------------------------------------------------------------
    */

    $currency = $currencyService->getRates();

    $rates = $currency['rates'] ?? [];

    $currencies = Country::whereNotNull('currency_code')
    ->where('currency_code', '!=', '0')
    ->pluck('currency_code')
    ->unique();
    

    foreach ($currencies as $code) {

        if (!isset($rates[$code])) {
            continue;
        }

        ExchangeRate::updateOrCreate(

            [
                'currency_code' => $code
            ],

            [
                'base_currency' => 'USD',

                'rate' => $rates[$code]
            ]

        );

        ExchangeRateHistory::create([

    'base_currency' => 'USD',

    'currency_code' => $code,

    'rate' => $rates[$code]

]);

    }


    /*
|--------------------------------------------------------------------------
| TRANSPORT ANALYSIS
|--------------------------------------------------------------------------
*/

foreach (Port::all() as $port) {

    $risk = $transportRiskService->calculate($port);

    $congestion = "Low";

    if($risk >= 70){

        $congestion = "High";

    }
    elseif($risk >= 40){

        $congestion = "Medium";

    }

    $port->update([

        'transport_risk' => $risk,

        'congestion' => $congestion

    ]);

}

    /*
    |--------------------------------------------------------------------------
    | GDP
    |--------------------------------------------------------------------------
    */

    foreach (Country::take(3)->get() as $country) {

        $gdpData = $worldBankService->getGDP(
            $country->code
        );

        $latestGDP = $gdpData[1][0]['value'] ?? null;

        if ($latestGDP) {

            $country->update([

                'gdp' => $latestGDP

            ]);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | NEWS
    |--------------------------------------------------------------------------
    */

    $news = $newsService->getNews();

    $articles = $news['articles'] ?? [];

    $positiveWords = PositiveWord::pluck('word')->toArray();

    $negativeWords = NegativeWord::pluck('word')->toArray();


foreach ($articles as $article) {

    $news = NewsCache::updateOrCreate(

        [
            'title' => $article['title'] ?? 'No Title'
        ],

        [
            'description' => $article['description'] ?? '',
            'source' => $article['source']['name'] ?? 'Unknown',
            'category' => 'Supply Chain',
            'sentiment' => 'Pending'
        ]

    );

    $text = strtolower(

        ($article['title'] ?? '') . ' ' .

        ($article['description'] ?? '')

    );

    $positiveScore = 0;

    $negativeScore = 0;

    foreach ($positiveWords as $word) {

        if (str_contains($text, strtolower($word))) {

            $positiveScore++;

        }

    }

    foreach ($negativeWords as $word) {

        if (str_contains($text, strtolower($word))) {

            $negativeScore++;

        }

    }

    $score = $positiveScore - $negativeScore;

    if ($score > 0) {

        $sentiment = 'Positive';

    } elseif ($score < 0) {

        $sentiment = 'Negative';

    } else {

        $sentiment = 'Neutral';

    }

    $news->update([

        'sentiment' => $sentiment

    ]);

    SentimentResult::create([

        'news_cache_id' => $news->id,

        'positive_score' => $positiveScore,

        'negative_score' => $negativeScore,

        'sentiment' => $sentiment

    ]);

}

/*
|--------------------------------------------------------------------------
| RISK SCORE
|--------------------------------------------------------------------------
*/

foreach (Country::take(3)->get() as $country) {

    $riskData = $riskService->calculateByCountry($country);

    RiskScore::updateOrCreate(

        [
            'country_id' => $country->id
        ],

        $riskData

    );

}

/*
|--------------------------------------------------------------------------
| FINISH
|--------------------------------------------------------------------------
*/

return redirect()->back()->with(

    'success',

    'Weather, GDP, Currency, News, and Risk data have been refreshed successfully.'

);

}
    public function index()
    {
        $countryCount = Country::count();
        $portCount = Port::count();
        $userCount = User::count();

        return view('admin.index', compact(
            'countryCount',
            'portCount',
            'userCount'
        ));
    }
}
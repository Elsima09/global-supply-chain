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

class AdminController extends Controller
{
    public function recalculateRisk(RiskService $riskService)
{
   foreach (Country::all() as $country) {

    $riskData = $riskService->calculateByCountry($country);

    RiskScore::updateOrCreate(
        ['country_id' => $country->id],
        $riskData
    );
}

    return redirect()->back()->with('success', 'Risk recalculated successfully!');
}
public function refreshApi(
    WeatherService $weatherService,
    CurrencyService $currencyService,
    NewsService $newsService,
    WorldBankService $worldBankService,
    RiskService $riskService
)
{
    $locations = [
    ['country_id' => 1, 'lat' => -6.2, 'lon' => 106.8],   // Indonesia
    ['country_id' => 2, 'lat' => 31.2, 'lon' => 121.5],   // China
    ['country_id' => 3, 'lat' => 40.7, 'lon' => -74.0],   // USA
];

foreach ($locations as $loc) {

    $weather = $weatherService->getCurrentWeather(
        $loc['lat'],
        $loc['lon']
    );

    $temperature = $weather['current']['temperature_2m'] ?? 0;
    $rainfall = $weather['current']['rain'] ?? 0;
    $wind = $weather['current']['wind_speed_10m'] ?? 0;

    $stormRisk = 0;

    if ($wind > 20) {
        $stormRisk += 50;
    }

    if ($rainfall > 5) {
        $stormRisk += 30;
    }

    if ($temperature > 35 || $temperature < 15) {
        $stormRisk += 20;
    }

    $stormRisk = min($stormRisk, 100);

    WeatherData::create([
        'country_id' => $loc['country_id'],
        'temperature' => $temperature,
        'rainfall' => $rainfall,
        'wind_speed' => $wind,
        'storm_risk' => $stormRisk
    ]);
}
    $currency = $currencyService->getRates();
    $rates = $currency['rates'] ?? [];

$selectedCurrencies = ['IDR', 'CNY', 'USD'];

foreach ($selectedCurrencies as $code) {
    if (isset($rates[$code])) {
        ExchangeRate::updateOrCreate(
            ['currency_code' => $code],
            [
                'base_currency' => 'USD',
                'rate' => $rates[$code]
            ]
        );
    }
}
// World Bank API - GDP Indonesia
$gdpData = $worldBankService->getGDP('ID');
$latestGDP = $gdpData[1][0]['value'] ?? null;

if ($latestGDP) {
    Country::where('code', 'ID')->update([
        'gdp' => $latestGDP
    ]);
}

// GDP China
$gdpChina = $worldBankService->getGDP('CN');
$latestGDPChina = $gdpChina[1][0]['value'] ?? null;

if ($latestGDPChina) {
    Country::where('code', 'CN')->update([
        'gdp' => $latestGDPChina
    ]);
}

// GDP United States
$gdpUS = $worldBankService->getGDP('US');
$latestGDPUS = $gdpUS[1][0]['value'] ?? null;

if ($latestGDPUS) {
    Country::where('code', 'US')->update([
        'gdp' => $latestGDPUS
    ]);
}

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


foreach (Country::all() as $country) {

    $riskData = $riskService->calculateByCountry($country);

    RiskScore::updateOrCreate(
        ['country_id' => $country->id],
        $riskData
    );
}
return redirect()->back()->with(
    'success',
    'Weather, Currency, News, and Risk updated successfully!'
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
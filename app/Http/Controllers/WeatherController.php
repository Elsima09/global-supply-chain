<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weather;

    public function __construct(WeatherService $weather)
    {
        $this->weather = $weather;
    }

    public function index()
    {
$countries = Country::orderBy('name')->get();

$selectedCountry = Country::find(
    request('country')
) ?? $countries->first();

$weather = $this->weather->getCurrentWeather(
    $selectedCountry->latitude,
    $selectedCountry->longitude
);

        return view(
    'weather.index',
    compact(
        'countries',
        'selectedCountry',
        'weather'
    )
);
    }
}
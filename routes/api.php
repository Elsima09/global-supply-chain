<?php

use Illuminate\Support\Facades\Route;
use App\Models\Country;
use App\Models\Port;
use App\Models\RiskScore;
use App\Services\WorldBankService;
use App\Models\NewsCache;
use App\Models\ExchangeRate;

Route::get('/countries', function () {
    return Country::all();
});

Route::get('/ports', function () {
    return Port::all();
});

Route::get('/risk', function () {
    return RiskScore::all();
});

Route::get('/worldbank-test', function (WorldBankService $worldBank) {
    return $worldBank->getGDP('ID');
});

Route::get('/news', function () {
    return NewsCache::select(
        'id',
        'title',
        'description',
        'source',
        'sentiment',
        'created_at'
    )->latest()->get();
});

Route::get('/currency', function () {
    return ExchangeRate::select(
        'currency_code',
        'base_currency',
        'rate',
        'updated_at'
    )->get();
});
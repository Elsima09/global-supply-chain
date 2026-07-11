<?php

namespace App\Models;

use App\Models\WeatherData;
use App\Models\ExchangeRate;
use App\Models\ExchangeRateHistory;
use App\Models\EconomicData;
use App\Models\RiskScore;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = [
        'name',
        'code',
        'region',
        'currency_code',
        'population',
        'gdp',
        'inflation_rate',
        'export_value',
        'import_value',
        'latitude',
        'longitude'
    ];


    public function weather()
    {
        return $this->hasMany(
            WeatherData::class
        );
    }


    public function riskScore()
    {
        return $this->hasOne(
            RiskScore::class
        );
    }


    public function riskScores()
    {
        return $this->hasMany(
            RiskScore::class
        );
    }


    public function getFlagAttribute()
    {
        return strtolower($this->code);
    }


    public function currency()
    {
        return $this->hasOne(
            ExchangeRate::class,
            'currency_code',
            'currency_code'
        );
    }


    public function exchangeRateHistories()
    {
        return $this->hasMany(
            ExchangeRateHistory::class,
            'currency_code',
            'currency_code'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Economic Data
    |--------------------------------------------------------------------------
    |
    | Mengambil data ekonomi tahun 2025
    | karena data ini memiliki:
    | - GDP
    | - Inflation
    | - Export
    | - Import
    |
    | Data tahun 2026 hasil API hanya memiliki GDP.
    |
    */

    public function economic()
{
    return $this->hasOne(EconomicData::class)
        ->latestOfMany('year');
}

}
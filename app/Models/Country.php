<?php

namespace App\Models;
use App\Models\WeatherData;
use App\Models\ExchangeRate;
use App\Models\ExchangeRateHistory;
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
        return $this->hasMany(WeatherData::class);
    }

    public function riskScore()
    {
        return $this->hasOne(RiskScore::class);
    }

    public function riskScores()
    {
        return $this->hasMany(RiskScore::class);
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
}
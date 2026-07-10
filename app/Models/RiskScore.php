<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    protected $guarded = [];

    protected $fillable = [

    'country_id',

    'weather_score',

    'economic_score',

    'inflation_score',

    'currency_score',

    'news_score',

    'logistics_score',

    'total_score',

    'risk_level'

];

protected static function booted()
{
    static::saving(function ($model) {
    });
}

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
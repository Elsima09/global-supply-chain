<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RiskScore;

class Country extends Model
{
    protected $fillable = [
        'name',
        'risk_level',
    ];

    public function riskScores()
    {
        return $this->hasMany(RiskScore::class);
    }

    public function riskScore()
    {
        return $this->hasOne(RiskScore::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskHistory extends Model
{

    protected $fillable = [

        'country_id',

        'risk_score',

        'recorded_at'

    ];



    public function country()
    {
        return $this->belongsTo(
            Country::class
        );
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRateHistory extends Model
{
    protected $table = 'exchange_rate_histories';

    protected $fillable = [

        'base_currency',

        'currency_code',

        'rate'

    ];

    public function country()
    {
        return $this->belongsTo(
            Country::class,
            'currency_code',
            'currency_code'
        );
    }
}
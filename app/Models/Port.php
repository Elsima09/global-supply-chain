<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransportHistory;
use App\Models\Country;

class Port extends Model
{
    protected $fillable = [

        'port_name',

        'country',

        'latitude',

        'longitude',

        'status',

        'delay_hours',

        'capacity',

        'congestion',

        'transport_risk'

    ];


    public function transportHistories()
    {
        return $this->hasMany(TransportHistory::class);
    }

    public function countryModel()
{
    return $this->belongsTo(Country::class, 'country_id');
}

}
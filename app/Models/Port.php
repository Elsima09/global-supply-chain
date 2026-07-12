<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{

    protected $fillable = [

        'country_id',
        'port_name',
        'country',
        'latitude',
        'longitude',
        'status',
        'delay_hours',
        'capacity',
        'congestion',
        'transport_risk',
        'traffic_level',
        'congestion_level',
        'logistics_score'

    ];


    /*
    |--------------------------------------------------------------------------
    | RELATION COUNTRY
    |--------------------------------------------------------------------------
    */

    public function country()
    {
        return $this->belongsTo(
            Country::class,
            'country_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | TRANSPORT HISTORY
    |--------------------------------------------------------------------------
    */

    public function transportHistories()
    {
        return $this->hasMany(
            TransportHistory::class
        );
    }


}
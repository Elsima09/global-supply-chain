<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportHistory extends Model
{

protected $fillable = [

    'port_id',
    'risk_score',
    'delay_hours',
    'capacity',
    'congestion'

];


public function port()
{
    return $this->belongsTo(Port::class);
}


}
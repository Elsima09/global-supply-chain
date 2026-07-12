<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Port extends Model
{


protected $fillable=[

'country_id',
'port_name',
'latitude',
'longitude',
'status',
'delay_hours',
'capacity',
'congestion',
'transport_risk'

];



public function country()
{

return $this->belongsTo(
Country::class
);

}



public function transportHistories()
{

return $this->hasMany(
TransportHistory::class
);

}


}
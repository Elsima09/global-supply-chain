<?php

namespace App\Services;


use App\Models\Port;


class LogisticsRiskService
{


public function calculate($country=null)
{


$query=Port::query();



if($country)
{

$query->where(
'country_id',
$country->id
);

}



$risk=$query->avg(
'transport_risk'
);



return round(
$risk ?? 20
);


}


}
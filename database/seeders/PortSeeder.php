<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Port;
use App\Models\Country;


class PortSeeder extends Seeder
{


public function run(): void
{


$data=[


[
'name'=>'China',
'ports'=>[
[
'name'=>'Port of Shanghai',
'lat'=>31.2304,
'lng'=>121.4737
],

[
'name'=>'Port of Shenzhen',
'lat'=>22.5431,
'lng'=>114.0579
]

]
],



[
'name'=>'Indonesia',
'ports'=>[

[
'name'=>'Port of Tanjung Priok',
'lat'=>-6.1049,
'lng'=>106.8860
],

[
'name'=>'Port of Tanjung Perak',
'lat'=>-7.2048,
'lng'=>112.7190
]


]
],


[
'name'=>'United States',
'ports'=>[

[
'name'=>'Port of Los Angeles',
'lat'=>33.7405,
'lng'=>-118.2710
]


]

]


];





foreach($data as $item)
{


$country=Country::where(
'name',
$item['name']
)->first();



if(!$country){

continue;

}




foreach($item['ports'] as $port)
{


Port::updateOrCreate(

[

'port_name'=>$port['name']

],

[

'country_id'=>$country->id,

'latitude'=>$port['lat'],

'longitude'=>$port['lng'],

'status'=>'active',

'delay_hours'=>0,

'capacity'=>100,

'congestion'=>'Low',

'transport_risk'=>20

]

);


}


}


}

}
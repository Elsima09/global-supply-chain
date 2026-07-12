<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;
use App\Models\Country;

class PortSeeder extends Seeder
{

    public function run(): void
    {


        $ports = [

            [
                'port'=>'Port of Shanghai',
                'country'=>'China',
                'lat'=>31.2304,
                'lng'=>121.4737
            ],

            [
                'port'=>'Port of Ningbo-Zhoushan',
                'country'=>'China',
                'lat'=>29.8683,
                'lng'=>121.5440
            ],

            [
                'port'=>'Port of Shenzhen',
                'country'=>'China',
                'lat'=>22.5431,
                'lng'=>114.0579
            ],


            [
                'port'=>'Port of Tanjung Priok',
                'country'=>'Indonesia',
                'lat'=>-6.1049,
                'lng'=>106.8860
            ],

            [
                'port'=>'Port of Singapore',
                'country'=>'Singapore',
                'lat'=>1.2644,
                'lng'=>103.8220
            ],


            [
                'port'=>'Port of Rotterdam',
                'country'=>'Netherlands',
                'lat'=>51.9244,
                'lng'=>4.4777
            ],


            [
                'port'=>'Port of Hamburg',
                'country'=>'Germany',
                'lat'=>53.5511,
                'lng'=>9.9937
            ],


            [
'port'=>'Port of Los Angeles',
'country'=>'United States of America',
                'lat'=>33.7405,
                'lng'=>-118.2720
            ],


[
'port'=>'Port of Long Beach',
'country'=>'United States of America',
                'lat'=>33.7701,
                'lng'=>-118.1937
            ],


            [
                'port'=>'Port of Tokyo',
                'country'=>'Japan',
                'lat'=>35.6170,
                'lng'=>139.7714
            ],


[
    'port'=>'Port of Busan',
    'country'=>'Korea (Republic of)',
    'lat'=>35.1796,
    'lng'=>129.0756
],


            [
                'port'=>'Port Klang',
                'country'=>'Malaysia',
                'lat'=>3.0000,
                'lng'=>101.4000
            ],


            [
                'port'=>'Port of Bangkok',
                'country'=>'Thailand',
                'lat'=>13.6938,
                'lng'=>100.5758
            ],


            [
                'port'=>'Port of Mumbai',
                'country'=>'India',
                'lat'=>18.9448,
                'lng'=>72.9496
            ],


            [
                'port'=>'Port of Dubai Jebel Ali',
                'country'=>'United Arab Emirates',
                'lat'=>25.0113,
                'lng'=>55.0615
            ],


            [
                'port'=>'Port of Sydney',
                'country'=>'Australia',
                'lat'=>-33.8568,
                'lng'=>151.2153
            ],


            [
                'port'=>'Port of Vancouver',
                'country'=>'Canada',
                'lat'=>49.2827,
                'lng'=>-123.1207
            ],


            [
                'port'=>'Port of Santos',
                'country'=>'Brazil',
                'lat'=>-23.9608,
                'lng'=>-46.3337
            ],


            [
                'port'=>'Port of Cape Town',
                'country'=>'South Africa',
                'lat'=>-33.9189,
                'lng'=>18.4233
            ],


            [
                'port'=>'Port of Alexandria',
                'country'=>'Egypt',
                'lat'=>31.2001,
                'lng'=>29.9187
            ],

        ];




        foreach($ports as $item)
        {


            $country = Country::where(
                'name',
                $item['country']
            )->first();



            if(!$country){

                echo "Country not found : ".$item['country']."\n";

                continue;

            }



Port::updateOrCreate(

[
    'port_name'=>$item['port']
],

[

    'country_id'=>$country->id,

    'latitude'=>$item['lat'],

    'longitude'=>$item['lng'],

    'status'=>'active',

    'delay_hours'=>0,

    'capacity'=>100,

    'congestion'=>'Low',

    'transport_risk'=>30,

    'traffic_level'=>'Medium',

    'congestion_level'=>30,

    'logistics_score'=>30

]

);


            echo "Saved ".$item['port']."\n";


        }


    }

}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [

            [
                'name' => 'Indonesia',
                'code' => 'ID',
                'region' => 'Asia',
                'currency_code' => 'IDR',
                'population' => 281000000,
                'inflation_rate' => 2.5,
                'latitude' => -6.200,
                'longitude' => 106.816,
            ],

            [
                'name' => 'China',
                'code' => 'CN',
                'region' => 'Asia',
                'currency_code' => 'CNY',
                'population' => 1412000000,
                'inflation_rate' => 0.3,
                'latitude' => 31.230,
                'longitude' => 121.473,
            ],

            [
                'name' => 'United States',
                'code' => 'US',
                'region' => 'North America',
                'currency_code' => 'USD',
                'population' => 340000000,
                'inflation_rate' => 3.1,
                'latitude' => 40.712,
                'longitude' => -74.006,
            ],

            [
                'name' => 'Japan',
                'code' => 'JP',
                'region' => 'Asia',
                'currency_code' => 'JPY',
                'population' => 123000000,
                'inflation_rate' => 2.8,
                'latitude' => 35.676,
                'longitude' => 139.650,
            ],

            [
                'name' => 'Germany',
                'code' => 'DE',
                'region' => 'Europe',
                'currency_code' => 'EUR',
                'population' => 84000000,
                'inflation_rate' => 2.4,
                'latitude' => 52.520,
                'longitude' => 13.405,
            ],

            [
                'name' => 'Australia',
                'code' => 'AU',
                'region' => 'Oceania',
                'currency_code' => 'AUD',
                'population' => 27000000,
                'inflation_rate' => 3.4,
                'latitude' => -33.868,
                'longitude' => 151.209,
            ],

            [
                'name' => 'Singapore',
                'code' => 'SG',
                'region' => 'Asia',
                'currency_code' => 'SGD',
                'population' => 6100000,
                'inflation_rate' => 2.4,
                'latitude' => 1.352,
                'longitude' => 103.819,
            ],

            [
                'name' => 'Malaysia',
                'code' => 'MY',
                'region' => 'Asia',
                'currency_code' => 'MYR',
                'population' => 35000000,
                'inflation_rate' => 1.9,
                'latitude' => 3.139,
                'longitude' => 101.687,
            ],

            [
                'name' => 'Thailand',
                'code' => 'TH',
                'region' => 'Asia',
                'currency_code' => 'THB',
                'population' => 71000000,
                'inflation_rate' => 1.4,
                'latitude' => 13.756,
                'longitude' => 100.501,
            ],

            [
                'name' => 'Vietnam',
                'code' => 'VN',
                'region' => 'Asia',
                'currency_code' => 'VND',
                'population' => 101000000,
                'inflation_rate' => 3.2,
                'latitude' => 21.028,
                'longitude' => 105.854,
            ],

            [
                'name' => 'India',
                'code' => 'IN',
                'region' => 'Asia',
                'currency_code' => 'INR',
                'population' => 1430000000,
                'inflation_rate' => 4.8,
                'latitude' => 28.613,
                'longitude' => 77.209,
            ],

            [
                'name' => 'South Korea',
                'code' => 'KR',
                'region' => 'Asia',
                'currency_code' => 'KRW',
                'population' => 52000000,
                'inflation_rate' => 2.7,
                'latitude' => 37.566,
                'longitude' => 126.978,
            ],

            [
                'name' => 'Netherlands',
                'code' => 'NL',
                'region' => 'Europe',
                'currency_code' => 'EUR',
                'population' => 18000000,
                'inflation_rate' => 2.9,
                'latitude' => 52.367,
                'longitude' => 4.904,
            ],

            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'region' => 'Europe',
                'currency_code' => 'GBP',
                'population' => 69000000,
                'inflation_rate' => 2.2,
                'latitude' => 51.507,
                'longitude' => -0.128,
            ],

            [
                'name' => 'Brazil',
                'code' => 'BR',
                'region' => 'South America',
                'currency_code' => 'BRL',
                'population' => 212000000,
                'inflation_rate' => 4.5,
                'latitude' => -23.550,
                'longitude' => -46.633,
            ]

        ];

        foreach ($countries as $country) {

            Country::updateOrCreate(

                [
                    'code' => $country['code']
                ],

                $country

            );

        }
    }
}
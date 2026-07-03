<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Country::insert([
            [
                'name' => 'Indonesia',
                'code' => 'ID',
                'region' => 'Asia',
                'currency_code' => 'IDR',
                'population' => 278000000
            ],
            [
                'name' => 'China',
                'code' => 'CN',
                'region' => 'Asia',
                'currency_code' => 'CNY',
                'population' => 1410000000
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'region' => 'America',
                'currency_code' => 'USD',
                'population' => 334000000
            ]
        ]);
    }
}
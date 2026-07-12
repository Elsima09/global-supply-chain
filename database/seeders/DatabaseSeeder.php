<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

$this->call([
            CountrySeeder::class,
            EconomicDataSeeder::class,
            PortSeeder::class,
            NewsSeeder::class,
            TransportHistorySeeder::class,
            RiskScoreSeeder::class,
        ]);

    }

}
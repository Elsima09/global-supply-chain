<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        Port::insert([
            [
                'port_name' => 'Port of Shanghai',
                'country' => 'China',
                'latitude' => 31.2304,
                'longitude' => 121.4737,
                'status' => 'active'
            ],
            [
                'port_name' => 'Port of Tanjung Priok',
                'country' => 'Indonesia',
                'latitude' => -6.1049,
                'longitude' => 106.8860,
                'status' => 'active'
            ]
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsCache;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        NewsCache::insert([
            [
                'title' => 'Global Shipping Delays Rise',
                'description' => 'Supply chain disruptions increase globally.',
                'source' => 'Reuters',
                'category' => 'Logistics',
                'sentiment' => 'negative'
            ],
            [
                'title' => 'Port Activity Improves',
                'description' => 'Major ports show increased efficiency.',
                'source' => 'Bloomberg',
                'category' => 'Ports',
                'sentiment' => 'positive'
            ]
        ]);
    }
}
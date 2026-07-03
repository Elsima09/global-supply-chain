<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsService
{
    public function getNews()
    {
        $apiKey = env('GNEWS_API_KEY');

        $response = Http::timeout(30)
            ->withoutVerifying()
            ->get('https://gnews.io/api/v4/search', [
                'q' => 'supply chain',
                'lang' => 'en',
                'max' => 10,
                'token' => $apiKey
            ]);

        return $response->json();
    }
}
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WorldBankService
{
    public function getGDP($countryCode)
    {
        $response = Http::get(
            "https://api.worldbank.org/v2/country/{$countryCode}/indicator/NY.GDP.MKTP.CD?format=json"
        );

        return $response->json();
    }
}
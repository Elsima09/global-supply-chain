<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CountryService
{
    public function getCountries()
    {
        $response = Http::get(
            'https://countries.dev/countries'
        );

        if (!$response->successful()) {
            return [];
        }

        return $response->json();
    }
}
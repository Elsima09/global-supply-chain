<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyService
{
    public function getRates()
    {
        $response = Http::timeout(30)
            ->withoutVerifying()
            ->get('https://open.er-api.com/v6/latest/USD');

        return $response->json();
    }
}
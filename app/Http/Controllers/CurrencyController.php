<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $rates = $this->currencyService->getRates();

        $currencyData = [
            [
                'country' => 'Indonesia',
                'currency' => 'IDR',
                'rate' => $rates['rates']['IDR'] ?? 0
            ],
            [
                'country' => 'China',
                'currency' => 'CNY',
                'rate' => $rates['rates']['CNY'] ?? 0
            ],
            [
                'country' => 'United States',
                'currency' => 'USD',
                'rate' => 1
            ]
        ];

        return view('currency.index', compact('currencyData'));
    }
}
<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Services\CountryService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('countries:import')]
#[Description('Import countries from Countries API')]
class ImportCountries extends Command
{
    public function handle(CountryService $countryService)
    {

        $countries = $countryService->getCountries();

        if(empty($countries)){

            $this->error('Failed to fetch countries.');

            return;

        }

        foreach($countries as $country){

Country::updateOrCreate(

    [
        'code' => $country['alpha2Code']
    ],

    [

        'name' => $country['name'],

        'code' => $country['alpha2Code'],

        'region' => $country['region'],

        'currency_code' => $country['currencies'][0]['code'] ?? null,

        'population' => $country['population'] ?? 0,

        'latitude' => $country['latlng'][0] ?? null,

        'longitude' => $country['latlng'][1] ?? null

    ]

);

        }

        $this->info('Countries imported successfully.');

    }
}
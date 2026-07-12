<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Country;


class ImportCountries extends Command
{


    protected $signature = 'countries:import';


    protected $description = 'Import countries data';



    public function handle()
    {


        $this->info(
            "Country import command running..."
        );


        /*
        |--------------------------------------------------------------------------
        | LOGIC IMPORT COUNTRY KAMU TETAP DI SINI
        |--------------------------------------------------------------------------
        |
        | Jangan ubah nama class menjadi UpdateWeatherData.
        |
        */



        $this->info(
            "Countries imported successfully."
        );



        return Command::SUCCESS;


    }


}
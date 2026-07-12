<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


/*
|--------------------------------------------------------------------------
| Default Laravel Command
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {

    $this->comment(
        Inspiring::quote()
    );

})
->purpose('Display an inspiring quote');



/*
|--------------------------------------------------------------------------
| Supply Chain Risk Scheduler
|--------------------------------------------------------------------------
|
| Menghitung ulang risiko supply chain secara otomatis.
|
| Production:
| - daily()  = setiap hari
|
| Testing:
| - everyMinute() = setiap menit
|
|--------------------------------------------------------------------------
*/


Schedule::command('risk:calculate')
    ->daily();

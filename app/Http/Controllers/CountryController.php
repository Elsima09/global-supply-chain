<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Watchlist;
use Illuminate\Http\Request;


class CountryController extends Controller
{
    public function index()
{
    $countries = Country::all();

    $watchlistedCountryIds = Watchlist::where('user_id', auth()->id())
        ->pluck('country_id')
        ->toArray();

    return view('countries.index', compact(
        'countries',
        'watchlistedCountryIds'
    ));
}
}
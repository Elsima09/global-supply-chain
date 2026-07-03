<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use App\Models\Country;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = Watchlist::with([
    'country',
    'country.riskScore'
])
->where('user_id', auth()->id())
->get();

        return view('watchlist.index', compact('watchlists'));
    }

    public function store()
{
    $countryId = request('country_id');

    Watchlist::firstOrCreate([
        'user_id' => auth()->id(),
        'country_id' => $countryId
    ]);

    return redirect()->back()->with(
        'success',
        'Country added to watchlist!'
    );
}

public function destroy(Watchlist $watchlist)
{
    if ($watchlist->user_id == auth()->id()) {
        $watchlist->delete();
    }

    return redirect()->back()->with(
        'success',
        'Removed from watchlist!'
    );
}
}
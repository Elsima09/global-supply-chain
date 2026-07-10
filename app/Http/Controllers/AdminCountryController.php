<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class AdminCountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
{
    return view('admin.countries.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'code' => 'required',
        'region' => 'required',
        'currency_code' => 'required',
        'population' => 'required|numeric',
        'gdp' => 'required|numeric',
        'inflation_rate' => 'required|numeric',
        'export_value' => 'required|numeric',
        'import_value' => 'required|numeric',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric'
    ]);

    Country::create($request->all());

    return redirect()
        ->route('admin.countries')
        ->with('success','Country added successfully.');
}

public function edit(Country $country)
{
    return view(
        'admin.countries.edit',
        compact('country')
    );
}

public function update(Request $request, Country $country)
{
    $request->validate([
        'name' => 'required',
        'code' => 'required',
        'region' => 'required',
        'currency_code' => 'required',
        'population' => 'required|numeric',
        'gdp' => 'required|numeric',
        'inflation_rate' => 'required|numeric',
        'export_value' => 'required|numeric',
        'import_value' => 'required|numeric',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric'
    ]);

    $country->update($request->all());

    return redirect()
        ->route('admin.countries')
        ->with('success', 'Country updated successfully.');
}

public function destroy(Country $country)
{
    $country->delete();

    return redirect()
        ->route('admin.countries')
        ->with('success', 'Country deleted successfully.');
}
}
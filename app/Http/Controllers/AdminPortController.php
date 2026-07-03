<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Port;


class AdminPortController extends Controller
{
    public function index()
    {
        $ports = Port::all();

        return view('admin.ports.index', compact('ports'));
    }

    public function store(Request $request)
{
    Port::create([
        'port_name' => $request->port_name,
        'country' => $request->country,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'status' => 'active'
    ]);

    return redirect()->back()->with('success', 'Port added successfully!');
}

public function destroy(Port $port)
{
    $port->delete();

    return redirect()->back()->with('success', 'Port deleted successfully!');
}

public function update(Request $request, Port $port)
{
    $port->update([
        'port_name' => $request->port_name,
        'country' => $request->country,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    return redirect()->back()->with('success', 'Port updated successfully!');
}

public function edit(Port $port)
{
    return view('admin.ports.edit', compact('port'));
}
}
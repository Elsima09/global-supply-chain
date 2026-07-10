<?php

namespace App\Http\Controllers;

use App\Models\Port;

class PortController extends Controller
{

    public function index()
    {

        $query = Port::query();


        if(request('search')){

            $search = request('search');


            $query->where(function($q) use ($search){

                $q->where(
                    'port_name',
                    'like',
                    "%$search%"
                )
                ->orWhere(
                    'country',
                    'like',
                    "%$search%"
                );

            });

        }


        $ports = $query->get();


        return view(
            'ports.index',
            compact('ports')
        );

    }



public function map()
{

    $ports = Port::with('countryModel.riskScore')->get();


    return view(
        'ports.map',
        compact('ports')
    );

}


}
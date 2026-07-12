<?php

namespace App\Http\Controllers;

use App\Models\Port;

class PortController extends Controller
{

    public function index()
    {

        $query = Port::with([
            'country.riskScore'
        ]);



        if(request('search')){


            $search = request('search');



            $query->where(function($q) use ($search){


                $q->where(
                    'port_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas(
                    'country',
                    function($country) use ($search){

                        $country->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );

                    }
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


        $ports = Port::with([

            'country.riskScore'

        ])->get();



        return view(
            'ports.map',
            compact('ports')
        );


    }


}
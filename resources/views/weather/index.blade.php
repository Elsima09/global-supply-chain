@extends('layouts.dashboard')

@section('content')

@php
    $rain = $weather['current']['rain'] ?? 0;
    $wind = $weather['current']['wind_speed_10m'] ?? 0;
    $temp = $weather['current']['temperature_2m'] ?? 0;
@endphp

<div class="card futuristic-card border-0">

    <div class="card-body">

        <h2 class="mb-4"
            style="color:#38bdf8;text-shadow:0 0 12px #38bdf8;">
            🌦 Weather Monitoring
        </h2>

        {{-- Country --}}
        <form method="GET"
              action="{{ route('weather.index') }}"
              class="mb-4">

            <div class="row">

                <div class="col-md-10">

                    <select
                        name="country"
                        class="form-select">

                        @foreach($countries as $country)

                            <option
                                value="{{ $country->id }}"
                                {{ $selectedCountry->id == $country->id ? 'selected' : '' }}>

                                {{ $country->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-2">

                    <button class="btn btn-info w-100">

                        Load Weather

                    </button>

                </div>

            </div>

        </form>

        {{-- WEATHER TABLE --}}

        <div class="table-responsive">

            <table class="table table-bordered futuristic-table align-middle">

                <thead>

                    <tr>

                        <th>Country</th>
                        <th>Temperature</th>
                        <th>Rainfall</th>
                        <th>Wind</th>
                        <th>Status</th>
                        <th>Rain Status</th>
                        <th>Wind Status</th>
                        <th>Storm Risk</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>

                            {{ $selectedCountry->name }}

                        </td>

                        <td>

                            🌡 {{ $temp }} °C

                        </td>

                        <td>

                            🌧 {{ $rain }} mm

                        </td>

                        <td>

                            💨 {{ $wind }} km/h

                        </td>

                        <td>

                            @if($temp > 30)

                                <span class="badge bg-warning">

                                    Hot

                                </span>

                            @else

                                <span class="badge bg-success">

                                    Normal

                                </span>

                            @endif

                        </td>

                        <td>

                            @if($rain >= 20)

                                <span class="badge bg-danger">

                                    Heavy Rain

                                </span>

                            @elseif($rain >= 5)

                                <span class="badge bg-warning text-dark">

                                    Light Rain

                                </span>

                            @else

                                <span class="badge bg-success">

                                    No Rain

                                </span>

                            @endif

                        </td>

                        <td>

                            @if($wind >= 50)

                                <span class="badge bg-danger">

                                    Strong Wind

                                </span>

                            @elseif($wind >= 25)

                                <span class="badge bg-warning text-dark">

                                    Moderate

                                </span>

                            @else

                                <span class="badge bg-success">

                                    Normal

                                </span>

                            @endif

                        </td>

                        <td>

                            @if($rain >= 20 && $wind >= 50)

                                <span class="badge bg-danger">

                                    HIGH

                                </span>

                            @elseif($rain >= 5 || $wind >= 25)

                                <span class="badge bg-warning text-dark">

                                    MEDIUM

                                </span>

                            @else

                                <span class="badge bg-success">

                                    LOW

                                </span>

                            @endif

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- ========================= --}}
{{-- GLOBAL WEATHER MAP --}}
{{-- ========================= --}}

<div class="card futuristic-card mt-4">

    <div class="card-body">

        <h4 class="text-info fw-bold mb-3">

            🗺 Global Weather Monitoring

        </h4>

        <div id="weatherMap"
             style="height:500px;border-radius:15px;">
        </div>

    </div>

</div>

<link rel="stylesheet"
      href="https://unpkg.com/leaflet/dist/leaflet.css">

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

document.addEventListener("DOMContentLoaded",function(){

    const map = L.map('weatherMap').setView(
        [
            {{ $selectedCountry->latitude }},
            {{ $selectedCountry->longitude }}
        ],
        5
    );

    L.tileLayer(

        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',

        {

            attribution:'© OpenStreetMap'

        }

    ).addTo(map);

    let color = "green";

    if({{ $rain }} >= 20 && {{ $wind }} >= 50){

        color = "red";

    }
    else if({{ $rain }} >= 5 || {{ $wind }} >= 25){

        color = "orange";

    }

    const icon = L.divIcon({

        className:'',

        html:`
        <div
        style="
            width:18px;
            height:18px;
            background:${color};
            border-radius:50%;
            border:3px solid white;
            box-shadow:0 0 12px ${color};
        ">
        </div>
        `

    });

    L.marker(

        [
            {{ $selectedCountry->latitude }},
            {{ $selectedCountry->longitude }}
        ],

        {

            icon:icon

        }

    )

    .addTo(map)

    .bindPopup(`

        <b>{{ $selectedCountry->name }}</b>

        <br>

        🌡 Temperature :
        {{ $temp }} °C

        <br>

        🌧 Rain :
        {{ $rain }} mm

        <br>

        💨 Wind :
        {{ $wind }} km/h

    `)

    .openPopup();

});

</script>

@endsection
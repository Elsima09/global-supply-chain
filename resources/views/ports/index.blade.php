@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">

    <div class="card-body">

        <h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Global Ports
</h2>
<form method="GET" action="{{ route('ports.index') }}" class="mb-4">
    <div style="display:flex; gap:10px;">
        <input 
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search port or country..."
            class="form-control"
            style="
                background:#0f172a;
                color:white;
                border:1px solid rgba(56,189,248,0.35);
            "
        >

        <button class="btn btn-info">
            Search
        </button>
    </div>
</form>

        <div id="map" style="
height:500px;
border-radius:18px;
overflow:hidden;
border:1px solid rgba(56,189,248,0.25);
box-shadow:0 0 20px rgba(56,189,248,0.15);
"></div>

    </div>

</div>

<div class="card futuristic-card border-0 mt-4">

    <div class="card-body">

        <table class="table table-bordered table-hover futuristic-table">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Port Name</th>
                    <th>Country</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                </tr>

            </thead>

            <tbody>

            @foreach($ports as $port)

                <tr>

                    <td>{{ $port->id }}</td>

                    <td>{{ $port->port_name }}</td>

                    <td>{{ $port->country->name ?? '-' }}</td>

                    <td>{{ $port->latitude }}</td>

                    <td>{{ $port->longitude }}</td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

document.addEventListener('DOMContentLoaded',function(){

    var map=L.map('map').setView([20,110],3);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
        attribution:'© OpenStreetMap'
    }).addTo(map);

    @foreach($ports as $port)

    L.marker([{{ $port->latitude }},{{ $port->longitude }}])
        .addTo(map)
        .bindPopup("<b>{{ $port->port_name }}</b><br>{{ $port->country->name ?? '-' }}");

    @endforeach

});

</script>

@endsection
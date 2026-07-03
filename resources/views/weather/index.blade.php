@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">

    <div class="card-body">

        <h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Weather Monitoring
</h2>

        <table class="table table-bordered futuristic-table">

            <thead>

                <tr>
                    <th>Country</th>
                    <th>Temperature</th>
                    <th>Rainfall</th>
                    <th>Wind</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

@foreach($weatherData as $item)

<tr>

<td>{{ $item['country'] }}</td>

<td>{{ $item['temperature'] }} °C</td>

<td>{{ $item['rainfall'] }} mm</td>

<td>{{ $item['wind'] }} km/h</td>

<td>

@if($item['temperature']>30)

<span style="
background:rgba(245,158,11,0.2);
color:#facc15;
padding:6px 12px;
border-radius:999px;
border:1px solid rgba(245,158,11,0.4);
">
Hot
</span>

@else

<span style="
background:rgba(34,197,94,0.15);
color:#86efac;
padding:6px 12px;
border-radius:999px;
border:1px solid rgba(34,197,94,0.35);
">
Normal
</span>

@endif

</td>

</tr>

@endforeach

</tbody>

        </table>

    </div>

</div>

@endsection
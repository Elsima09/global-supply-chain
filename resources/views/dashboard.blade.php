@extends('layouts.dashboard')

@section('content')

<div class="row g-4"
style="
margin-top:-65px;
position:relative;
z-index:20;
">
<div class="d-flex justify-content-between align-items-center mb-4">

    <h3
        class="fw-bold mb-0"
        style="color:#38bdf8;">
        📊 Global Risk Overview
    </h3>

    <div>

        <button
            id="refreshDashboard"
            class="btn btn-outline-info me-2">

            🔄 Refresh Dashboard

        </button>

        <form
            action="{{ route('countries.sync') }}"
            method="POST"
            class="d-inline">

            @csrf

            <button
                type="submit"
                class="btn btn-success">

                🌍 Sync Countries

            </button>

        </form>

    </div>

</div>
    <div class="col-md-3">
        <div class="card futuristic-card border-blue">
<div class="card-body">

    <h6 class="mb-2">
        🌍 Total Countries
    </h6>

    <small class="text-secondary">
        Countries monitored
    </small>

    <h1
id="countryCount"
class="counter mt-3"
    data-target="{{ $countryCount }}"
    style="
    color:#38bdf8;
    text-shadow:0 0 15px #38bdf8;
    letter-spacing:1px;
font-weight:700;">

        0

    </h1>

</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card futuristic-card border-red">
<div class="card-body">

    <h6 class="mb-2">
        🚨 High Risk
    </h6>

    <small class="text-secondary">
        Critical countries
    </small>

    <h1
    id="highRiskCount"
    class="counter mt-3"
    data-target="{{ $highRiskCount }}"
    style="
    color:#ef4444;
    text-shadow:0 0 15px #ef4444;
    letter-spacing:1px;
font-weight:700;">

        0

    </h1>

</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card futuristic-card border-green">
<div class="card-body">

    <h6 class="mb-2">
        🚢 Active Ports
    </h6>

    <small class="text-secondary">
        Ports operating
    </small>

    <h1
    id="portCount"
    class="counter mt-3"
    data-target="{{ $portCount }}"
    style="
    color:#22c55e;
    text-shadow:0 0 15px #22c55e;
    letter-spacing:1px;
font-weight:700;">

        0

    </h1>

</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card futuristic-card border-yellow">
<div class="card-body">

    <h6 class="mb-2">
        📰 News Alerts
    </h6>

    <small class="text-secondary">
        Latest alerts today
    </small>

    <h1
    id="newsCount"
    class="counter mt-3"
    data-target="{{ $newsCount }}"
    style="
    color:#facc15;
    text-shadow:0 0 15px #facc15;
    letter-spacing:1px;
font-weight:700;">

        0

    </h1>

</div>
        </div>
    </div>
</div>
<div class="row g-4 mt-4">

    @php
        $weatherScore = round($riskScores->avg('weather_score') ?? 0);
    @endphp

    <!-- Weather -->
    <div class="col-md-4">
        <div class="card futuristic-card border-info h-100">
            <div class="card-body">

                <h5>🌦 Weather Risk</h5>

                <h2 class="mt-3
                    @if($weatherScore>=70)
                        text-danger
                    @elseif($weatherScore>=40)
                        text-warning
                    @else
                        text-success
                    @endif">

                    @if($weatherScore>=70)
                        HIGH
                    @elseif($weatherScore>=40)
                        MEDIUM
                    @else
                        LOW
                    @endif

                </h2>

                <p class="text-secondary mb-2">
                    Average Score : {{ $weatherScore }}
                </p>

                <div class="progress" style="height:10px">

                    <div
                        class="progress-bar
                        @if($weatherScore>=70)
                            bg-danger
                        @elseif($weatherScore>=40)
                            bg-warning
                        @else
                            bg-success
                        @endif"
                        style="width:{{ $weatherScore }}%">
                    </div>

                </div>

            </div>
        </div>
    </div>
    

    <!-- Medium -->
    <div class="col-md-4">
        <div class="card futuristic-card border-warning h-100">
            <div class="card-body">

                <h5>🟡 Medium Risk</h5>

                <h1 class="text-warning mt-3">
                    {{ $mediumRiskCount }}
                </h1>

                <p class="text-secondary">
                    Countries currently under monitoring
                </p>

            </div>
        </div>
    </div>

    <!-- Low -->
    <div class="col-md-4">
        <div class="card futuristic-card border-success h-100">
            <div class="card-body">

                <h5>🟢 Low Risk</h5>

                <h1 class="text-success mt-3">
                    {{ $lowRiskCount }}
                </h1>

                <p class="text-secondary">
                    Countries with stable supply chain
                </p>

            </div>
        </div>
    </div>
    </div> 

    <div class="card futuristic-card border-0 mt-4">
    <div class="card-body">
        <h4>Country Risk Overview</h4>
        <canvas id="riskChart" height="100"></canvas>
    </div>
</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">
        <h4>Global Ports Map</h4>

        <div id="map" style="height:500px;"></div>
    </div>
</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">

        <h4>AI Recommendation</h4>

        <div style="
background:rgba(34,211,238,0.12);
border:1px solid rgba(34,211,238,0.3);
color:#67e8f9;
padding:20px;
border-radius:14px;
">
            <h5>
    {{ $recommendation['status'] }}
</h5>

<p>
    {{ $recommendation['message'] }}
</p>

<hr>

<ul>
@foreach($recommendation['actions'] as $action)

<li>
    {{ $action }}
</li>

@endforeach
</ul>
        </div>

    </div>
</div>

@php
$topRisk = $riskScores->sortByDesc('total_score')->first();
@endphp

<div class="row g-4 mt-4">

    <div class="col-md-6">

        {{-- Highest Risk Country --}}

        <div class="card futuristic-card border-0">
    <div class="card-body">

        <h4>🌍 Highest Risk Country</h4>

        @if($topRisk)
            <h2 class="text-danger">
                {{ optional($topRisk->country)->name }}
            </h2>

            <p>
                Risk Score : {{ $topRisk->total_score }}
            </p>

            <span class="badge bg-danger">
                {{ $topRisk->risk_level }}
            </span>
        @endif

    </div>
</div>

    </div>

    <div class="col-md-6">

        {{-- Last API Refresh --}}

        <div class="card futuristic-card border-0">
    <div class="card-body">

        <h4>🕒 Last API Refresh</h4>

        <h5 class="text-info">
            {{ optional($riskScores->sortByDesc('updated_at')->first())->updated_at?->format('d M Y H:i') ?? '-' }}
        </h5>

    </div>
</div>

    </div>

</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">

        <h4>Latest Country Risk</h4>

        <table class="table table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Country</th>
                    <th>Total Score</th>
                    <th>Risk Level</th>
                </tr>
            </thead>

            <tbody>

            @foreach($topRiskScores as $risk)

                <tr>

                    <td>{{ $risk->country->name }}</td>

                    <td>{{ $risk->total_score }}</td>

                    <td>

                        @if($risk->risk_level=="High")

                            <span class="badge bg-danger">High</span>

                        @elseif($risk->risk_level=="Medium")

                            <span class="badge bg-warning">Medium</span>

                        @else

                            <span class="badge bg-success">Low</span>

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>
</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">
        <h4>Welcome to Supply Chain AI Dashboard</h4>
        <p>Monitor weather, economy, logistics, ports, and global risk.</p>
    </div>
</div>

@php
    $avgRisk = round($riskScores->avg('total_score'));
@endphp

@if($avgRisk >= 70)
<div style="
margin-top:24px;
background:rgba(239,68,68,0.12);
border:1px solid rgba(239,68,68,0.35);
color:#fca5a5;
padding:22px;
border-radius:18px;
box-shadow:0 0 20px rgba(239,68,68,0.15);
">
    <h5>⚠ High Risk Alert</h5>
    <p class="mb-0">
        Severe disruption detected. Immediate action required.
    </p>
</div>

@elseif($avgRisk >= 40)
<div style="
margin-top:24px;
background:rgba(245,158,11,0.12);
border:1px solid rgba(245,158,11,0.35);
color:#fde68a;
padding:22px;
border-radius:18px;
box-shadow:0 0 20px rgba(245,158,11,0.15);
">
    <h5>⚠ Medium Risk Alert</h5>
    <p class="mb-0">
        Some disruptions detected. Monitor closely.
    </p>
</div>

@else
<div style="
margin-top:24px;
background:rgba(34,197,94,0.12);
border:1px solid rgba(34,197,94,0.35);
color:#86efac;
padding:22px;
border-radius:18px;
box-shadow:0 0 20px rgba(34,197,94,0.15);
">
    <h5>✓ Low Risk</h5>
    <p class="mb-0">
        Supply chain conditions are stable.
    </p>
</div>
@endif


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('riskChart');

    new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
@foreach($riskScores as $risk)
'{{ optional($risk->country)->name }}',
@endforeach
        ],
        datasets: [{
    label: 'Risk Score',
    backgroundColor:'rgba(56,189,248,0.45)',
    borderColor:'#38bdf8',
            data: [
@foreach($riskScores as $risk)
{{ $risk->total_score }},
@endforeach
            ],
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: 'rgba(255,255,255,0.08)'
                }
            },
            y: {
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: 'rgba(255,255,255,0.08)'
                }
            }
        }
    }
});
});
    </script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    var map = L.map('map').setView([20,110], 3);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
        attribution:'© OpenStreetMap'
    }).addTo(map);

@foreach($ports as $port)

L.marker([
    {{ $port->latitude }},
    {{ $port->longitude }}
])

.addTo(map)

.bindPopup(`
<b>🚢 {{ $port->port_name }}</b><br>

Country : {{ $port->country }}<br>

Status : {{ $port->status }}<br>

Delay : {{ $port->delay_hours }} Hours

`);

@endforeach

});
</script>
<script>

document.getElementById('refreshDashboard').addEventListener('click', function(){

    fetch("{{ route('dashboard.refresh') }}")

    .then(response => response.json())

    .then(data => {

        document.getElementById('countryCount').innerText =
            data.countryCount;

        document.getElementById('highRiskCount').innerText =
            data.highRiskCount;

        document.getElementById('portCount').innerText =
            data.portCount;

        document.getElementById('newsCount').innerText =
            data.newsCount;

        alert("✅ Dashboard berhasil diperbarui!");

    })

    .catch(error => {

        console.error(error);

        alert("❌ Gagal mengambil data.");

    });

});

</script>

@endsection
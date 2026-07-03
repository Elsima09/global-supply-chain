@extends('layouts.dashboard')

@section('content')

<div class="row g-4">
    <div class="col-md-3">
        <div class="card futuristic-card border-blue">
            <div class="card-body">
                <h6>Total Countries</h6>
                <small style="color:#94a3b8">Countries monitored</small>
                <h2 class="counter"
                    data-target="{{ $countryCount }}"
                    style="color:#38bdf8; text-shadow:0 0 15px #38bdf8;">
                    0
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card futuristic-card border-red">
            <div class="card-body">
                <h6>High Risk Countries</h6>
                <small style="color:#94a3b8">Critical countries</small>
                <h2 class="counter"
                    data-target="{{ $highRiskCount }}"
                    style="color:#ef4444; text-shadow:0 0 15px #ef4444;">
                    0
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card futuristic-card border-green">
            <div class="card-body">
                <h6>Active Ports</h6>
                <small style="color:#94a3b8">Ports operating</small>
                <h2 class="counter"
                    data-target="{{ $portCount }}"
                    style="color:#22c55e; text-shadow:0 0 15px #22c55e;">
                    0
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card futuristic-card border-yellow">
            <div class="card-body">
                <h6>News Alerts</h6>
                <small style="color:#94a3b8">Latest alerts today</small>
                <h2 class="counter"
                    data-target="{{ $newsCount }}"
                    style="color:#facc15; text-shadow:0 0 15px #facc15;">
                    0
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="row g-4 mt-1">
    <div class="col-md-3">
        <div class="card futuristic-card border-0">
            <div class="card-body">
                <h6>Weather Risk</h6>
                @if(round($riskScores->avg('weather_score')) >= 70)
    <h3 class="text-danger">High</h3>
@elseif(round($riskScores->avg('weather_score')) >= 40)
    <h3 class="text-warning">Medium</h3>
@else
    <h3 class="text-success">Low</h3>
@endif
            </div>
        </div>
    </div>
</div>

<div class="card futuristic-card border-0 mt-4">

    <div class="card-body">

        <h4>Risk Trend</h4>

        <canvas id="trendChart"></canvas>

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

            @foreach($riskScores as $risk)

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
            {{ $recommendation }}
        </div>

    </div>
</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">
        <h4>Country Risk Overview</h4>
        <canvas id="riskChart" height="100"></canvas>
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

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">
        <h4>Global Ports Map</h4>

        <div id="map" style="height:500px;"></div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('riskChart');

    new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
@foreach($riskScores as $risk)
'{{ $risk->country->name }}',
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
    const trendCtx = document.getElementById('trendChart');

new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        datasets: [{
    label: 'Global Risk',
    borderColor:'#38bdf8',
    backgroundColor:'rgba(56,189,248,0.2)',
    pointBackgroundColor:'#38bdf8',
    tension:0.4,
            data: [
                {{ round($riskScores->avg('total_score')) - 8 }},
                {{ round($riskScores->avg('total_score')) - 4 }},
                {{ round($riskScores->avg('total_score')) - 2 }},
                {{ round($riskScores->avg('total_score')) }},
                {{ round($riskScores->avg('total_score')) + 3 }},
                {{ round($riskScores->avg('total_score')) - 1 }},
                {{ round($riskScores->avg('total_score')) }}
            ],
            borderWidth: 3,
            fill: false
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
L.marker([{{ $port->latitude }}, {{ $port->longitude }}])
    .addTo(map)
    .bindPopup("{{ $port->port_name }}");
@endforeach

});
</script>

@endsection
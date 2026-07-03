@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">
    <div class="card-body">

        <h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Country Comparison
</h2>
        <table class="table table-bordered futuristic-table">

    <thead>
        <tr>
            <th>Country</th>
            <th>GDP</th>
            <th>Inflation</th>
            <th>Export</th>
            <th>Import</th>
            <th>Weather Score</th>
            <th>Currency Score</th>
            <th>News Score</th>
            <th>Total Score</th>
            <th>Risk Level</th>
        </tr>
    </thead>

    <tbody>
    @foreach($comparison as $risk)
        <tr>
            <td>{{ $risk->country->name }}</td>
            <td>${{ number_format($risk->country->gdp, 0) }}</td>
            <td>{{ $risk->country->inflation_rate }}%</td>
            <td>${{ number_format($risk->country->export_value, 0) }}</td>
            <td>${{ number_format($risk->country->import_value, 0) }}</td>
            <td>{{ $risk->weather_score }}</td>
            <td>{{ $risk->currency_score }}</td>
            <td>{{ $risk->news_score }}</td>
            <td>{{ $risk->total_score }}</td>
            <td>
                @if($risk->risk_level == 'High')
                    <span style="
background:rgba(239,68,68,0.15);
color:#fca5a5;
padding:6px 12px;
border-radius:999px;
border:1px solid rgba(239,68,68,0.35);
">High</span>
                @elseif($risk->risk_level == 'Medium')
                    <span style="
background:rgba(245,158,11,0.15);
color:#fde68a;
padding:6px 12px;
border-radius:999px;
border:1px solid rgba(245,158,11,0.35);
">Medium</span>
                @else
                    <span style="
background:rgba(34,197,94,0.15);
color:#86efac;
padding:6px 12px;
border-radius:999px;
border:1px solid rgba(34,197,94,0.35);
">Low</span>
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
        <h4>Risk Comparison Chart</h4>

        <div style="width:100%; height:350px;">
    <canvas id="comparisonChart"></canvas>
</div>
    </div>
</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">
        <h4 style="color:#38bdf8; text-shadow:0 0 10px #38bdf8;">
            GDP Comparison Chart
        </h4>
        <div style="width:100%; height:350px;">
    <canvas id="gdpChart"></canvas>
</div>
    </div>
</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">
        <h4 style="color:#38bdf8; text-shadow:0 0 10px #38bdf8;">
            Inflation Trend Chart
        </h4>

        <div style="width:100%; height:350px;">
            <canvas id="inflationChart"></canvas>
        </div>
    </div>
</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">
        <h4 style="color:#38bdf8; text-shadow:0 0 10px #38bdf8;">
            Currency Trend Chart
        </h4>

        <div style="width:100%; height:350px;">
            <canvas id="currencyChart"></canvas>
        </div>
    </div>
</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">
        <h4 style="color:#38bdf8; text-shadow:0 0 10px #38bdf8;">
            Risk Trend Chart
        </h4>

        <div style="width:100%; height:350px;">
            <canvas id="riskTrendChart"></canvas>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('comparisonChart');

    new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
@foreach($comparison as $risk)
'{{ $risk->country->name }}',
@endforeach
        ],
        datasets: [{
            label: 'Risk Score',
            backgroundColor:'rgba(56,189,248,0.45)',
            borderColor:'#38bdf8',
            data: [
@foreach($comparison as $risk)
{{ $risk->total_score }},
@endforeach
            ],
            borderWidth: 1
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{
                labels:{ color:'white' }
            }
        },
        scales:{
            x:{
                ticks:{ color:'white' }
            },
            y:{
                ticks:{ color:'white' }
            }
        }
    }
});
    const gdpCtx = document.getElementById('gdpChart');

new Chart(gdpCtx, {
    type: 'line',
    data: {
        labels: [
@foreach($gdpTrend as $item)
'{{ $item->year }}',
@endforeach
        ],
        datasets: [{
            label: 'GDP Trend Indonesia (Billion USD)',
            backgroundColor: 'rgba(34,197,94,0.25)',
            borderColor: '#22c55e',
            data: [
@foreach($gdpTrend as $item)
{{ round($item->gdp / 1000000000, 2) }},
@endforeach
            ],
            tension: 0.3,
            fill: true,
            borderWidth: 2
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{
                labels:{ color:'white' }
            }
        },
        scales:{
            x:{
                ticks:{ color:'white' },
                grid:{ color:'rgba(255,255,255,0.08)' }
            },
            y:{
                ticks:{ color:'white' },
                grid:{ color:'rgba(255,255,255,0.08)' }
            }
        }
    }
});

const inflationCtx = document.getElementById('inflationChart');

new Chart(inflationCtx, {
    type: 'line',
    data: {
        labels: [
@foreach($gdpTrend as $item)
'{{ $item->year }}',
@endforeach
        ],
        datasets: [{
            label: 'Inflation Trend Indonesia (%)',
            backgroundColor: 'rgba(245,158,11,0.2)',
            borderColor: '#f59e0b',
            data: [
@foreach($gdpTrend as $item)
{{ $item->inflation }},
@endforeach
            ],
            tension: 0.3,
            fill: true,
            borderWidth: 2
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{
                labels:{ color:'white' }
            }
        },
        scales:{
            x:{
                ticks:{ color:'white' }
            },
            y:{
                ticks:{ color:'white' }
            }
        }
    }
});
const currencyCtx = document.getElementById('currencyChart');

new Chart(currencyCtx, {
    type: 'line',
    data: {
        labels: [
@foreach($currencyTrend as $item)
'{{ $item->year }}',
@endforeach
        ],
        datasets: [{
            label: 'USD to IDR Trend',
            backgroundColor: 'rgba(168,85,247,0.2)',
            borderColor: '#a855f7',
            data: [
@foreach($currencyTrend as $item)
{{ round($item->rate, 2) }},
@endforeach
            ],
            tension: 0.3,
            fill: true,
            borderWidth: 2
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{
                labels:{ color:'white' }
            }
        },
        scales:{
            x:{
                ticks:{ color:'white' }
            },
            y:{
                ticks:{ color:'white' }
            }
        }
    }
});
const riskTrendCtx = document.getElementById('riskTrendChart');

new Chart(riskTrendCtx, {
    type: 'line',
    data: {
        labels: [
@foreach($riskTrend as $item)
'{{ \Carbon\Carbon::parse($item->recorded_at)->format("Y") }}',
@endforeach
        ],
        datasets: [{
            label: 'Risk Trend Indonesia',
            backgroundColor: 'rgba(239,68,68,0.2)',
            borderColor: '#ef4444',
            data: [
@foreach($riskTrend as $item)
{{ $item->risk_score }},
@endforeach
            ],
            tension: 0.3,
            fill: true,
            borderWidth: 2
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{
                labels:{ color:'white' }
            }
        },
        scales:{
            x:{
                ticks:{ color:'white' }
            },
            y:{
                ticks:{ color:'white' }
            }
        }
    }
});
});
</script>

@endsection
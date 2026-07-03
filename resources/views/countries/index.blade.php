@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">
    <div class="card-body">
        <h3 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">Countries Data</h3>

        <table class="table table-bordered table-hover futuristic-table">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>Code</th>
                    <th>Region</th>
                    <th>Currency</th>
                    <th>Population</th>
                    <th>GDP (USD)</th>
                    <th>Export</th>
                    <th>Import</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->code }}</td>
                    <td>{{ $country->region }}</td>
                    <td>{{ $country->currency_code }}</td>
                    <td>{{ number_format($country->population) }}</td>
                    <td>${{ number_format($country->gdp, 0) }}</td>
                    <td>${{ number_format($country->export_value, 0) }}</td>
                    <td>${{ number_format($country->import_value, 0) }}</td>
                    <td>
    @if(in_array($country->id, $watchlistedCountryIds))
    <button class="btn btn-sm btn-success" disabled>
        ✓ Added
    </button>
@else
    <form action="{{ route('watchlist.store') }}" method="POST">
        @csrf
        <input type="hidden" name="country_id" value="{{ $country->id }}">

        <button class="btn btn-sm btn-primary">
            Add to Watchlist
        </button>
    </form>
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
        <h4 style="color:#38bdf8; text-shadow:0 0 10px #38bdf8;">
            Inflation Trend Chart
        </h4>

        <div style="width:100%; height:350px;">
            <canvas id="inflationChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inflationCtx = document.getElementById('inflationChart');

    new Chart(inflationCtx, {
        type: 'line',
        data: {
            labels: [
@foreach($countries as $country)
'{{ $country->name }}',
@endforeach
            ],
            datasets: [{
                label: 'Inflation Rate (%)',
                data: [
@foreach($countries as $country)
{{ $country->inflation_rate }},
@endforeach
                ],
                borderColor: '#38bdf8',
                backgroundColor: 'rgba(56,189,248,0.2)',
                pointBackgroundColor: '#38bdf8',
                tension: 0.4,
                fill: true
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
});
</script>

@endsection
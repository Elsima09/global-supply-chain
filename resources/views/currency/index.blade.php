@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">
    <div class="card-body">
        <h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">Currency Monitoring</h2>

        <table class="table table-bordered table-hover futuristic-table">
            <thead class="table-primary">
                <tr>
                    <th>Country</th>
                    <th>Currency</th>
                    <th>Rate to USD</th>
                    <th>Trend</th>
                </tr>
            </thead>

            <tbody>

@foreach($currencyData as $item)
<tr>
    <td>{{ $item['country'] }}</td>
    <td>{{ $item['currency'] }}</td>
    <td>{{ $item['rate'] }}</td>

    <td>
        @if($item['rate'] > 100)
            <span class="badge bg-danger">High</span>
        @elseif($item['rate'] > 1)
            <span class="badge bg-warning">Medium</span>
        @else
            <span class="badge bg-success">Base</span>
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
            Currency Trend Chart
        </h4>

        <div style="width:100%; height:350px;">
            <canvas id="currencyChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const currencyCtx = document.getElementById('currencyChart');

    new Chart(currencyCtx, {
        type: 'line',
        data: {
            labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            datasets: [{
                label: 'USD Exchange Trend',
                data: [16200,16150,16180,16240,16220,16270,16250],
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
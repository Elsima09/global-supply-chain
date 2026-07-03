@extends('layouts.dashboard')

@section('content')

@php
$highCount = $watchlists->filter(function($item){
    return optional($item->country->riskScore)->risk_level === 'High';
})->count();

$mediumCount = $watchlists->filter(function($item){
    return optional($item->country->riskScore)->risk_level === 'Medium';
})->count();

$lowCount = $watchlists->filter(function($item){
    return optional($item->country->riskScore)->risk_level === 'Low';
})->count();
@endphp

<div class="row g-4">

    <div class="col-md-4">
        <div class="card futuristic-card border-0">
            <div class="card-body">
                <h6>Total Watchlist</h6>
                <h2 style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
                    {{ $watchlists->count() }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card futuristic-card border-0">
            <div class="card-body">
                <h6>High Risk</h6>
                <h2 style="color:#ef4444; text-shadow:0 0 12px #ef4444;">
                    {{ $highCount }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card futuristic-card border-0">
            <div class="card-body">
                <h6>Low & Medium</h6>
                <h2 style="color:#22c55e; text-shadow:0 0 12px #22c55e;">
                    {{ $mediumCount + $lowCount }}
                </h2>
            </div>
        </div>
    </div>

</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">

        <h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
            Watchlist Monitoring
        </h2>

        <table class="table table-bordered table-hover align-middle futuristic-table">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>Risk</th>
                    <th>Currency</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($watchlists as $item)

                @php
                    $risk = optional($item->country->riskScore);
                    $riskLevel = $risk->risk_level ?? 'Low';
                @endphp

                <tr>
                    <td>{{ $item->country->name }}</td>

                    <td>
                        @if($riskLevel == "High")
                            <span class="badge bg-danger">High</span>
                        @elseif($riskLevel == "Medium")
                            <span class="badge bg-warning text-dark">Medium</span>
                        @else
                            <span class="badge bg-success">Low</span>
                        @endif
                    </td>

                    <td>{{ $item->country->currency_code }}</td>

                    <td>
                        @if($riskLevel == "High")
                            🔴 Immediate Monitoring
                        @elseif($riskLevel == "Medium")
                            🟡 Watch Closely
                        @else
                            🟢 Stable
                        @endif
                    </td>

                    <td>
    <form action="{{ route('watchlist.destroy', $item->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button class="btn btn-danger btn-sm"
            onclick="return confirm('Remove from watchlist?')">
            Remove
        </button>
    </form>
</td>
                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        No countries in watchlist yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">

        <h4>Watchlist Risk Distribution</h4>

        <canvas id="watchChart"></canvas>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const ctx = document.getElementById('watchChart');

    new Chart(ctx,{
        type:'doughnut',
        data:{
            labels:['High','Medium','Low'],
            datasets:[{
                backgroundColor:[
                    '#ef4444',
                    '#facc15',
                    '#22c55e'
                ],
                borderWidth:0,
                data:[
                    {{ $highCount }},
                    {{ $mediumCount }},
                    {{ $lowCount }}
                ]
            }]
        }
    });

});
</script>

@endsection
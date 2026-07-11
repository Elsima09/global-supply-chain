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

<td>
{{ $risk->country->name }}
</td>


<td>
${{ number_format($risk->country->economic->gdp ?? 0,0) }}
</td>


<td>
{{ $risk->country->economic->inflation ?? 0 }}%
</td>


<td>

@if(($risk->country->economic->exports ?? 0) > 0)

${{ number_format($risk->country->economic->exports,0) }}

@else

<span style="color:#64748b">
No Data
</span>

@endif

</td>


<td>

@if(($risk->country->economic->imports ?? 0) > 0)

${{ number_format($risk->country->economic->imports,0) }}

@else

<span style="color:#64748b">
No Data
</span>

@endif

</td>


<td>
{{ $risk->weather_score }}
</td>


<td>
{{ $risk->currency_score }}
</td>


<td>
{{ $risk->news_score }}
</td>


<td>
{{ $risk->total_score }}
</td>


<td>

@if($risk->risk_level == 'High')

<span class="badge bg-danger">
High
</span>

@elseif($risk->risk_level == 'Medium')

<span class="badge bg-warning">
Medium
</span>

@else

<span class="badge bg-success">
Low
</span>

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

document.addEventListener('DOMContentLoaded',()=>{


// =====================
// RISK COMPARISON
// =====================

new Chart(
document.getElementById('comparisonChart'),
{

type:'bar',

data:{

labels:[
@foreach($comparison as $risk)
'{{ $risk->country->name }}',
@endforeach
],


datasets:[{

label:'Risk Score',

data:[
@foreach($comparison as $risk)
{{ $risk->total_score }},
@endforeach
],


backgroundColor:'rgba(56,189,248,.45)',

borderColor:'#38bdf8',

borderWidth:1


}]


},


options:{

responsive:true,

maintainAspectRatio:false


}

});




// =====================
// GDP CHART
// =====================


new Chart(

document.getElementById('gdpChart'),

{


type:'line',


data:{


labels:[

@foreach($gdpTrend as $item)

'{{ $item->year }}',

@endforeach

],



datasets:[{


label:'GDP Indonesia (Billion USD)',


data:[

@foreach($gdpTrend as $item)

{{ round($item->gdp/1000000000,2) }},

@endforeach

],


borderColor:'#22c55e',

backgroundColor:'rgba(34,197,94,.2)',


fill:true,

tension:.3


}]


},


options:{

responsive:true,

maintainAspectRatio:false


}


});




// =====================
// INFLATION CHART
// =====================


new Chart(

document.getElementById('inflationChart'),

{


type:'line',


data:{


labels:[

@foreach($gdpTrend as $item)

'{{ $item->year }}',

@endforeach

],


datasets:[{


label:'Inflation (%)',


data:[

@foreach($gdpTrend as $item)

{{ $item->inflation }},

@endforeach

],


borderColor:'#f59e0b',

backgroundColor:'rgba(245,158,11,.2)',


fill:true,

tension:.3


}]


},


options:{

responsive:true,

maintainAspectRatio:false

}


});




// =====================
// CURRENCY CHART
// =====================


new Chart(

document.getElementById('currencyChart'),

{


type:'line',


data:{


labels:[

@foreach($currencyTrend as $item)

'{{ $item->created_at->format("Y") }}',

@endforeach

],


datasets:[{


label:'USD IDR',


data:[

@foreach($currencyTrend as $item)

{{ $item->rate }},

@endforeach

],


borderColor:'#a855f7',

backgroundColor:'rgba(168,85,247,.2)',


fill:true,

tension:.3


}]


},


options:{

responsive:true,

maintainAspectRatio:false

}


});




// =====================
// RISK TREND
// =====================


new Chart(

document.getElementById('riskTrendChart'),

{


type:'line',


data:{


labels:[

@foreach($riskTrend as $item)

'{{ \Carbon\Carbon::parse($item->recorded_at)->format("Y") }}',

@endforeach

],


datasets:[{


label:'Risk History',


data:[

@foreach($riskTrend as $item)

{{ $item->risk_score }},

@endforeach

],


borderColor:'#ef4444',

backgroundColor:'rgba(239,68,68,.2)',


fill:true,

tension:.3


}]


},


options:{

responsive:true,

maintainAspectRatio:false

}


});



});


</script>

@endsection
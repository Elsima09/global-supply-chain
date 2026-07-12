@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">
<div class="card-body">


<h2 class="mb-4" style="color:#38bdf8;">
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
@if(($risk->country->economic->exports ?? 0)>0)

${{ number_format($risk->country->economic->exports,0) }}

@else

No Data

@endif
</td>


<td>
@if(($risk->country->economic->imports ?? 0)>0)

${{ number_format($risk->country->economic->imports,0) }}

@else

No Data

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

@if($risk->risk_level=="High")

<span class="badge bg-danger">
High
</span>

@elseif($risk->risk_level=="Medium")

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




{{-- CHART AREA --}}


@php

$gdpYears = $gdpTrend->pluck('year');

$gdpValues = $gdpTrend->map(function($item){

return round($item->gdp / 1000000000,2);

});


$inflationValues = $gdpTrend->pluck('inflation');


$currencyYears = $currencyTrend->map(function($item){

return $item->created_at->format('d M');

});


$currencyValues = $currencyTrend->pluck('rate');


$riskYears = $riskTrend->map(function($item){

return \Carbon\Carbon::parse(
$item->recorded_at
)->format('d M');

});


$riskValues = $riskTrend->pluck('risk_score');


@endphp





<div class="card futuristic-card border-0 mt-4">

<div class="card-body">

<h4>
Risk Comparison Chart
</h4>

<div style="height:350px">

<canvas id="comparisonChart"></canvas>

</div>

</div>

</div>





<div class="card futuristic-card border-0 mt-4">

<div class="card-body">

<h4>
GDP Comparison Chart
</h4>


<div style="height:350px">

<canvas id="gdpChart"></canvas>

</div>


</div>

</div>





<div class="card futuristic-card border-0 mt-4">

<div class="card-body">

<h4>
Inflation Trend Chart
</h4>


<div style="height:350px">

<canvas id="inflationChart"></canvas>

</div>

</div>

</div>





<div class="card futuristic-card border-0 mt-4">

<div class="card-body">

<h4>
Currency Trend Chart
</h4>


<div style="height:350px">

<canvas id="currencyChart"></canvas>

</div>


</div>

</div>





<div class="card futuristic-card border-0 mt-4">

<div class="card-body">

<h4>
Risk Trend Chart
</h4>


<div style="height:350px">

<canvas id="riskTrendChart"></canvas>

</div>


</div>

</div>






<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


document.addEventListener(
'DOMContentLoaded',
function(){



// =================
// RISK COMPARISON
// =================


new Chart(
document.getElementById('comparisonChart'),
{


type:'bar',


data:{


labels:@json(
$comparison->pluck('country.name')
),


datasets:[{

label:'Risk Score',

data:@json(
$comparison->pluck('total_score')
),


backgroundColor:
'rgba(56,189,248,0.5)'


}]


},


options:{

responsive:true,

maintainAspectRatio:false


}


});






// =================
// GDP
// =================


new Chart(
document.getElementById('gdpChart'),
{


type:'line',


data:{


labels:@json($gdpYears),


datasets:[{

label:'GDP Billion USD',


data:@json($gdpValues),


borderColor:'#22c55e',

backgroundColor:
'rgba(34,197,94,.2)',


fill:true,

tension:.3


}]


},


options:{

responsive:true,

maintainAspectRatio:false

}


});







// =================
// INFLATION
// =================


new Chart(
document.getElementById('inflationChart'),
{


type:'line',


data:{


labels:@json($gdpYears),


datasets:[{

label:'Inflation %',


data:@json($inflationValues),


borderColor:'#f59e0b',

backgroundColor:
'rgba(245,158,11,.2)',


fill:true,

tension:.3


}]


},


options:{

responsive:true,

maintainAspectRatio:false

}


});







// =================
// CURRENCY
// =================


new Chart(
document.getElementById('currencyChart'),
{


type:'line',


data:{


labels:@json($currencyYears),


datasets:[{

label:'USD IDR',


data:@json($currencyValues),


borderColor:'#a855f7',

backgroundColor:
'rgba(168,85,247,.2)',


fill:true,

tension:.3


}]


},


options:{

responsive:true,

maintainAspectRatio:false

}


});







// =================
// RISK HISTORY
// =================


new Chart(
document.getElementById('riskTrendChart'),
{


type:'line',


data:{


labels:@json($riskYears),


datasets:[{

label:'Risk History',


data:@json($riskValues),


borderColor:'#ef4444',

backgroundColor:
'rgba(239,68,68,.2)',


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
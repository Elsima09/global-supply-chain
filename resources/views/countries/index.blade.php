@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card futuristic-card border-0 shadow-sm">

        <div class="card-body">

            <h2 class="text-info fw-bold">
                🌍 Country Explorer
            </h2>

            <p class="text-secondary mb-4">
                Explore country information, weather conditions, economy and AI risk analysis.
            </p>

            <form method="GET" action="{{ route('countries.index') }}">

                <div class="row">

                    <div class="col-md-5">

                        <select
                            name="country"
                            class="form-select"
                            onchange="this.form.submit()">

                            @foreach($countries as $country)

                                <option
                                    value="{{ $country->id }}"
                                    {{ $selectedCountry->id == $country->id ? 'selected' : '' }}>

                                    {{ $country->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </form>

        </div>

    </div>


{{-- ========================= --}}
{{-- TRANSPORT ANALYSIS --}}
{{-- ========================= --}}

<div class="card futuristic-card border-0 mt-4">

<div class="card-body">


<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h3 class="text-info fw-bold">

🚢 Transport Analysis

</h3>

<small class="text-secondary">

Logistics monitoring for {{ $selectedCountry->name }}

</small>

</div>


<span class="badge bg-info fs-6">

{{ $ports->count() }} Ports

</span>


</div>



@if($ports->count())


<div class="row g-4">


@foreach($ports as $port)


<div class="col-lg-6">


<div class="card futuristic-card h-100">


<div class="card-body">



<h4 class="text-white mb-4">

🚢 {{ $port->port_name }}

</h4>



<div class="row">



{{-- STATUS --}}

<div class="col-md-6 mb-3">


<small class="text-secondary">

Status

</small>


<br>


@if($port->status=="active")


<span class="badge bg-success">

🟢 Active

</span>


@elseif($port->status=="maintenance")


<span class="badge bg-warning text-dark">

🟡 Maintenance

</span>


@else


<span class="badge bg-danger">

🔴 Closed

</span>


@endif


</div>




{{-- COUNTRY --}}

<div class="col-md-6 mb-3">


<small class="text-secondary">

Country

</small>


<h6 class="text-info">

🌎 {{ $selectedCountry->name }}

</h6>


</div>






{{-- LOCATION --}}

<div class="col-md-6 mb-3">


<small class="text-secondary">

Coordinates

</small>


<h6 class="text-white">

📍

{{ $port->latitude }},

{{ $port->longitude }}

</h6>


</div>






{{-- CONGESTION --}}

<div class="col-md-6 mb-3">


<small class="text-secondary">

Congestion

</small>


<br>


@php

$congestion =
strtolower($port->congestion ?? 'low');


@endphp



@if($congestion=="high")


<span class="badge bg-danger">

🚚 High

</span>


@elseif($congestion=="medium")


<span class="badge bg-warning text-dark">

🚚 Medium

</span>


@else


<span class="badge bg-success">

🚚 Low

</span>


@endif


</div>



</div>



<hr>



{{-- AI RISK --}}

<div class="text-center">


<small class="text-secondary">

AI Country Logistics Risk Score

</small>



@php

$portRisk =
$selectedCountry->riskScore?->logistics_score ?? 0;


$riskColor="success";


if($portRisk >=70){

    $riskColor="danger";

}

elseif($portRisk >=40){

    $riskColor="warning";

}

@endphp


<h1 class="text-{{ $riskColor }} fw-bold">

{{ $portRisk }}

</h1>



@if($portRisk>=70)


<span class="badge bg-danger">

🔴 High Risk

</span>


@elseif($portRisk>=40)


<span class="badge bg-warning text-dark">

🟡 Medium Risk

</span>


@else


<span class="badge bg-success">

🟢 Low Risk

</span>


@endif



<div class="progress mt-3">


<div

class="progress-bar bg-{{ $riskColor }}"

style="width:{{ $portRisk }}%">

</div>


</div>


</div>



</div>


</div>


</div>


@endforeach



</div>



@else


<div class="text-center text-secondary">

No port data available

</div>


@endif



</div>

</div>

{{-- ========================= --}}
{{-- HISTORICAL ANALYSIS --}}
{{-- ========================= --}}

<div class="card futuristic-card border-0 mt-4">

    <div class="card-body">

        <h4 class="text-info fw-bold mb-4">
            📈 Historical Transport Analysis
        </h4>


       <div style="height:300px;">

    <canvas id="transportHistoryChart"></canvas>

</div>


    </div>

</div>

{{-- ========================= --}}
{{-- TRANSPORT PREDICTION --}}
{{-- ========================= --}}

<div class="card futuristic-card border-0 mt-4">

    <div class="card-body">

        <h4 class="text-info fw-bold mb-4">
            🤖 AI Transport Prediction
        </h4>

        <div class="row align-items-center">


            <div class="col-md-6 text-center">


                <small class="text-secondary">
                    Predicted Transport Risk
                </small>


<div
style="
font-size:85px;
font-weight:900;
color:#38bdf8;
text-shadow:
0 0 12px #38bdf8,
0 0 24px #38bdf8,
0 0 40px rgba(56,189,248,.6);
line-height:1;
">

{{ $prediction['score'] }}

</div>

<div class="mt-2">

<span class="badge bg-info px-3 py-2">

AI Predicted Score

</span>

</div>

                <div class="mt-3">

<small class="text-secondary">
AI Trend Analysis
</small>


@if($prediction['trend']=="Increasing")

<div class="alert alert-danger">

📈 <b>Risk Increasing</b>

</div>

@elseif($prediction['trend']=="Decreasing")

<div class="alert alert-success">

📉 <b>Risk Decreasing</b>

</div>

@else

<div class="alert alert-warning">

➡ <b>Stable Condition</b>

</div>

@endif

</div>


                @php

                    $predictionColor = 'success';


                    if($prediction['level']=="Medium"){

                        $predictionColor='warning';

                    }


                    if($prediction['level']=="High"){

                        $predictionColor='danger';

                    }

                @endphp


                <div class="mt-4">

<span
class="badge bg-{{ $predictionColor }}"
style="
font-size:18px;
padding:10px 22px;
">

{{ $prediction['level'] }}

</span>

</div>



            </div>



            <div class="col-md-6">


<div class="text-center">

    <canvas
        id="riskGauge"
        style="
            max-width:260px;
            margin:auto;
        ">
    </canvas>

 <div class="mt-3">

<h5>

Overall Supply Chain Health

</h5>

<small class="text-secondary">

AI evaluates transport history and predicts future disruption risk.

</small>

@php

$health = 100 - $prediction['score'];

@endphp

<h1
style="
font-size:64px;
font-weight:900;
color:#22c55e;
text-shadow:
0 0 10px #22c55e,
0 0 25px rgba(34,197,94,.5);
">

{{ $health }}%

</h1>

<small class="text-secondary">

Lower transport risk indicates a healthier supply chain.

</small>

</div>

</div>


            </div>


        </div>


    </div>

</div>

<hr>

@if($prediction['level']=="High")

<div class="alert alert-danger mt-4">

🚨 High disruption risk detected.

Immediate logistics mitigation is recommended.

</div>

@elseif($prediction['level']=="Medium")

<div class="alert alert-warning mt-4">

⚠ Moderate logistics disruption.

Increase monitoring frequency.

</div>

@else

<div class="alert alert-success mt-4">

✅ Supply chain is operating normally.

</div>

@endif

<div class="card futuristic-card border-0 mt-4">

    <div class="card-body">

        <h4 class="text-info fw-bold mb-4">
            🤖 AI Decision Support
        </h4>

        @php

            $decision = "Proceed Shipment";
            $decisionColor = "success";

            if($prediction['score'] >= 70){

                $decision = "Delay Shipment";
                $decisionColor = "danger";

            }
            elseif($prediction['score'] >= 40){

                $decision = "Monitor Before Shipment";
                $decisionColor = "warning";

            }

        @endphp

<h2 class="text-{{ $decisionColor }}">

@if($decisionColor=="danger")

⛔

@elseif($decisionColor=="warning")

⚠

@else

✅

@endif

{{ $decision }}

</h2>

        @php

$confidence = round(

100 -

(

(optional($riskScore)->weather_score ?? 0 +
optional($riskScore)->economic_score ?? 0+
optional($riskScore)->news_score ?? 0 +
optional($riskScore)->logistics_score ?? 0)

/

4

)

);

@endphp

<hr>

<h5 class="text-info">

AI Confidence

</h5>

<div
style="
font-size:42px;
font-weight:bold;
color:#22c55e;
text-shadow:0 0 10px #22c55e;
">

{{ $confidence }}%

</div>

<small class="text-secondary">

Confidence calculated from integrated AI risk analysis.

</small>

        <hr>

        <div class="row">

            <div class="col-md-6">

<h5 class="text-info mb-4">

📊 Decision Factors

</h5>

<!-- Weather -->
<div class="mb-3">

<div class="d-flex justify-content-between">
<span>🌦 Weather</span>
<span>{{ optional($riskScore)->weather_score ?? 0 }}</span>
</div>

<div class="progress" style="height:10px;">
<div class="progress-bar bg-info"
style="width:{{ optional($riskScore)->weather_score ?? 0 }}%">
</div>
</div>

</div>

<!-- Economy -->
<div class="mb-3">

<div class="d-flex justify-content-between">
<span>💰 Economy</span>
<span>{{ optional($riskScore)->economic_score ?? 0 }}</span>
</div>

<div class="progress" style="height:10px;">
<div class="progress-bar bg-warning"
style="width:{{ optional($riskScore)->economic_score ?? 0 }}%">
</div>
</div>

</div>

<!-- Logistics -->
<div class="mb-3">

<div class="d-flex justify-content-between">
<span>🚢 Logistics</span>
<span>{{ optional($riskScore)->logistics_score ?? 0 }}</span>
</div>

<div class="progress" style="height:10px;">
<div class="progress-bar bg-success"
style="width:{{ optional($riskScore)->logistics_score ?? 0 }}%">
</div>
</div>

</div>

<!-- News -->
<div>

<div class="d-flex justify-content-between">
<span>📰 News</span>
<span>{{ optional($riskScore)->news_score ?? 0 }}</span>
</div>

<div class="progress" style="height:10px;">
<div class="progress-bar bg-danger"
style="width:{{ optional($riskScore)->news_score ?? 0 }}%">
</div>
</div>

</div>

            </div>

            <div class="col-md-6">

<h5 class="text-info mb-4">

🧠 AI Explanation

</h5>

<div class="bg-dark rounded p-3">

<p class="mb-3 text-light">

The AI engine evaluates multiple supply chain indicators before generating a recommendation.

</p>

<ul class="text-light mb-0">

<li>🌦 Weather conditions</li>

<li>💰 Economic stability</li>

<li>🚢 Logistics performance</li>

<li>📰 News sentiment</li>

<li>🤖 Transport prediction</li>

</ul>

</div>

            </div>

        </div>

        <hr>

<h5 class="text-info mb-4">

📋 Executive Summary

</h5>

<div
class="p-4 rounded"
style="
background:rgba(56,189,248,.08);
border:1px solid rgba(56,189,248,.25);
">

<p class="text-light mb-3">

The AI system has completed a comprehensive analysis for

<b class="text-info">{{ $selectedCountry->name }}</b>.

</p>

<div class="row">

<div class="col-md-4 mb-3">

<h6 class="text-secondary">
Risk Level
</h6>

<h4 class="text-warning">

{{ $riskScore->risk_level }}

</h4>

</div>

<div class="col-md-4 mb-3">

<h6 class="text-secondary">
Transport Trend
</h6>

<h4 class="text-info">

{{ $prediction['trend'] }}

</h4>

</div>

<div class="col-md-4 mb-3">

<h6 class="text-secondary">
Recommendation
</h6>

<h4 class="text-success">

{{ $decision }}

</h4>

</div>

</div>

<hr>

<p class="mb-0 text-light">

This recommendation is generated automatically using integrated analysis of weather, economy, logistics, news sentiment, and transport prediction.

</p>

</div>

    </div>

</div>

{{-- ========================= --}}
{{-- AI FORECAST --}}
{{-- ========================= --}}

<div class="card futuristic-card border-0 mt-4">

    <div class="card-body">


        <h4 class="text-info fw-bold mb-4">

            📊 AI Forecast - Next 7 Days

        </h4>


        <div style="height:300px">

            <canvas id="forecastChart"></canvas>

        </div>


    </div>

</div>

{{-- COUNTRY + WEATHER --}}
    <div class="row mt-4">

        {{-- COUNTRY --}}
        <div class="col-lg-6">

            <div class="card futuristic-card border-0 h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-4">

                        <img
                            src="https://flagcdn.com/64x48/{{ strtolower($selectedCountry->code) }}.png"
                            width="64"
                            class="me-3">

                        <div>

                            <h3 class="mb-1">
                                {{ $selectedCountry->name }}
                            </h3>

                            <small class="text-secondary">
                                {{ $selectedCountry->region }}
                            </small>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-6 mb-3">

                            <div class="bg-dark rounded p-3">

                                <small class="text-secondary">
                                    GDP
                                </small>

<h5 class="text-info">

${{ number_format(($economicData->gdp ?? 0) / 1000000000,2) }} B

</h5>

                            </div>

                        </div>

                        <div class="col-6 mb-3">

                            <div class="bg-dark rounded p-3">

                                <small class="text-secondary">
                                    Population
                                </small>

                                <h5>

                                    {{ number_format($selectedCountry->population) }}

                                </h5>

                            </div>

                        </div>

                        <div class="col-6 mb-3">

                            <div class="bg-dark rounded p-3">

                                <small class="text-secondary">
                                    Inflation
                                </small>

                                <h5 class="text-warning">

                                    {{ $economicData->inflation ?? 0 }} %

                                </h5>

                            </div>

                        </div>

                        <div class="col-6 mb-3">

                            <div class="bg-dark rounded p-3">

                                <small class="text-secondary">
                                    Currency
                                </small>

                                <h5 class="text-success">

                                    {{ $selectedCountry->currency_code }}

                                </h5>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="bg-dark rounded p-3">

                                <small class="text-secondary">
                                    Export
                                </small>

                                <h6>

                                    ${{ number_format(($economicData->exports ?? 0)/1000000000,2) }} B

                                </h6>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="bg-dark rounded p-3">

                                <small class="text-secondary">
                                    Import
                                </small>

                                <h6>

                                    ${{ number_format(($economicData->imports ?? 0)/1000000000,2) }} B

                                </h6>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- WEATHER --}}
        <div class="col-lg-6">

            <div class="card futuristic-card border-0 h-100">

                <div class="card-body">

                    <h4 class="text-info fw-bold mb-4">

                        🌦 Current Weather

                    </h4>

                    <div class="row">

                        <div class="col-6 mb-3">

                            <div class="bg-dark rounded p-3 text-center">

                                <div style="font-size:34px">🌡</div>

                                <small class="text-secondary">

                                    Temperature

                                </small>

                                <h4 class="text-info">

                                    {{ $weather->temperature ?? '-' }}°C

                                </h4>

                            </div>

                        </div>

                        <div class="col-6 mb-3">

                            <div class="bg-dark rounded p-3 text-center">

                                <div style="font-size:34px">🌧</div>

                                <small class="text-secondary">

                                    Rainfall

                                </small>

                                <h4 class="text-primary">

                                    {{ $weather->rainfall ?? '-' }} mm

                                </h4>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="bg-dark rounded p-3 text-center">

                                <div style="font-size:34px">💨</div>

                                <small class="text-secondary">

                                    Wind Speed

                                </small>

                                <h4 class="text-warning">

                                    {{ $weather->wind_speed ?? '-' }}

                                </h4>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="bg-dark rounded p-3 text-center">

                                <div style="font-size:34px">⚡</div>

                                <small class="text-secondary">

                                    Storm Risk

                                </small>

                                <h4 class="text-danger">

                                    {{ $weather->storm_risk ?? '-' }}%

                                </h4>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <small class="text-secondary">

                        Last Update :
                        {{ optional($weather)->updated_at?->format('d M Y H:i') ?? '-' }}

                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================= --}}
{{-- RISK + AI RECOMMENDATION --}}
{{-- ========================= --}}

<div class="row mt-4">

    {{-- RISK ASSESSMENT --}}
    <div class="col-lg-6">

        <div class="card futuristic-card border-0 h-100">

            <div class="card-body">

                <h4 class="text-info fw-bold mb-4">
                    ⚠ Risk Assessment
                </h4>

                <div class="row g-3">

                    <div class="col-6">
                        <div class="bg-dark rounded p-3 text-center">

                            <small class="text-secondary">
                                Weather Score
                            </small>

<h3 class="text-info">

    {{ $risk->weather_score ?? 0 }}

</h3>

<div class="progress mt-2">

    <div
        class="progress-bar bg-info"
        style="width:{{ $risk->weather_score ?? 0 }}%">
    </div>

</div>

                        </div>
                    </div>

                    <div class="col-6">
                        <div class="bg-dark rounded p-3 text-center">

                            <small class="text-secondary">
                                Economic Score
                            </small>

                            <h3 class="text-warning">
                                {{ optional($riskScore)->economic_score ?? 0}}
                            </h3>
                            <div class="progress mt-2">

<div
class="progress-bar bg-warning"
style="width:{{ optional($riskScore)->economic_score ?? 0 }}%">

</div>

</div>

                        </div>
                    </div>

                    <div class="col-6">
                        <div class="bg-dark rounded p-3 text-center">

                            <small class="text-secondary">
                                Logistics Score
                            </small>

                            <h3 class="text-success">
                                {{ optional($riskScore)->logistics_score ?? 0 }}
                            </h3>
                            <div class="progress mt-2">

<div
class="progress-bar bg-success"
style="width:{{ optional($riskScore)->logistics_score ?? 0 }}%">

</div>

</div>

                        </div>
                    </div>

                    <div class="col-6">
                        <div class="bg-dark rounded p-3 text-center">

                            <small class="text-secondary">
                                News Score
                            </small>

                            <h3 class="text-danger">
                                {{ optional($riskScore)->news_score ?? 0 }}
                            </h3>

                        <div class="progress mt-2">

<div
class="progress-bar bg-danger"
style="width:{{ optional($riskScore)->news_score ?? 0 }}%">

</div>

</div>

                        </div>
                    </div>
                    

                </div>

                <hr>

                <div class="text-center">

                    <h6 class="text-secondary">
                        Total Risk Score
                    </h6>

                                        @php
                        $color='success';

                        if(($riskScore->risk_level ?? '')=='Medium'){
                            $color='warning';
                        }

                        if(($riskScore->risk_level ?? '')=='High'){
                            $color='danger';
                        }
                    @endphp

                    <h1 class="text-{{ $color }} fw-bold">
                        {{ $riskScore->total_score ?? 0 }}
                    </h1>

                    <span class="badge bg-{{ $color }} fs-6">

                        {{ $riskScore->risk_level ?? 'Unknown' }}

                    </span>

                </div>

                <div class="progress mt-4" style="height:28px">

                    <div
                        class="progress-bar bg-{{ $color }}"
                        style="width:{{ $riskScore->total_score ?? 0 }}%">

                        {{ $riskScore->total_score ?? 0 }}

                    </div>

                </div>

            </div>

        </div>

    </div>

    

    {{-- AI RECOMMENDATION --}}
    <div class="col-lg-6">

        <div class="card futuristic-card border-0 h-100">

            <div class="card-body">

                <h4 class="text-info fw-bold mb-4">

                    🤖 AI Recommendation

                </h4>

@php

$panelColor = 'rgba(34,197,94,.08)';
$borderColor = 'rgba(34,197,94,.30)';

if($recommendation['status']=="Warning"){

    $panelColor='rgba(245,158,11,.08)';
    $borderColor='rgba(245,158,11,.30)';

}

if($recommendation['status']=="Critical"){

    $panelColor='rgba(239,68,68,.08)';
    $borderColor='rgba(239,68,68,.30)';

}

@endphp

<div
class="rounded p-4"
style="
background:{{ $panelColor }};
border:1px solid {{ $borderColor }};
">

    <h5>
        🤖 {{ $recommendation['status'] }}
    </h5>

    <p>

        {{ $recommendation['message'] }}

    </p>

    <ul>

        @foreach($recommendation['actions'] as $action)

            <li>{{ $action }}</li>

        @endforeach

    </ul>

</div>

                <hr>

                <h5 class="text-info">

                    📊 AI Risk Components

                </h5>

                <div style="height:280px">

                    <canvas id="riskRadarChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ========================= --}}
{{-- CHART & MAP --}}
{{-- ========================= --}}

<div class="row mt-4">

    {{-- Inflation Chart --}}
    <div class="col-lg-6">

        <div class="card futuristic-card border-0 h-100">

            <div class="card-body">

                <h4 class="text-info fw-bold mb-4">
                    📈 Inflation Comparison
                </h4>

                <div style="height:320px">

                    <canvas id="inflationChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    {{-- Country Map --}}
    <div class="col-lg-6">

<div class="card futuristic-card border-0">

    <div class="card-body">

        <h4 class="text-info fw-bold mb-4">
            🗺 Country Location
        </h4>

                <div
                    id="countryMap"
                    style="
                        height:320px;
                        border-radius:15px;
                        overflow:hidden;
                    ">

                </div>

            </div>

        </div>

    </div>

</div>

<div class="card futuristic-card mt-4 border-0">

    <div class="card-body">

        <h4 class="text-info fw-bold mb-4">
            📈 GDP Trend
        </h4>

        <div
            style="
                position:relative;
                height:380px;
                width:100%;
            ">

            <canvas id="gdpChart"></canvas>

        </div>

    </div>

</div>

{{-- Risk Chart --}}
<div class="row mt-4">

    <div class="col-lg-12">

        <div class="card futuristic-card border-0">

            <div class="card-body">

                <h4 class="text-info fw-bold mb-4">
                    📊 Global Risk Comparison
                </h4>

                <div style="height:380px">

                    <canvas id="riskChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ========================= --}}
{{-- TOP 10 RANKING --}}
{{-- ========================= --}}

@php
$ranking = $countries
    ->sortByDesc(function($item){
        return optional($item->riskScore)->total_score;
    })
    ->take(10);
@endphp

<div class="card futuristic-card border-0 mt-4">

    <div class="card-body">

        <h4 class="text-info fw-bold mb-4">

            🏆 Top 10 Global Risk Ranking

        </h4>

        <table class="table table-dark table-hover align-middle">

            <thead>

                <tr>

                    <th width="70">Rank</th>
                    <th>Country</th>
                    <th width="130">Score</th>
                    <th width="130">Level</th>

                </tr>

            </thead>

            <tbody>

                @foreach($ranking as $country)

                <tr>

                    <td>

@if($loop->iteration == 1)

<span class="badge bg-warning fs-6">

🥇

</span>

@elseif($loop->iteration == 2)

<span class="badge bg-secondary fs-6">

🥈

</span>

@elseif($loop->iteration == 3)

<span class="badge text-dark"
style="background:#cd7f32;">

🥉

</span>

@else

<span class="badge bg-info">

{{ $loop->iteration }}

</span>

@endif

                    </td>

                    <td>

                        <img
                            src="https://flagcdn.com/24x18/{{ strtolower($country->code) }}.png"
                            class="me-2">

                        {{ $country->name }}

                    </td>

<td>

<b class="text-info fs-5">

{{ optional($country->riskScore)->total_score ?? 0 }}

</b>

</td>

                    <td>

                        @php
                            $level = optional($country->riskScore)->risk_level;
                        @endphp

                        @if($level=="High")

                            <span class="badge bg-danger">
                                High
                            </span>

                        @elseif($level=="Medium")

                            <span class="badge bg-warning text-dark">
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

{{-- ========================= --}}
{{-- WATCHLIST --}}
{{-- ========================= --}}

<div class="card futuristic-card border-0 mt-4">

    <div class="card-body text-center">

        <form
            action="{{ route('watchlist.store') }}"
            method="POST">

            @csrf

            <input
                type="hidden"
                name="country_id"
                value="{{ $selectedCountry->id }}">

            <button
                class="btn btn-info btn-lg w-100">

                ⭐ Add Country to Watchlist

            </button>

        </form>

    </div>

</div>

{{-- ========================= --}}
{{-- CHART.JS --}}
{{-- ========================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $forecastData = $prediction['forecast'] ?? [0,0,0,0,0,0,0];
@endphp

<script>

document.addEventListener("DOMContentLoaded", function () {


    // =========================
    // TRANSPORT HISTORY CHART
    // =========================

    const transportHistory = document.getElementById('transportHistoryChart');


    if(transportHistory){

        new Chart(transportHistory,{

            type:'line',

            data:{

                labels:@json(
                    $history->pluck('created_at')
                    ->map(function($date){

                        return \Carbon\Carbon::parse($date)
                        ->format('d M');

                    })
                ),

datasets:[{

    label:'Transport Risk',

    data:@json($history->pluck('risk_score')),

    borderColor:'#38bdf8',

    backgroundColor:'rgba(56,189,248,.20)',

    borderWidth:3,

    tension:0.4,

    fill:true,

    pointRadius:5

}]

            },

options:{

    responsive:true,

    maintainAspectRatio:false,

    animation:{
        duration:1200
    },

                scales:{

                    y:{

                        beginAtZero:true,

                        max:100

                    }

                }

            }

        });

    }

    // =========================
    // RADAR CHART
    // =========================

    const radar = document.getElementById('riskRadarChart');

    if(radar){

        new Chart(radar,{

            type:'radar',

            data:{

                labels:[
                    'Weather',
                    'Economic',
                    'Logistics',
                    'News'
                ],

                datasets:[{

                    label:'Risk Components',

                    data:[

                        {{ optional($riskScore)->weather_score ?? 0 }},
                        {{ optional($riskScore)->economic_score ?? 0}},
                        {{ optional($riskScore)->logistics_score ?? 0 }},
                        {{ optional($riskScore)->news_score ?? 0 }}

                    ],

                    backgroundColor:'rgba(56,189,248,.25)',

                    borderColor:'#38bdf8',

                    pointBackgroundColor:'#38bdf8',

                    pointBorderColor:'#ffffff',

                    borderWidth:3

                }]

            },

            options:{

                responsive:true,

                maintainAspectRatio:false,

                plugins:{

                    legend:{

                        labels:{

                            color:'white'

                        }

                    }

                },

                scales:{

                    r:{

                        min:0,

                        max:100,

                        ticks:{

                            color:'white'

                        },

                        grid:{

                            color:'rgba(255,255,255,.12)'

                        },

                        pointLabels:{

                            color:'white'

                        }

                    }

                }

            }

        });

    }

    // =========================
    // INFLATION CHART
    // =========================

    const inflation=document.getElementById('inflationChart');

    if(inflation){

        new Chart(inflation,{

            type:'bar',

            data:{

                labels:[

                    @foreach($countries as $country)

                        "{{ $country->name }}",

                    @endforeach

                ],

                datasets:[{

                    label:'Inflation Rate (%)',

                    data:[

                        @foreach($countries as $country)

                            {{ $country->inflation_rate ?? 0 }},

                        @endforeach

                    ],

                    backgroundColor:'rgba(56,189,248,.55)',

                    borderColor:'#38bdf8',

                    borderWidth:2,

                    borderRadius:8

                }]

            },

            options:{

                responsive:true,

                maintainAspectRatio:false,

                plugins:{

                    legend:{

                        labels:{

                            color:'white'

                        }

                    }

                },

                scales:{

                    x:{

                        ticks:{

                            color:'white'

                        }

                    },

                    y:{

                        beginAtZero:true,

                        ticks:{

                            color:'white'

                        }

                    }

                }

            }

        });

    }



    // =========================
// FORECAST CHART
// =========================

const forecast = document.getElementById('forecastChart');


if(forecast){

    new Chart(forecast,{

        type:'line',

        data:{

            labels:[

                "Tomorrow",
                "+2 Days",
                "+3 Days",
                "+4 Days",
                "+5 Days",
                "+6 Days",
                "+7 Days"

            ],

datasets:[{

label:'Predicted Transport Risk',

data:@json($forecastData),

borderWidth:3,

tension:.4,

fill:true,

pointRadius:5,

borderColor:'#f59e0b',

backgroundColor:'rgba(245,158,11,.25)'

}]

        },

        options:{

            responsive:true,

            maintainAspectRatio:false,

            scales:{

                y:{

                    beginAtZero:true,

                    max:100

                }

            }

        }

    });

}

    // =========================
    // RISK CHART
    // =========================

    const risk=document.getElementById('riskChart');

    if(risk){

        new Chart(risk,{

            type:'bar',

            data:{

                labels:[

                    @foreach($countries as $country)

                        "{{ $country->name }}",

                    @endforeach

                ],

                datasets:[{

                    label:'Risk Score',

                    data:[

                        @foreach($countries as $country)

                            {{ optional($country->riskScore)->total_score ?? 0 }},

                        @endforeach

                    ],

                    backgroundColor:'rgba(14,165,233,.65)',

                    borderColor:'#38bdf8',

                    borderWidth:2,

                    borderRadius:8

                }]

            },

            options:{

                responsive:true,

                maintainAspectRatio:false,

                plugins:{

                    legend:{

                        labels:{

                            color:'white'

                        }

                    }

                },

                scales:{

                    y:{

                        beginAtZero:true,

                        max:100,

                        ticks:{

                            color:'white'

                        }

                    },

                    x:{

                        ticks:{

                            color:'white'

                        }

                    }

                }

            }

        });

    }

// =========================
// GDP TREND
// =========================

console.log("=== GDP START ===");

const ctxGDP = document.getElementById('gdpChart');

if(ctxGDP){

    new Chart(ctxGDP,{

        type:'bar',

        data:{
labels:@json($gdpLabels),

datasets:[{
    label:'GDP (USD)',
    data:@json($gdpValues),

                backgroundColor:'blue'

            }]

        },

        options:{

            responsive:true,

            maintainAspectRatio:false

        }

    });

}
// =========================
// AI RISK GAUGE
// =========================

@php

$gaugeColor = "#22c55e";

if($prediction['score'] >= 70){
    $gaugeColor = "#ef4444";
}
elseif($prediction['score'] >= 40){
    $gaugeColor = "#facc15";
}

@endphp

const gauge = document.getElementById('riskGauge');

if(gauge){

    new Chart(gauge,{

        type:'doughnut',

        data:{

            datasets:[{

                data:[
                    {{ $prediction['score'] }},
                    {{ 100 - $prediction['score'] }}
                ],

                backgroundColor:[
                    '{{ $gaugeColor }}',
                    '#1e293b'
                ],

                borderWidth:0,

                circumference:180,

                rotation:270,

                cutout:'75%'

            }]

        },

        options:{

            responsive:true,

            maintainAspectRatio:true,

            plugins:{

                legend:{
                    display:false
                },

                tooltip:{
                    enabled:false
                }

            }

        }

    });

}

});

</script>

{{-- ========================= --}}
{{-- LEAFLET --}}
{{-- ========================= --}}

<link
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

document.addEventListener("DOMContentLoaded",function(){

    var map=L.map('countryMap').setView(

        [

            {{ $selectedCountry->latitude }},

            {{ $selectedCountry->longitude }}

        ],

        5

    );

    L.tileLayer(

        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',

        {

            attribution:'© OpenStreetMap'

        }

    ).addTo(map);

    L.marker(

        [

            {{ $selectedCountry->latitude }},

            {{ $selectedCountry->longitude }}

        ]

    )

    .addTo(map)

    .bindPopup(

        "<b>{{ $selectedCountry->name }}</b>"

    )

    .openPopup();

});



</script>

@endsection
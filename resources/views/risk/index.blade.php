@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">
    <div class="card-body">

        <h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
            Risk Score Engine
        </h2>

        <table class="table table-bordered futuristic-table">

            <tr>
                <th style="
background:rgba(15,23,42,0.85);
color:#38bdf8;
width:60%;
">
    Weather Risk
</th>
                <td style="color:#67e8f9; font-weight:600;">
                    {{ $weatherRisk }}
                </td>
            </tr>

            <tr>
    <th style="background:rgba(15,23,42,0.85); color:#38bdf8;">
        Inflation Risk
    </th>
    <td style="color:#67e8f9; font-weight:600;">
        {{ round($inflationRisk,2) }}
    </td>
</tr>

            <tr>
                <th style="background:rgba(15,23,42,0.85); color:#38bdf8;">Currency Risk</th>
                <td style="color:#67e8f9; font-weight:600;">
                    {{ $currencyRisk }}
                </td>
            </tr>

            <tr>
                <th style="background:rgba(15,23,42,0.85); color:#38bdf8;">News Risk</th>
                <td style="color:#67e8f9; font-weight:600;">
                    {{ $newsRisk }}
                </td>
            </tr>

            <tr>
    <td>
        <strong style="background:rgba(15,23,42,0.85); color:#38bdf8;">Logistics Risk</strong>
    </td>

    <td style="color:#67e8f9; font-weight:600;">
        {{ $logisticsRisk }}
    </td>
</tr>

            <tr>
                <th style="background:rgba(15,23,42,0.85); color:#38bdf8;">Final Score</th>
                <td style="
                    color:#38bdf8;
                    font-weight:700;
                    font-size:24px;
                    text-shadow:0 0 12px #38bdf8;
                ">
                    {{ $riskScore }}
                </td>
            </tr>

        </table>

        <h3 class="mt-4">
            Risk Level:

            @if($riskLevel == 'High')
                <span class="badge bg-danger">High</span>
            @elseif($riskLevel == 'Medium')
                <span class="badge bg-warning text-dark">Medium</span>
            @else
                <span class="badge bg-success">Low</span>
            @endif
        </h3>

    </div>
</div>

@endsection
@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">

    <h2 style="color:#38bdf8;">
        🌍 Manage Countries
    </h2>

    <a href="{{ route('admin.countries.create') }}"
       class="btn btn-info">

        + Add Country

    </a>

</div>

<div class="row mt-4">

    <div class="col-md-4">

<form method="GET" action="{{ route('admin.countries') }}">

<input 
type="text"
name="search"
value="{{ request('search') }}"
placeholder="Search country..."
class="form-control"
onkeyup="this.form.submit()">

</form>

    </div>

</div>

        <table class="table table-bordered futuristic-table mt-4">
            <thead>
                <tr>
                    <th>Flag</th>
<th>Country</th>
<th>Code</th>
<th>GDP</th>
<th>Inflation</th>
<th>Risk</th>
<th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($countries as $country)
                <tr>

    <td>

        <img
            src="https://flagcdn.com/24x18/{{ strtolower($country->code) }}.png">

    </td>

    <td>

        {{ $country->name }}

    </td>

    <td>

        {{ $country->code }}

    </td>

<td>

    ${{ number_format($country->latestEconomic->gdp ?? 0,0) }}

</td>

<td>

    {{ $country->latestEconomic->inflation ?? 0 }} %

</td>

    <td>

@if(optional($country->riskScore)->risk_level=="High")

<span class="badge bg-danger">

High

</span>

@elseif(optional($country->riskScore)->risk_level=="Medium")

<span class="badge bg-warning text-dark">

Medium

</span>

@else

<span class="badge bg-success">

Low

</span>

@endif

    </td>

    <td>

<a
href="{{ route('admin.countries.edit',$country->id) }}"
class="btn btn-warning btn-sm">

Edit

</a>

<form
action="{{ route('admin.countries.destroy',$country->id) }}"
method="POST"
class="d-inline">

@csrf

@method('DELETE')

<button
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this country?')">

Delete

</button>

</form>

    </td>

</tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">
    <div class="card-body">
        <h2 style="color:#38bdf8;">Manage Countries</h2>

        <table class="table table-bordered futuristic-table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>Code</th>
                    <th>GDP</th>
                    <th>Inflation</th>
                </tr>
            </thead>

            <tbody>
                @foreach($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->code }}</td>
                    <td>{{ number_format($country->gdp, 0) }}</td>
                    <td>{{ $country->inflation_rate }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
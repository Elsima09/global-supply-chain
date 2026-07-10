@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">

    <div class="card-body">

        <h2 style="color:#38bdf8;">
            ✏ Edit Country
        </h2>

        <form action="{{ route('admin.countries.update', $country->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row mt-4">

                <div class="col-md-6 mb-3">
                    <label>Country Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ $country->name }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Country Code</label>
                    <input
                        type="text"
                        name="code"
                        class="form-control"
                        value="{{ $country->code }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Region</label>
                    <input
                        type="text"
                        name="region"
                        class="form-control"
                        value="{{ $country->region }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Currency Code</label>
                    <input
                        type="text"
                        name="currency_code"
                        class="form-control"
                        value="{{ $country->currency_code }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Population</label>
                    <input
                        type="number"
                        name="population"
                        class="form-control"
                        value="{{ $country->population }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>GDP</label>
                    <input
                        type="number"
                        step="0.01"
                        name="gdp"
                        class="form-control"
                        value="{{ $country->gdp }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Inflation Rate</label>
                    <input
                        type="number"
                        step="0.01"
                        name="inflation_rate"
                        class="form-control"
                        value="{{ $country->inflation_rate }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Export Value</label>
                    <input
                        type="number"
                        step="0.01"
                        name="export_value"
                        class="form-control"
                        value="{{ $country->export_value }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Import Value</label>
                    <input
                        type="number"
                        step="0.01"
                        name="import_value"
                        class="form-control"
                        value="{{ $country->import_value }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Latitude</label>
                    <input
                        type="number"
                        step="0.000001"
                        name="latitude"
                        class="form-control"
                        value="{{ $country->latitude }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Longitude</label>
                    <input
                        type="number"
                        step="0.000001"
                        name="longitude"
                        class="form-control"
                        value="{{ $country->longitude }}"
                        required>
                </div>

            </div>

            <button class="btn btn-warning">
                💾 Update Country
            </button>

            <a href="{{ route('admin.countries') }}" class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>

</div>

@endsection
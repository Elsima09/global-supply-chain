@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">

    <div class="card-body">

        <h2 style="color:#38bdf8;">
            ➕ Add New Country
        </h2>

        <form action="{{ route('admin.countries.store') }}" method="POST">

            @csrf

            <div class="row mt-4">

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">Country Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">Country Code</label>
                    <input
                        type="text"
                        name="code"
                        class="form-control"
                        placeholder="ID, CN, US"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">Region</label>
                    <input
                        type="text"
                        name="region"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">Currency Code</label>
                    <input
                        type="text"
                        name="currency_code"
                        class="form-control"
                        placeholder="IDR, CNY, USD"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">Population</label>
                    <input
                        type="number"
                        name="population"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">GDP</label>
                    <input
                        type="number"
                        step="0.01"
                        name="gdp"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">Inflation Rate</label>
                    <input
                        type="number"
                        step="0.01"
                        name="inflation_rate"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">Export Value</label>
                    <input
                        type="number"
                        step="0.01"
                        name="export_value"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">Import Value</label>
                    <input
                        type="number"
                        step="0.01"
                        name="import_value"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">Latitude</label>
                    <input
                        type="number"
                        step="0.000001"
                        name="latitude"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-light fw-bold mb-2">>Longitude</label>
                    <input
                        type="number"
                        step="0.000001"
                        name="longitude"
                        class="form-control"
                        required>
                </div>

            </div>

            <button class="btn btn-info">
                💾 Save Country
            </button>

            <a
                href="{{ route('admin.countries') }}"
                class="btn btn-secondary">

                Cancel

            </a>

        </form>

    </div>

</div>

@endsection
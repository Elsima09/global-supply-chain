@extends('layouts.dashboard')

@section('content')

<h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Edit Port
</h2>

<div class="card futuristic-card border-0">
    <div class="card-body">

        <form action="{{ route('admin.ports.update', $port->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Port Name</label>
                <input type="text" name="port_name"
                    value="{{ $port->port_name }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Country</label>
                <input type="text" name="country"
                    value="{{ $port->country }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Latitude</label>
                <input type="text" name="latitude"
                    value="{{ $port->latitude }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Longitude</label>
                <input type="text" name="longitude"
                    value="{{ $port->longitude }}"
                    class="form-control">
            </div>

            <button class="btn btn-warning">
                Update Port
            </button>

            <a href="{{ route('admin.ports') }}" class="btn btn-secondary">
                Back
            </a>
        </form>

    </div>
</div>

@endsection
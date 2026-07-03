@extends('layouts.dashboard')

@section('content')

<h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Admin Panel
</h2>

@if(session('success'))
    <div style="
        background:rgba(34,197,94,0.12);
        border:1px solid rgba(34,197,94,0.35);
        color:#86efac;
        padding:16px;
        border-radius:14px;
    ">
        {{ session('success') }}
    </div>
@endif

<div class="row g-4">

    <div class="col-md-4">
        <div class="card futuristic-card border-blue">
            <div class="card-body">
                <h5>Total Countries</h5>
                <small style="color:#94a3b8">Registered countries</small>

                <h2 style="
                    color:#38bdf8;
                    text-shadow:0 0 15px #38bdf8;
                ">
                    {{ $countryCount }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card futuristic-card border-green">
            <div class="card-body">
                <h5>Total Ports</h5>
                <small style="color:#94a3b8">Active ports</small>

                <h2 style="
                    color:#22c55e;
                    text-shadow:0 0 15px #22c55e;
                ">
                    {{ $portCount }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card futuristic-card border-yellow">
            <div class="card-body">
                <h5>Total Users</h5>
                <small style="color:#94a3b8">System users</small>

                <h2 style="
                    color:#facc15;
                    text-shadow:0 0 15px #facc15;
                ">
                    {{ $userCount }}
                </h2>
            </div>
        </div>
    </div>

</div>

<div class="card futuristic-card border-0 mt-4">
    <div class="card-body">

        <h4 style="color:#38bdf8;">Admin Actions</h4>

        <div class="d-flex gap-3 mt-3 flex-wrap">

            <a href="{{ route('admin.articles') }}" class="btn btn-info">
    Manage Articles
</a>

<a href="{{ route('admin.users') }}" class="btn btn-dark">
    Manage Users
</a>

           <a href="{{ route('admin.countries') }}" class="btn btn-primary">
    Manage Countries
</a>

            <a href="{{ route('admin.ports') }}" class="btn btn-success">
    Manage Ports
</a>

            <form action="{{ route('admin.refresh') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning">
                    Refresh API
                </button>
            </form>

            <form action="{{ route('admin.recalculate') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">
                    Recalculate Risk
                </button>
            </form>

        </div>

    </div>
</div>

@endsection
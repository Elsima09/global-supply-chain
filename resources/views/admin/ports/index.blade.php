@extends('layouts.dashboard')

@section('content')

<h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Manage Ports
</h2>

<div class="card futuristic-card border-0">
    <div class="card-body">

        <form action="{{ route('admin.ports.store') }}" method="POST" class="mb-4">
    @csrf

    <div class="row g-2">
        <div class="col-md-3">
            <input type="text" name="port_name" class="form-control" placeholder="Port Name" required>
        </div>

        <div class="col-md-2">
            <input type="text" name="country" class="form-control" placeholder="Country" required>
        </div>

        <div class="col-md-2">
            <input type="text" name="latitude" class="form-control" placeholder="Latitude" required>
        </div>

        <div class="col-md-2">
            <input type="text" name="longitude" class="form-control" placeholder="Longitude" required>
        </div>

        <div class="col-md-2">
            <button class="btn btn-success w-100">
                Add Port
            </button>
        </div>
    </div>
</form>

        <table class="table table-bordered table-hover futuristic-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Port Name</th>
                    <th>Country</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($ports as $port)
                <tr>
                    <td>{{ $port->id }}</td>
                    <td>{{ $port->port_name }}</td>
                    <td>
    🌎 {{ $port->country->name ?? '-' }}
</td>
                    <td>{{ $port->latitude }}</td>
                    <td>{{ $port->longitude }}</td>
                    <td>
                        <a href="{{ route('admin.ports.edit', $port->id) }}"
   class="btn btn-warning btn-sm">
    Edit
</a>

                        <form action="{{ route('admin.ports.destroy', $port->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-sm"
        onclick="return confirm('Delete this port?')">
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
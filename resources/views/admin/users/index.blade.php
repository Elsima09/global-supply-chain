@extends('layouts.dashboard')

@section('content')

<h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Manage Users
</h2>

<div class="card futuristic-card border-0">
    <div class="card-body">

        <table class="table table-bordered table-hover futuristic-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-sm"
        onclick="return confirm('Delete this user?')">
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
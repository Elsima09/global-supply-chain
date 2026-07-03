<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
{
    if ($user->role === 'admin') {
        return redirect()->back()->with(
            'error',
            'Admin cannot be deleted!'
        );
    }

    $user->delete();

    return redirect()->back()->with(
        'success',
        'User deleted successfully!'
    );
}
}
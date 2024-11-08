<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function manageUsers(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $user->update($request->all());
        return redirect()->route('admin.users.index')->with('success', 'Foydalanuvchi yangilandi');
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->orderByDesc('is_admin')
            ->orderBy('name')
            ->paginate(30);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => (bool) ($validated['is_admin'] ?? false),
        ]);

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('status', 'Потребителят е създаден.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'max:255'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_admin' => (bool) ($validated['is_admin'] ?? false),
        ]);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('status', 'Потребителят е обновен.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->withErrors(['user' => 'Не можеш да изтриеш собствения си акаунт.']);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Потребителят е изтрит.');
    }
}


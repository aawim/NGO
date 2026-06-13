<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        // Fetch all users, newest first
        $users = User::latest()->get();

        return Inertia::render('Admin/Users/Users', [
            'users' => $users
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        // Prevent admin from downgrading themselves
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'You cannot change your own admin role.');
        }

        $validated = $request->validate([
            'role' => ['required', 'in:user,volunteer,admin']
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('message', "User role updated successfully.");
    }

    public function updateStatus(Request $request, User $user)
    {
        // Prevent admin from suspending themselves
        if ($user->id === auth()->id() && $request->status === 'suspended') {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:active,suspended']
        ]);

        $user->update(['status' => $validated['status']]);

        return back()->with('message', "User status updated successfully.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return back()->with('message', 'User deleted successfully.');
    }
}

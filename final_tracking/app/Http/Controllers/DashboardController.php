<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Add this
use App\Models\User;
use App\Models\Activity;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $user = Auth::user(); // ✅ Properly get the authenticated user

        // Log user activity
        Activity::create([
            'user_id' => $user->id,
            'action' => 'Logged in to the dashboard',
        ]);

        // Check if user is an admin
        if ($user->role === 'admin') {
            $users = User::all(); // Fetch all users for the admin dashboard
            return view('admin.dashboard', compact('users'));
        }

        // For regular users, show their own dashboard
        return view('user.dashboard');
    }
}

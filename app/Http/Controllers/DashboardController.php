<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginActivity; // Your model for tracking login
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $activities = LoginActivity::where('user_id', Auth::id())
                        ->orderBy('logged_in_at', 'desc')
                        ->paginate(10);

        return view('dashboard', compact('activities'));
    }
}


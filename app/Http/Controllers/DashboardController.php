<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginActivity;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $activities = LoginActivity::where('user_id', Auth::id())
            ->whereNull('closed_at') // Now matches the database column
            ->orderBy('logged_in_at', 'desc')
            ->get();
    
        $tabCount = $activities->count();
    
        return view('dashboard', compact('activities', 'tabCount'));
    }
}

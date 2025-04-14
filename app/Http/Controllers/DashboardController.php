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
                        ->orderBy('logged_in_at', 'desc')
                        ->get(); // or paginate(10)

        return view('dashboard', compact('activities'));
    }
}

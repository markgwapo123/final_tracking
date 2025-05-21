<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginActivity;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrackTabInfoController extends Controller
{
    // Track or update active tab info
    public function store(Request $request)
    {
        $request->validate([
            'tab_id' => 'required|string',
            'tab_title' => 'required|string',
            'user_agent' => 'required|string',
            'computer_name' => 'required|string',  // Added validation for computer_name
        ]);
    
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    
        LoginActivity::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'tab_id' => $request->tab_id
            ],
            [
                'ip_address'    => $request->ip(),
                'tab_title'     => $request->tab_title,
                'device_info'   => $request->user_agent,
                'logged_in_at'  => Carbon::now('Asia/Manila'), // Initial login
                'last_active'   => Carbon::now('Asia/Manila'), // For updates
                'computer_name' => $request->computer_name // Save computer name here
            ]
        );
    
        return response()->json(['status' => 'Tab tracked successfully']);
    }
    

    // When tab is closed
    public function closeTab(Request $request)
    {
        $request->validate([
            'tab_id' => 'required|string'
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        LoginActivity::where('tab_id', $request->tab_id)
            ->where('user_id', Auth::id())
            ->update([
                'closed_at'   => Carbon::now('Asia/Manila'),
                'last_active' => Carbon::now('Asia/Manila'),
            ]);

        return response()->json(['status' => 'Tab closed successfully']);
    }
}

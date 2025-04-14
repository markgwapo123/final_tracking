<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginActivity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;



class TrackTabInfoController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
if (!$user) {
    return response()->json(['error' => 'Unauthenticated'], 401);
}


        // Find recent login to avoid duplicates
        $recentActivity = LoginActivity::where('user_id', $user->id)
            ->where('logged_in_at', '>=', Carbon::now()->subSeconds(10))
            ->latest()
            ->first();

        if ($recentActivity) {
            $recentActivity->update([
                'device_info' => 'Tab Title: ' . $request->tab_title . ', User Agent: ' . $request->user_agent,
            ]);
        } else {
            LoginActivity::create([
                'user_id'     => $user->id,
                'ip_address'  => $request->ip(),
                'device_info' => 'Tab Title: ' . $request->tab_title . ', User Agent: ' . $request->user_agent,
                'logged_in_at'=> now(),
            ]);
        }

        return response()->json(['message' => 'Activity tracked']);
    }
}

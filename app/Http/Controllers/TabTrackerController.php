<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\LoginActivity;
use Illuminate\Support\Facades\Auth;

class TabTrackerController extends Controller
{
    public function store(Request $request)
    {
      $userId = Auth::id();

        Log::info('Tab Info Logged', [
            'user_id'     => $userId,
            'tabs_open'   => $request->tabs_open,
            'user_agent'  => $request->user_agent,
            'tab_title'   => $request->tab_title,
        ]);

        if ($userId) {
            $latestLogin = LoginActivity::where('user_id', $userId)
                ->latest('logged_in_at')
                ->first();

            if ($latestLogin) {
                $latestLogin->update([
                    'device_info' => 'Tab Title: ' . $request->tab_title . ', User Agent: ' . $request->user_agent,
                ]);
            }
        }

        return response()->json(['status' => 'logged']);
    }
}

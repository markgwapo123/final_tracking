<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginActivity;
use Illuminate\Support\Facades\Auth;

class LoginActivityController extends Controller
{
    public function updateTabTitle(Request $request)
    {
        $latestActivity = LoginActivity::where('user_id', Auth::id())
            ->latest()
            ->first();

        if ($latestActivity) {
            $latestActivity->update([
                'device_info' => 'Tab Title: ' . $request->tab_title . ', User Agent: ' . $request->user_agent,
            ]);
        }

        return response()->json(['status' => 'updated']);
    }
}

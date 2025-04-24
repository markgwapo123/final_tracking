<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LoginActivity;
use Illuminate\Support\Facades\Hash;

class PcLockController extends Controller
{
    // PC Unlock/Login from comlab
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'computer_name' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Log activity
        LoginActivity::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'tab_id' => null,
            'tab_title' => null,
            'device_info' => $request->userAgent(),
            'logged_in_at' => now(),
            'computer_name' => $request->computer_name,
        ]);

        return response()->json(['message' => 'PC unlocked successfully.']);
    }

    // 🔓 PC Unlock method for Electron app
    public function unlockFromElectron(Request $request)
    {
        $request->merge([
            'computer_name' => $request->computer_name ?? $request->header('X-Computer-Name', 'Unknown-PC'),
        ]);

        return $this->login($request);  // reuse existing login logic
    }

    // 🔒 PC Lock/Logout method
    public function logout(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Mark last login as logged out
        $activity = LoginActivity::where('user_id', $user->id)
            ->whereNull('logged_out_at')
            ->latest()
            ->first();

        if ($activity) {
            $activity->update(['logged_out_at' => now()]);
        }

        return response()->json(['message' => 'PC locked successfully.']);
    }
}

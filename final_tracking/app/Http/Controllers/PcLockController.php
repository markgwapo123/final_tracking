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

        LoginActivity::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'tab_id' => null,
            'tab_title' => null,
            'device_info' => $request->userAgent(),
            'logged_in_at' => now(),
            'computer_name' => $request->computer_name,
        ]);

        return response()->json([
            'message' => 'PC unlocked successfully.',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }

    // Unlock from Electron
    public function unlockFromElectron(Request $request)
    {
        $request->merge([
            'computer_name' => $request->computer_name ?? $request->header('X-Computer-Name', 'Unknown-PC'),
        ]);

        return $this->login($request);
    }

    // Logout / Lock
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

        $activity = LoginActivity::where('user_id', $user->id)
            ->whereNull('logged_out_at')
            ->latest()
            ->first();

        if ($activity) {
            $activity->update(['logged_out_at' => now()]);
        }

        return response()->json(['message' => 'PC locked successfully.']);
    }

    // 🛑 Shutdown method
    public function shutdown(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'computer_name' => 'required|string'
        ]);

   

        return response()->json([
            'message' => "Shutdown command sent to " . $request->computer_name . " by " . $request->email
        ]);
    }
}

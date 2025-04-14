<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PcLockController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Access granted.',
                'user' => Auth::user()
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials.'
        ], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['status' => 'logged_out']);
    }
}

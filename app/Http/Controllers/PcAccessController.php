<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PcAccessController extends Controller
{
    // Used by lab PC to check if a user is allowed
    public function checkAccess(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'computer_name' => 'required|string',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['access' => false, 'message' => 'User not found'], 404);
        }

        // You can extend this logic to check if user is allowed in specific PC, time range, etc.
        return response()->json(['access' => true, 'message' => 'Access granted']);
    }
}

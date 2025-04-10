<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;
use App\Models\LoginActivity;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        LoginActivity::create([
            'user_id' => $event->user->id,
            'ip_address' => Request::ip(),
            'device_info' => Request::header('User-Agent'),
            'logged_in_at' => now(),
        ]);
    }
}

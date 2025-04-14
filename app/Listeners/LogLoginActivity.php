<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\LoginActivity;
use Illuminate\Support\Facades\Request;

class LogLoginActivity
{
    public function handle(Login $event)
    {
        // Save basic login info without tab title (to be updated by JS later)
        LoginActivity::create([
            'user_id'     => $event->user->id,
            'ip_address'  => Request::ip(),
            'device_info' => Request::header('User-Agent'),
            'logged_in_at'=> now(),
        ]);
    }
}

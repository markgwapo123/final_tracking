<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;
use App\Models\UserActivity;

class LogUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        // You can leave this empty
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        UserActivity::create([
            'user_id' => $event->user->id,
            'ip_address' => Request::ip(),
            'device_info' => Request::header('User-Agent'),
            'logged_in_at' => now(),
        ]);
    }
}

<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use App\Listeners\LogLoginActivity;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogLoginActivity::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}

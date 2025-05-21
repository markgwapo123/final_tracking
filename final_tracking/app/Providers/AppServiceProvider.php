<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use App\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Actions\Fortify\CustomRedirect;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
  
    
    public function register()
    {
        $this->app->singleton(LoginResponse::class, CustomRedirect::class);
    }
    
     

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

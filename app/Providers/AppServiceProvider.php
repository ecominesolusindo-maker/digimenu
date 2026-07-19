<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Order;
use App\Observers\OrderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);

        // Force HTTPS when behind a proxy (like Railway)
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        } else if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        
        // As a fallback for Railway, if we are on a railway domain, force it
        if (str_contains(request()->getHost(), 'railway.app')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
            
            // Force APP_URL so Livewire 3 doesn't break file uploads via CORS/Mixed Content
            config(['app.url' => 'https://' . request()->getHost()]);
        }

    }
}

<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $limiter = app(RateLimiter::class);

        $limiter->for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip());
        });

        $limiter->for('order', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip());
        });

        $limiter->for('contact', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip());
        });

        $limiter->for('register', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        $limiter->for('upload-proof', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}

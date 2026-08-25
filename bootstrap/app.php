<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\PreventSpam;
use App\Http\Middleware\AdminActivity;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureTwoFactorVerified;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(SecurityHeaders::class);

        $middleware->alias([
            'spam' => PreventSpam::class,
            'activity' => AdminActivity::class,
            'admin' => EnsureUserIsAdmin::class,
            '2fa' => EnsureTwoFactorVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

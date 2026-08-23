<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check() && $request->method() !== 'GET') {
            Log::channel('activity')->info('Admin Action', [
                'user' => auth()->user()->email,
                'action' => $request->method(),
                'url' => $request->url(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $response;
    }
}

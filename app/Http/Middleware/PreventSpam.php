<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class PreventSpam
{
    public function handle(Request $request, Closure $next, string $key = 'global', int $maxAttempts = 5, int $decayMinutes = 1): Response
    {
        $rateLimiterKey = $key . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($rateLimiterKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($rateLimiterKey);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Terlalu banyak percobaan. Coba lagi dalam ' . $seconds . ' detik.',
                ], Response::HTTP_TOO_MANY_REQUESTS);
            }

            return back()->withErrors([
                'rate_limit' => 'Terlalu banyak percobaan. Coba lagi dalam ' . $seconds . ' detik.',
            ])->withInput();
        }

        RateLimiter::hit($rateLimiterKey, $decayMinutes * 60);

        return $next($request);
    }
}

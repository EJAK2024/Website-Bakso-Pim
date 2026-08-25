<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->two_factor_secret && !$request->session()->get('2fa_verified')) {
            return redirect('/admin/2fa/verify');
        }

        return $next($request);
    }
}

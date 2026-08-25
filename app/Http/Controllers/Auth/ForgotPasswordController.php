<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        if ($request->input('website') !== null) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        $throttleKey = $request->input('email') . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts('forgot-password:' . $throttleKey, 3)) {
            $seconds = RateLimiter::availableIn('forgot-password:' . $throttleKey);
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan. Silakan coba lagi dalam ' . $seconds . ' detik.',
            ]);
        }

        RateLimiter::hit('forgot-password:' . $throttleKey, 60);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}

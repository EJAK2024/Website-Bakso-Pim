<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function show()
    {
        return view('auth.verify-email');
    }

    public function verify(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/admin');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($request->user()));
        }

        return redirect('/admin')->with('status', 'Email berhasil diverifikasi!');
    }

    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/admin');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Link verifikasi telah dikirim ke email Anda.');
    }
}

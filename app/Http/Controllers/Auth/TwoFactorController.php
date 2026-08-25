<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TwoFactorController extends Controller
{
    public function showSetupForm()
    {
        $user = Auth::user();

        if ($user->two_factor_secret) {
            return redirect('/admin')->with('error', '2FA sudah diaktifkan.');
        }

        $secret = $this->generateSecret();
        $recoveryCodes = $this->generateRecoveryCodes();

        session(['2fa_setup_secret' => $secret, '2fa_setup_recovery' => $recoveryCodes]);

        $qrCodeUrl = $this->getQrCodeUrl($user->email, $secret);
        $qr = new \chillerlan\QRCode\QRCode();
        $qrCodeSvg = $qr->render($qrCodeUrl);

        return view('auth.2fa-setup', compact('secret', 'recoveryCodes', 'qrCodeSvg'));
    }

    public function enable(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $secret = session('2fa_setup_secret');
        $recoveryCodes = session('2fa_setup_recovery');

        if (!$secret || !$recoveryCodes) {
            return redirect('/admin/2fa/setup')->with('error', 'Sesi setup expired. Silakan coba lagi.');
        }

        if (!$this->verifyOtp($secret, $request->otp)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        $user = Auth::user();
        $user->update([
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => encrypt(implode(',', $recoveryCodes)),
            'two_factor_verified_at' => now(),
        ]);

        session()->forget(['2fa_setup_secret', '2fa_setup_recovery']);

        return redirect('/admin')->with('success', '2FA berhasil diaktifkan! Simpan kode recovery di tempat yang aman.');
    }

    public function showVerifyForm()
    {
        if (!session('2fa_user_id')) {
            return redirect('/login');
        }

        return view('auth.2fa-verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);

        $userId = session('2fa_user_id');

        if (!$userId) {
            return redirect('/login');
        }

        $user = \App\Models\User::find($userId);

        if (!$user || !$user->two_factor_secret) {
            return redirect('/login');
        }

        if ($this->verifyOtp($user->two_factor_secret, $request->otp)) {
            Auth::login($user);
            session()->forget('2fa_user_id');
            $request->session()->put('2fa_verified', true);

            Log::channel('activity')->info('Login successful (2FA)', [
                'user' => $user->email,
                'ip' => $request->ip(),
            ]);

            return redirect('/admin');
        }

        $recoveryCodes = decrypt($user->two_factor_recovery_codes);
        $codes = explode(',', $recoveryCodes);

        if (in_array($request->otp, $codes)) {
            $codes = array_filter($codes, fn($c) => $c !== $request->otp);
            $user->update(['two_factor_recovery_codes' => encrypt(implode(',', array_values($codes)))]);

            Auth::login($user);
            session()->forget('2fa_user_id');
            $request->session()->put('2fa_verified', true);

            return redirect('/admin');
        }

        return back()->withErrors(['otp' => 'Kode OTP atau recovery code tidak valid.']);
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        $user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_verified_at' => null,
        ]);

        $request->session()->forget('2fa_verified');

        return redirect('/admin')->with('success', '2FA berhasil dinonaktifkan.');
    }

    public function regenerateRecoveryCodes(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        $recoveryCodes = $this->generateRecoveryCodes();
        $user->update(['two_factor_recovery_codes' => encrypt(implode(',', $recoveryCodes))]);

        return back()->with('success', 'Kode recovery baru berhasil dibuat. Simpan di tempat yang aman.');
    }

    private function generateSecret(): string
    {
        return Str::random(16);
    }

    private function generateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(Str::random(4) . '-' . Str::random(4));
        }
        return $codes;
    }

    private function verifyOtp(string $secret, string $otp): bool
    {
        $time = floor(time() / 30);

        for ($i = -1; $i <= 1; $i++) {
            $counter = str_pad(dechex($time + $i), 16, '0', STR_PAD_LEFT);
            $hash = hash_hmac('sha1', $counter, $secret);
            $offset = hexdec(substr($hash, -1)) & 0xf;
            $code = hexdec(substr($hash, $offset, 8)) & 0x7fffffff;
            $generatedOtp = str_pad($code % 1000000, 6, '0', STR_PAD_LEFT);

            if (hash_equals($generatedOtp, $otp)) {
                return true;
            }
        }

        return false;
    }

    private function getQrCodeUrl(string $email, string $secret): string
    {
        $issuer = urlencode('Bakso Pim');
        $label = urlencode($email);
        return "otpauth://totp/{$issuer}:{$label}?secret={$secret}&issuer={$issuer}&algorithm=SHA1&digits=6&period=30";
    }
}

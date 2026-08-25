<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        if ($request->input('dummy_email') !== null) {
            abort(403, 'Akses ditolak.');
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->two_factor_secret) {
                $request->session()->put('2fa_user_id', Auth::id());
                Auth::logout();
                return redirect('/admin/2fa/verify');
            }

            Log::channel('activity')->info('Login successful', [
                'user' => $request->email,
                'ip' => $request->ip(),
            ]);

            return redirect()->intended('/admin');
        }

        Log::channel('activity')->warning('Login failed', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Log::channel('activity')->info('Logout', [
            'user' => Auth::user()->email ?? 'unknown',
            'ip' => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        $totalMakanan = Cache::remember('dashboard_total_makanan', 300, function () {
            return Menu::where('category', 'makanan')->count();
        });
        $totalMinuman = Cache::remember('dashboard_total_minuman', 300, function () {
            return Menu::where('category', 'minuman')->count();
        });
        $totalMenu = Cache::remember('dashboard_total_menu', 300, function () {
            return Menu::count();
        });
        $pendingOrders = Cache::remember('dashboard_pending_orders', 60, function () {
            return Order::where('status', 'pending')->count();
        });
        $unreadOrders = Cache::remember('dashboard_unread_orders', 60, function () {
            return Order::where('is_read', false)->count();
        });
        $unreadMessages = Cache::remember('dashboard_unread_messages', 60, function () {
            return Message::where('is_read', false)->count();
        });

        return response()->view('admin.index', compact('totalMakanan', 'totalMinuman', 'totalMenu', 'pendingOrders', 'unreadOrders', 'unreadMessages'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function qrcode()
    {
        $url = url('/');
        $qrCodeSvg = Cache::remember('qrcode_svg', 3600, function () use ($url) {
            $qr = new \chillerlan\QRCode\QRCode();
            return $qr->render($url);
        });

        return view('admin.qrcode', compact('url', 'qrCodeSvg'));
    }

    public function registerForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        if ($request->input('website') !== null) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20|regex:/^[0-9+\-\s]+$/',
            'status' => 'required|in:admin,kasir,staff',
            'password' => ['required', 'min:8', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        Log::channel('activity')->info('New admin registered', [
            'by' => Auth::user()->email ?? 'system',
            'new_user' => $validated['email'],
            'ip' => $request->ip(),
        ]);

        return redirect('/admin')->with('success', 'Admin baru berhasil ditambahkan.');
    }
}

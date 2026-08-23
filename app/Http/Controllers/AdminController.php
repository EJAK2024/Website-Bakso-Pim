<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

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
        $totalMakanan = Menu::where('category', 'makanan')->count();
        $totalMinuman = Menu::where('category', 'minuman')->count();
        $totalMenu = Menu::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $unreadOrders = Order::where('is_read', false)->count();
        $unreadMessages = Message::where('is_read', false)->count();

        return view('admin.index', compact('totalMakanan', 'totalMinuman', 'totalMenu', 'pendingOrders', 'unreadOrders', 'unreadMessages'));
    }

    public function qrcode()
    {
        $url = url('/');
        return view('admin.qrcode', compact('url'));
    }

    public function registerForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
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

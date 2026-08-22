<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
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
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:admin,kasir,staff',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'status' => $validated['status'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect('/admin')->with('success', 'Admin baru berhasil ditambahkan.');
    }
}

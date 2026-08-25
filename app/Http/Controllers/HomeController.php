<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPaymentVerification;
use App\Jobs\SendOrderNotification;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function index()
    {
        $makanan = Cache::remember('menu_makanan', 300, function () {
            return Menu::where('category', 'makanan')->where('is_available', true)->get();
        });
        $minuman = Cache::remember('menu_minuman', 300, function () {
            return Menu::where('category', 'minuman')->where('is_available', true)->get();
        });

        return view('main', compact('makanan', 'minuman'));
    }

    public function pesan()
    {
        $makanan = Cache::remember('menu_makanan', 300, function () {
            return Menu::where('category', 'makanan')->where('is_available', true)->get();
        });
        $minuman = Cache::remember('menu_minuman', 300, function () {
            return Menu::where('category', 'minuman')->where('is_available', true)->get();
        });

        return view('pesan', compact('makanan', 'minuman'));
    }

    public function submitOrder(Request $request)
    {
        if ($request->input('website') !== null) {
            abort(403, 'Akses ditolak.');
        }

        if (!Order::isOperationalHours()) {
            return redirect()->route('pesan')->withErrors(['order' => 'Toko sedang tutup. Jam operasional: 10:00 - 23:00 WIB.']);
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9]+$/',
            'address' => 'required|string|max:500',
            'menu_ids' => 'required|array|min:1',
            'menu_ids.*' => 'exists:menus,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'integer|min:1|max:99',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:qris,kasir',
        ]);

        $validated['customer_name'] = strip_tags($validated['customer_name']);
        $validated['address'] = strip_tags($validated['address']);
        $validated['notes'] = isset($validated['notes']) ? strip_tags($validated['notes']) : null;

        $order = DB::transaction(function () use ($validated) {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
            ]);

            $totalPrice = 0;

            $menus = Menu::whereIn('id', $validated['menu_ids'])->get()->keyBy('id');

            foreach ($validated['menu_ids'] as $index => $menuId) {
                $menu = $menus->get($menuId);
                if (!$menu) {
                    abort(422, 'Menu tidak ditemukan.');
                }
                $quantity = $validated['quantities'][$index] ?? 1;
                $subtotal = $menu->price * $quantity;
                $totalPrice += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menuId,
                    'quantity' => $quantity,
                    'price' => $menu->price,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);

            return $order;
        });

        Cache::forget('dashboard_pending_orders');

        SendOrderNotification::dispatch($order);
        ProcessPaymentVerification::dispatch($order);

        if ($validated['payment_method'] === 'qris') {
            return redirect()->temporarySignedRoute('order.qris', now()->addMinutes(30), ['order' => $order->id]);
        }

        return redirect()->temporarySignedRoute('order.struk', now()->addMinutes(30), ['order' => $order->id]);
    }

    public function qris(Order $order)
    {
        $order->load('items.menu');
        return view('qris', compact('order'));
    }

    public function struk(Order $order)
    {
        $order->load('items.menu');
        return view('struk', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');
        $order->update(['payment_proof' => $path]);

        return redirect()->temporarySignedRoute('order.struk', now()->addMinutes(30), ['order' => $order->id]);
    }
}

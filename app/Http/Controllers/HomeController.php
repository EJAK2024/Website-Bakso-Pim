<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $makanan = Menu::where('category', 'makanan')->where('is_available', true)->get();
        $minuman = Menu::where('category', 'minuman')->where('is_available', true)->get();

        return view('main', compact('makanan', 'minuman'));
    }

    public function pesan()
    {
        $makanan = Menu::where('category', 'makanan')->where('is_available', true)->get();
        $minuman = Menu::where('category', 'minuman')->where('is_available', true)->get();

        return view('pesan', compact('makanan', 'minuman'));
    }

    public function submitOrder(Request $request)
    {
        if (!Order::isOperationalHours()) {
            return redirect()->route('pesan')->withErrors(['order' => 'Toko sedang tutup. Jam operasional: 10:00 - 23:00 WIB.']);
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'menu_ids' => 'required|array|min:1',
            'menu_ids.*' => 'exists:menus,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'integer|min:1',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:qris,kasir',
        ]);

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
        ]);

        $totalPrice = 0;

        foreach ($validated['menu_ids'] as $index => $menuId) {
            $menu = Menu::findOrFail($menuId);
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

        if ($validated['payment_method'] === 'qris') {
            return redirect()->route('order.qris', $order->id);
        }

        return redirect()->route('order.struk', $order->id);
    }

    public function qris($id)
    {
        $order = Order::with('items.menu')->findOrFail($id);
        return view('qris', compact('order'));
    }

    public function struk($id)
    {
        $order = Order::with('items.menu')->findOrFail($id);
        return view('struk', compact('order'));
    }
}

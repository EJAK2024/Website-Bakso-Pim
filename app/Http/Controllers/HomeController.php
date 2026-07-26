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
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'menu_ids' => 'required|array|min:1',
            'menu_ids.*' => 'exists:menus,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
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

        return redirect('/pesan')->with('success', 'Pesanan berhasil dikirim! Nomor pesanan Anda: #' . $order->id);
    }
}

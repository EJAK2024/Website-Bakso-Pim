<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.menu')->latest()->get();
        $unreadCount = Order::where('is_read', false)->count();

        return view('admin.orders.index', compact('orders', 'unreadCount'));
    }

    public function show(Order $order)
    {
        $order->update(['is_read' => true]);
        $order->load('items.menu');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        $order->update($validated);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function markAllRead()
    {
        Order::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Semua pesanan ditandai sudah dibaca.');
    }
}

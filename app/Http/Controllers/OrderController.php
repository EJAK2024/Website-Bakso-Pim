<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.menu')->latest()->paginate(20);
        $unreadCount = Cache::remember('dashboard_unread_orders', 60, function () {
            return Order::where('is_read', false)->count();
        });

        return view('admin.orders.index', compact('orders', 'unreadCount'));
    }

    public function show(Order $order)
    {
        $order->update(['is_read' => true]);
        Cache::forget('dashboard_unread_orders');
        $order->load('items.menu');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        if ($validated['status'] === 'pending') {
            Cache::forget('dashboard_pending_orders');
        }

        Log::channel('activity')->info('Order status updated', [
            'user' => auth()->user()->email ?? 'unknown',
            'order_id' => $order->id,
            'old_status' => $oldStatus,
            'new_status' => $validated['status'],
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function markAllRead()
    {
        Order::where('is_read', false)->update(['is_read' => true]);
        Cache::forget('dashboard_unread_orders');
        return redirect('/admin')->with('success', 'Semua pesanan ditandai sudah dibaca.');
    }

    public function paymentProofs()
    {
        $orders = Order::where('payment_method', 'qris')
            ->whereNotNull('payment_proof')
            ->latest()
            ->paginate(20);

        return view('admin.orders.payment-proofs', compact('orders'));
    }
}

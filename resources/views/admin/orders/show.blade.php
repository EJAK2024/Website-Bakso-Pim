@extends('layouts.admin')

@section('content')
    <section class="flex-1 py-10">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('orders.index') }}" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-300 transition-all duration-150 active:scale-95">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </a>
                <h1 class="text-3xl font-bold text-green-700">Detail Pesanan #{{ $order->daily_order_number }}</h1>
            </div>
            <p class="text-gray-500 mb-8">{{ $order->created_at->format('d M Y, H:i') }}</p>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Pelanggan</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama</p>
                        <p class="font-semibold text-gray-800">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. HP</p>
                        <p class="font-semibold text-gray-800">{{ $order->phone }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="font-semibold text-gray-800">{{ $order->address }}</p>
                    </div>
                    @if($order->notes)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Catatan</p>
                            <p class="font-semibold text-gray-800 bg-yellow-50 p-2 rounded">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Item Pesanan</h2>
                <div class="space-y-3">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <span class="font-semibold text-gray-800">{{ $item->menu->name ?? 'Menu dihapus' }}</span>
                                <span class="text-gray-500 ml-2">x{{ $item->quantity }}</span>
                            </div>
                            <div class="font-bold text-green-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-800">Total</span>
                    <span class="text-2xl font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Ubah Status</h2>
                <form method="POST" action="{{ route('orders.updateStatus', $order) }}">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center gap-4">
                        <select name="status" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @php
                                $statuses = [
                                    'pending' => 'Menunggu',
                                    'diproses' => 'Diproses',
                                    'dikirim' => 'Dikirim',
                                    'selesai' => 'Selesai',
                                    'dibatalkan' => 'Dibatalkan',
                                ];
                            @endphp
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-all duration-150 active:scale-95">
                            <i class="fas fa-save mr-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

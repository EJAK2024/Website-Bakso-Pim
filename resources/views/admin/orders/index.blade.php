@extends('layouts.admin')

@section('content')
    <section class="flex-1 py-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-green-700">Pesanan Masuk</h1>
                    <p class="text-gray-500">Pantau pesanan dari pelanggan</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($unreadCount > 0)
                        <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full animate-pulse">
                            {{ $unreadCount }} baru
                        </span>
                        <a href="{{ route('orders.readAll') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition-all duration-150 active:scale-95">
                            <i class="fas fa-check-double mr-1"></i>Tandai Sudah Dibaca
                        </a>
                    @endif
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="space-y-4">
                @forelse ($orders as $order)
                    <div class="bg-white rounded-xl shadow-lg p-6 {{ !$order->is_read ? 'border-l-4 border-red-500 bg-red-50/30' : '' }}">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-gray-800">#{{ $order->daily_order_number }} - {{ $order->customer_name }}</h3>
                                    @if(!$order->is_read)
                                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">BARU</span>
                                    @endif
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'diproses' => 'bg-blue-100 text-blue-700',
                                            'dikirim' => 'bg-purple-100 text-purple-700',
                                            'selesai' => 'bg-green-100 text-green-700',
                                            'dibatalkan' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'diproses' => 'Diproses',
                                            'dikirim' => 'Dikirim',
                                            'selesai' => 'Selesai',
                                            'dibatalkan' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] }}">
                                        {{ $statusLabels[$order->status] }}
                                    </span>
                                </div>
                                <div class="grid md:grid-cols-3 gap-2 text-sm text-gray-600">
                                    <div><i class="fas fa-phone mr-2 text-green-600"></i>{{ $order->phone }}</div>
                                    <div class="md:col-span-2"><i class="fas fa-map-marker-alt mr-2 text-green-600"></i>{{ Str::limit($order->address, 60) }}</div>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    <i class="fas fa-clock mr-2"></i>{{ $order->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Total</p>
                                    <p class="text-xl font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('orders.show', $order) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition-all duration-150 active:scale-95">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <i class="fas fa-shopping-cart text-5xl text-gray-300 mb-4 block"></i>
                        <p class="text-gray-500 text-lg">Belum ada pesanan masuk</p>
                        <p class="text-gray-400 text-sm mt-1">Pesanan dari pelanggan akan muncul di sini</p>
                    </div>
                @endforelse
            </div>

            @if($orders->hasPages())
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

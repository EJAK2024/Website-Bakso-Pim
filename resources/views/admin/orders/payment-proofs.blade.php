@extends('layouts.admin')

@section('content')
    <section class="flex-1 py-6 sm:py-10">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-6 sm:mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-green-700">Bukti Pembayaran QRIS</h1>
                    <p class="text-gray-500 text-sm mt-1">Daftar bukti pembayaran dari pelanggan</p>
                </div>
                <a href="{{ route('orders.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-all active:scale-95 text-sm">
                    &#8592; Kembali
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 text-lg font-semibold">Belum ada bukti pembayaran</p>
                    <p class="text-gray-400 text-sm mt-1">Bukti pembayaran QRIS akan muncul di sini</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                            <div class="p-4 sm:p-5">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-semibold">No. Pesanan</p>
                                        <p class="text-lg font-bold text-green-700">#{{ $order->daily_order_number }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        @if($order->status === 'selesai') bg-green-100 text-green-700
                                        @elseif($order->status === 'dibatalkan') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>

                                <div class="space-y-1.5 mb-3 text-sm">
                                    <div class="flex items-center text-gray-600">
                                        <span class="w-5 mr-2 text-center">&#128100;</span>
                                        <span class="font-medium">{{ $order->customer_name }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <span class="w-5 mr-2 text-center">&#128222;</span>
                                        <span class="font-mono">{{ $order->phone }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <span class="w-5 mr-2 text-center">&#128176;</span>
                                        <span class="font-bold text-green-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <p class="text-xs text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }} WIB</p>
                            </div>

                            <div class="border-t border-gray-100 bg-gray-50 p-4">
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Bukti Pembayaran</p>
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="block group">
                                    <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran #{{ $order->daily_order_number }}" class="w-full h-48 object-cover rounded-lg border border-gray-200 group-hover:border-green-400 transition-colors">
                                </a>
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="mt-2 inline-flex items-center text-sm text-green-600 hover:text-green-800 font-semibold">
                                    <i class="fas fa-external-link-alt mr-1"></i> Lihat Full
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

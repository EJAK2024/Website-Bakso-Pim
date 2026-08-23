@extends('layouts.public')

@section('content')
    <section class="py-8 sm:py-12 flex-1">
        <div class="container mx-auto px-4 max-w-lg receipt-outer">
            <div class="text-center mb-8 no-print">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full mb-4 shadow-lg shadow-green-200">
                    <span class="text-white text-3xl">&#10004;</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800">Pesanan Tercatat!</h1>
                <p class="text-gray-500 mt-2 text-sm">Tunjukkan struk ini ke kasir / karyawan</p>
            </div>

            <div class="receipt-card bg-white rounded-2xl shadow-2xl shadow-green-100/50 overflow-hidden border border-gray-100">
                <!-- Header -->
                <div class="relative bg-gradient-to-r from-green-700 via-green-600 to-green-700 text-white py-6 px-6 text-center overflow-hidden">
                    <div class="absolute inset-0 stripe-pattern opacity-30"></div>
                    <div class="relative">
                        <div class="flex items-center justify-center mb-2">
                            <img src="/images/logo.png" alt="Bakso Pim" class="h-12 w-12 object-cover rounded-full mr-3 border-2 border-white/30 shadow-lg">
                            <div class="text-left">
                                <p class="text-2xl font-extrabold tracking-tight">BAKSO PIM</p>
                                <p class="text-green-200 text-xs tracking-widest uppercase">Rumah Makan Bakso</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center text-green-200 text-xs mt-3 space-x-4">
                            <span>&#128205; Jl. Bakso Jaya No. 456</span>
                            <span class="w-1 h-1 bg-green-400 rounded-full"></span>
                            <span>&#128222; +62 123 4567 890</span>
                        </div>
                    </div>
                </div>

                <!-- Dashed Separator -->
                <div class="receipt-edge-top h-3 bg-white -mt-1 relative z-10"></div>

                <div class="px-6 py-5">
                    <!-- Order Info Grid -->
                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <div class="bg-green-50 rounded-xl p-3 text-center border border-green-100">
                            <p class="text-[10px] text-green-600 uppercase tracking-wider font-semibold mb-1">No. Pesanan</p>
                            <p class="text-xl font-extrabold text-green-700 font-mono">#{{ $order->daily_order_number }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3 text-center border border-gray-100">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold mb-1">Tanggal</p>
                            <p class="text-sm font-bold text-gray-700 font-mono">{{ $order->created_at->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500 font-mono">{{ $order->created_at->format('H:i') }} WIB</p>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="mb-5">
                        <h3 class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-3 flex items-center">
                            <span class="flex-1 h-px bg-gray-200"></span>
                            <span class="px-3">Informasi Pelanggan</span>
                            <span class="flex-1 h-px bg-gray-200"></span>
                        </h3>
                        <div class="space-y-2.5">
                            <div class="flex items-center text-sm">
                                <div class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <span class="text-green-600 text-xs">&#128100;</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] text-gray-400 uppercase">Nama</p>
                                    <p class="font-semibold text-gray-800 truncate">{{ $order->customer_name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center text-sm">
                                <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <span class="text-blue-600 text-xs">&#128222;</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] text-gray-400 uppercase">No. HP</p>
                                    <p class="font-semibold text-gray-800 font-mono">{{ $order->phone }}</p>
                                </div>
                            </div>
                            <div class="flex items-start text-sm">
                                <div class="w-7 h-7 bg-amber-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                                    <span class="text-amber-600 text-xs">&#128205;</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] text-gray-400 uppercase">Alamat</p>
                                    <p class="font-medium text-gray-700 text-sm leading-snug">{{ $order->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-5">
                        <div class="flex items-center justify-between bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-3 text-white">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-white">{{ $order->payment_method === 'qris' ? '&#9641;' : '&#127978;' }}</span>
                                </div>
                                <div>
                                    <p class="text-[10px] text-green-200 uppercase">Metode Pembayaran</p>
                                    <p class="font-bold">{{ $order->payment_method === 'qris' ? 'QRIS' : 'Bayar di Kasir' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-green-200 uppercase">Total</p>
                                <p class="text-lg font-extrabold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="mb-5">
                        <h3 class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-3 flex items-center">
                            <span class="flex-1 h-px bg-gray-200"></span>
                            <span class="px-3">Detail Pesanan</span>
                            <span class="flex-1 h-px bg-gray-200"></span>
                        </h3>
                        <div class="bg-gray-50 rounded-xl border border-gray-100 overflow-hidden">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-100/80">
                                        <th class="text-left py-2 px-3 text-[10px] text-gray-500 uppercase font-bold">Menu</th>
                                        <th class="text-center py-2 px-2 text-[10px] text-gray-500 uppercase font-bold">Qty</th>
                                        <th class="text-right py-2 px-3 text-[10px] text-gray-500 uppercase font-bold">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($order->items as $item)
                                        <tr class="hover:bg-white transition-colors">
                                            <td class="py-2.5 px-3">
                                                <p class="font-semibold text-gray-800">{{ $item->menu->name }}</p>
                                                <p class="text-[10px] text-gray-400 font-mono">Rp {{ number_format($item->price, 0, ',', '.') }}/pcs</p>
                                            </td>
                                            <td class="py-2.5 px-2 text-center">
                                                <span class="inline-flex items-center justify-center w-7 h-7 bg-green-100 text-green-700 rounded-lg text-xs font-bold font-mono">x{{ $item->quantity }}</span>
                                            </td>
                                            <td class="py-2.5 px-3 text-right">
                                                <span class="font-bold text-gray-800 font-mono">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($order->notes)
                        <div class="mb-5">
                            <div class="bg-amber-50 rounded-xl p-3 border border-amber-200 flex items-start">
                                <div class="w-6 h-6 bg-amber-100 rounded-md flex items-center justify-center mr-2.5 flex-shrink-0 mt-0.5">
                                    <span class="text-amber-600 text-[10px]">&#128221;</span>
                                </div>
                                <div>
                                    <p class="text-[10px] text-amber-600 uppercase font-bold mb-0.5">Catatan</p>
                                    <p class="text-sm text-amber-800">{{ $order->notes }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Dashed Separator -->
                    <div class="border-t-2 border-dashed border-gray-200 my-5"></div>

                    <!-- Total -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Grand Total</p>
                            <p class="text-xs text-gray-500">Termasuk pajak</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-extrabold text-green-700 font-mono">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gradient-to-r from-green-700 via-green-600 to-green-700 py-4 px-6 text-center relative overflow-hidden">
                    <div class="absolute inset-0 stripe-pattern opacity-20"></div>
                    <div class="relative">
                        <p class="text-green-200 text-xs italic mb-1">Terima kasih atas kunjungan Anda</p>
                        <div class="flex items-center justify-center space-x-2">
                            <span class="h-px flex-1 bg-green-500/30"></span>
                            <span class="text-green-300 text-xs">&#10084;</span>
                            <span class="h-px flex-1 bg-green-500/30"></span>
                        </div>
                        <p class="text-green-300 text-[10px] mt-1 font-mono">BAKSO PIM EST. 1983</p>
                    </div>
                </div>

                <div class="receipt-edge-bottom h-3 bg-white -mb-1 relative z-10"></div>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-3 no-print">
                <button onclick="window.print()" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white py-4 rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all duration-200 active:scale-[0.98] shadow-lg shadow-green-200 flex items-center justify-center">
                    &#128438; Cetak Struk
                </button>
                <a href="/" class="flex-1 text-center bg-white text-gray-700 py-4 rounded-xl font-bold hover:bg-gray-50 transition-all duration-200 active:scale-[0.98] shadow-md border border-gray-200 flex items-center justify-center">
                    &#127968; Kembali
                </a>
            </div>

            <p class="text-center text-gray-400 text-xs mt-4 no-print">
                &#128272; Struk ini adalah bukti pesanan yang valid
            </p>
        </div>
    </section>
@endsection

@push('styles')
<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .receipt-card { box-shadow: none !important; border: none !important; }
        .receipt-outer { padding: 0 !important; background: white !important; }
    }
    .receipt-dashed {
        background-image: repeating-linear-gradient(0deg, transparent, transparent 7px, #d1d5db 7px, #d1d5db 8px),
                          repeating-linear-gradient(90deg, transparent, transparent 7px, #d1d5db 7px, #d1d5db 8px);
        background-size: 8px 100%, 100% 8px;
        background-position: 0 0, 0 0;
        background-repeat: repeat-y, repeat-x;
    }
    .receipt-edge-top {
        background: radial-gradient(circle at 10px -5px, transparent 12px, white 12px);
        background-size: 20px 20px;
        background-repeat: repeat-x;
    }
    .receipt-edge-bottom {
        background: radial-gradient(circle at 10px 5px, transparent 12px, white 12px);
        background-size: 20px 20px;
        background-repeat: repeat-x;
    }
    .stripe-pattern {
        background: repeating-linear-gradient(
            -45deg,
            transparent,
            transparent 4px,
            rgba(255,255,255,0.1) 4px,
            rgba(255,255,255,0.1) 8px
        );
    }
</style>
@endpush

@extends('layouts.admin')

@section('content')
    <section class="flex-1 py-6 sm:py-10">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-3 mb-2">
                <a href="/admin" class="text-gray-400 hover:text-green-600 transition-colors">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-green-700">QR Code Meja</h1>
            </div>
            <p class="text-gray-500 mb-6 sm:mb-8 ml-8">Generate QR code untuk akses cepat pelanggan ke website.</p>

            <div class="flex justify-center">
                <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-10 w-full max-w-md border border-gray-100">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-green-100 rounded-full mb-4">
                            <i class="fas fa-qrcode text-2xl text-green-600"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Scan untuk Mengakses</h2>
                        <p class="text-sm text-gray-500 mt-1">Bakso Pim - Website Pemesanan</p>
                    </div>

                    <div id="qr-print-area" class="flex justify-center mb-6">
                        <div class="bg-white p-4 rounded-xl border-2 border-gray-100 shadow-inner">
                            <img
                                src="{{ $qrCodeSvg }}"
                                alt="QR Code Bakso Pim"
                                class="w-64 h-64 sm:w-72 sm:h-72 object-contain"
                                id="qrImage"
                            >
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Website URL</p>
                        <p class="text-sm text-green-700 font-mono bg-green-50 px-4 py-2 rounded-lg break-all">{{ $url }}</p>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6 flex items-start gap-3">
                        <i class="fas fa-info-circle text-amber-500 mt-0.5 flex-shrink-0"></i>
                        <p class="text-sm text-amber-700">Taruh QR ini di meja agar pelanggan bisa langsung mengakses website untuk melihat menu dan melakukan pemesanan.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button
                            onclick="downloadQR()"
                            class="flex-1 flex items-center justify-center gap-2 bg-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition-all duration-150 active:scale-[1.02] shadow-md"
                        >
                            <i class="fas fa-download"></i> Download QR
                        </button>
                        <button
                            onclick="printQR()"
                            class="flex-1 flex items-center justify-center gap-2 bg-white text-green-700 font-semibold py-3 px-6 rounded-lg border-2 border-green-600 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]"
                        >
                            <i class="fas fa-print"></i> Cetak QR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function downloadQR() {
        const link = document.createElement('a');
        link.href = '{{ $qrCodeSvg }}';
        link.download = 'QR-Code-Bakso-Pim.svg';
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function printQR() {
        window.print();
    }
</script>
@endpush

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        #qr-print-area, #qr-print-area * { visibility: visible; }
        #qr-print-area { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); }
    }
</style>
@endpush

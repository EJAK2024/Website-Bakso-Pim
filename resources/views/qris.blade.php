<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - Bakso Pim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <nav class="bg-white py-4 shadow-lg border-b border-gray-200 no-print">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-xl sm:text-2xl font-bold">
                    <a href="/" class="flex items-center focus:outline-none focus:ring-0 focus:bg-transparent">
                        <img src="/images/logo.png" alt="Bakso Pim" class="inline-block h-10 w-10 sm:h-12 sm:w-12 object-cover rounded-full mr-2 shadow-md">
                        <span class="text-green-800" style="-webkit-text-stroke: 0.5px #166534; paint-order: stroke fill;">Bakso Pim</span>
                    </a>
                </div>
                <a href="/" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </a>
            </div>
        </div>
    </nav>

    <section class="py-8 sm:py-12 flex-1">
        <div class="container mx-auto px-4 max-w-lg">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <i class="fas fa-qrcode text-green-600 text-3xl"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-green-700">Pembayaran QRIS</h1>
                <p class="text-gray-500 mt-2 text-sm">Scan QR Code di bawah untuk membayar</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 text-center">
                <div class="mb-4">
                    <span class="text-sm text-gray-500">Nomor Pesanan</span>
                    <p class="text-2xl font-bold text-green-700">#{{ $order->daily_order_number }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 mb-6 border-2 border-dashed border-gray-300">
                    <img src="/images/qris-placeholder.png" alt="QRIS Code" class="w-56 h-56 mx-auto object-contain">
                    <p class="text-xs text-gray-400 mt-3">Ganti gambar ini dengan QR Code QRIS asli di <code class="bg-gray-200 px-1 rounded">public/images/qris-placeholder.png</code></p>
                </div>

                <div class="bg-green-50 rounded-lg p-4 mb-6">
                    <span class="text-sm text-gray-600">Total yang harus dibayar</span>
                    <p class="text-3xl font-bold text-green-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>

                <div class="text-left bg-gray-50 rounded-lg p-4 mb-6 text-sm">
                    <p class="font-semibold text-gray-700 mb-2">Cara Bayar:</p>
                    <ol class="list-decimal list-inside text-gray-600 space-y-1">
                        <li>Buka aplikasi mobile banking / e-wallet</li>
                        <li>Pilih menu <strong>Scan QR</strong></li>
                        <li>Scan QR Code di atas</li>
                        <li>Masukkan nominal sesuai total</li>
                        <li>Konfirmasi pembayaran</li>
                    </ol>
                </div>

                <a href="{{ route('order.struk', $order->id) }}" class="block w-full bg-green-600 text-white py-4 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg no-print">
                    <i class="fas fa-check-circle mr-2"></i>Sudah Bayar
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-green-900 text-white py-6 no-print">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2026 Bakso Pim. Semua hak dilindungi.</p>
        </div>
    </footer>
</body>
</html>

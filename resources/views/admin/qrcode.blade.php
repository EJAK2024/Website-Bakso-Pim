<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Meja - Bakso Pim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            body * { visibility: hidden; }
            #qr-print-area, #qr-print-area * { visibility: visible; }
            #qr-print-area { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <nav class="bg-white py-4 sticky top-0 z-50 shadow-lg border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-xl sm:text-2xl font-bold">
                    <a href="/" class="flex items-center focus:outline-none focus:ring-0 focus:bg-transparent">
                        <img src="/images/logo.png" alt="Bakso Pim" class="inline-block h-10 w-10 sm:h-12 sm:w-12 object-cover rounded-full mr-2 shadow-md">
                        <span class="text-green-800" style="-webkit-text-stroke: 0.5px #166534; paint-order: stroke fill;">Bakso Pim</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                    <a href="/" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">Beranda</a>
                    <a href="/#BaksoPim" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">Menu</a>
                    <a href="/#contact" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">Kontak</a>
                    <a href="/#about" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">Tentang Kami</a>
                    <a href="/admin" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">
                        <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                    </a>
                    <div class="flex items-center gap-3 border-l border-gray-300 pl-4">
                        <span class="text-sm text-gray-500"><i class="fas fa-user-circle mr-1"></i>{{ Auth::user()->name }}</span>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="font-medium text-red-500 hover:text-red-700 transition-all duration-150 active:scale-95 text-sm">
                                <i class="fas fa-sign-out-alt mr-1"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
                <button onclick="toggleMobileMenu()" class="md:hidden text-gray-700 active:scale-95 transition-transform duration-150 p-2">
                    <i id="hamburgerIcon" class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="container mx-auto px-4 py-3 space-y-1">
                <a href="/" class="block font-medium text-gray-700 hover:text-green-700 hover:bg-green-50 px-4 py-3 rounded-lg transition-all duration-150">Beranda</a>
                <a href="/#BaksoPim" class="block font-medium text-gray-700 hover:text-green-700 hover:bg-green-50 px-4 py-3 rounded-lg transition-all duration-150">Menu</a>
                <a href="/#contact" class="block font-medium text-gray-700 hover:text-green-700 hover:bg-green-50 px-4 py-3 rounded-lg transition-all duration-150">Kontak</a>
                <a href="/#about" class="block font-medium text-gray-700 hover:text-green-700 hover:bg-green-50 px-4 py-3 rounded-lg transition-all duration-150">Tentang Kami</a>
                <div class="border-t border-gray-200 mt-2 pt-2">
                    <a href="/admin" class="block font-medium text-gray-700 hover:text-green-700 hover:bg-green-50 px-4 py-3 rounded-lg transition-all duration-150">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <div class="px-4 py-2 text-sm text-gray-500">
                        <i class="fas fa-user-circle mr-1"></i>{{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="w-full text-left font-medium text-red-500 hover:text-red-700 hover:bg-red-50 px-4 py-3 rounded-lg transition-all duration-150">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

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
                                src="https://api.qrserver.com/v1/create-qr-code/size=400x400/?data={{ urlencode($url) }}"
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

    <footer class="bg-green-900 text-white py-4">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>&copy; 2026 Bakso Pim. Panel administrasi.</p>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('hamburgerIcon');
            menu.classList.toggle('hidden');
            if (menu.classList.contains('hidden')) {
                icon.className = 'fas fa-bars text-xl';
            } else {
                icon.className = 'fas fa-times text-xl';
            }
        }

        function downloadQR() {
            const link = document.createElement('a');
            link.href = 'https://api.qrserver.com/v1/create-qr-code/size=400x400/?data={{ urlencode($url) }}';
            link.download = 'QR-Code-Bakso-Pim.png';
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function printQR() {
            window.print();
        }
    </script>
</body>
</html>

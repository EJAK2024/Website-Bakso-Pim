<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Bakso Pim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <a href="/admin" class="font-medium text-green-700 border-b-2 border-green-700 transition-all duration-150 active:scale-95">
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
                    <a href="/admin" class="block font-medium text-green-700 bg-green-50 px-4 py-3 rounded-lg transition-all duration-150">
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
            <h1 class="text-2xl sm:text-3xl font-bold text-green-700 mb-2">Dashboard</h1>
            <p class="text-gray-500 mb-6 sm:mb-8">Selamat datang, <span class="font-semibold text-green-600">{{ Auth::user()->name }}</span>!</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6 mb-8 sm:mb-10">
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500 uppercase tracking-wide">Menu Makanan</p>
                            <p class="text-2xl sm:text-3xl font-bold text-green-700 mt-1">{{ $totalMakanan }}</p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-utensils text-lg sm:text-xl text-green-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-amber-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500 uppercase tracking-wide">Menu Minuman</p>
                            <p class="text-2xl sm:text-3xl font-bold text-amber-600 mt-1">{{ $totalMinuman }}</p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-glass-martini-alt text-lg sm:text-xl text-amber-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500 uppercase tracking-wide">Total Menu</p>
                            <p class="text-2xl sm:text-3xl font-bold text-blue-600 mt-1">{{ $totalMenu }}</p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-lg sm:text-xl text-blue-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 border-l-4 {{ $unreadOrders > 0 ? 'border-red-500' : 'border-gray-300' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500 uppercase tracking-wide">Pesanan Baru</p>
                            <p class="text-2xl sm:text-3xl font-bold {{ $unreadOrders > 0 ? 'text-red-600' : 'text-gray-400' }} mt-1">{{ $unreadOrders }}</p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 {{ $unreadOrders > 0 ? 'bg-red-100' : 'bg-gray-100' }} rounded-full flex items-center justify-center relative">
                            <i class="fas fa-bell text-lg sm:text-xl {{ $unreadOrders > 0 ? 'text-red-600' : 'text-gray-400' }}"></i>
                            @if($unreadOrders > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center animate-pulse">{{ $unreadOrders }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Kelola Website</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <a href="{{ route('menu.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-edit text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Kelola Menu</p>
                            <p class="text-sm text-gray-500">Tambah / ubah / hapus menu</p>
                        </div>
                    </a>
                    <a href="{{ route('orders.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02] relative">
                        <div class="w-10 h-10 {{ $unreadOrders > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-shopping-cart {{ $unreadOrders > 0 ? 'text-red-600' : 'text-green-600' }}"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Pesanan Masuk</p>
                            <p class="text-sm text-gray-500">Pantau pesanan pelanggan</p>
                        </div>
                        @if($unreadOrders > 0)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">{{ $unreadOrders }}</span>
                        @endif
                    </a>
                    <a href="{{ route('messages.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02] relative">
                        <div class="w-10 h-10 {{ $unreadMessages > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-envelope {{ $unreadMessages > 0 ? 'text-red-600' : 'text-green-600' }}"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Pesan</p>
                            <p class="text-sm text-gray-500">Pesan dari pengunjung</p>
                        </div>
                        @if($unreadMessages > 0)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">{{ $unreadMessages }}</span>
                        @endif
                    </a>
                    <a href="/register" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-user-plus text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Tambah Admin</p>
                            <p class="text-sm text-gray-500">Buat akun admin baru</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.qrcode') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-qrcode text-purple-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">QR Code Meja</p>
                            <p class="text-sm text-gray-500">Generate QR untuk ditaruh di meja</p>
                        </div>
                    </a>
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
    </script>
</body>
</html>

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
    <nav class="bg-green-800 text-white py-4 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold">
                    <a href="/admin" class="flex items-center drop-shadow-sm">
                        <img src="/images/logo.png" alt="Bakso Pim" class="inline-block h-12 w-12 object-cover rounded-full mr-2 shadow-md">
                        <span class="drop-shadow-sm">Admin</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-green-200 text-sm hidden md:inline">{{ Auth::user()->name }}</span>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="font-medium text-green-100 hover:text-white transition-all duration-150 drop-shadow-sm active:scale-95">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <section class="flex-1 py-10">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-green-700 mb-2">Dashboard</h1>
            <p class="text-gray-500 mb-8">Selamat datang, <span class="font-semibold text-green-600">{{ Auth::user()->name }}</span>!</p>

            <div class="grid md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Menu Makanan</p>
                            <p class="text-3xl font-bold text-green-700 mt-1">{{ $totalMakanan }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-utensils text-xl text-green-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-amber-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Menu Minuman</p>
                            <p class="text-3xl font-bold text-amber-600 mt-1">{{ $totalMinuman }}</p>
                        </div>
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-glass-martini-alt text-xl text-amber-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Total Menu</p>
                            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalMenu }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-xl text-blue-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 {{ $unreadOrders > 0 ? 'border-red-500' : 'border-gray-300' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Pesanan Baru</p>
                            <p class="text-3xl font-bold {{ $unreadOrders > 0 ? 'text-red-600' : 'text-gray-400' }} mt-1">{{ $unreadOrders }}</p>
                        </div>
                        <div class="w-12 h-12 {{ $unreadOrders > 0 ? 'bg-red-100' : 'bg-gray-100' }} rounded-full flex items-center justify-center relative">
                            <i class="fas fa-bell text-xl {{ $unreadOrders > 0 ? 'text-red-600' : 'text-gray-400' }}"></i>
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

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Kelola Website</h2>
                <div class="grid md:grid-cols-3 gap-4">
                    <a href="{{ route('menu.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-edit text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Kelola Menu</p>
                            <p class="text-sm text-gray-500">Tambah / ubah / hapus menu</p>
                        </div>
                    </a>
                    <a href="{{ route('orders.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02] relative">
                        <div class="w-10 h-10 {{ $unreadOrders > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-shopping-cart {{ $unreadOrders > 0 ? 'text-red-600' : 'text-green-600' }}"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Lihat Pesanan</p>
                            <p class="text-sm text-gray-500">Pantau pesanan masuk</p>
                        </div>
                        @if($unreadOrders > 0)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">{{ $unreadOrders }}</span>
                        @endif
                    </a>
                    <a href="/register" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user-plus text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Tambah Admin</p>
                            <p class="text-sm text-gray-500">Buat akun admin baru</p>
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
</body>
</html>

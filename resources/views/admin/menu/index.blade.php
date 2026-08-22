<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu - Bakso Pim</title>
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

    <section class="flex-1 py-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-green-700">Kelola Menu</h1>
                    <p class="text-gray-500">Tambah, ubah, atau hapus menu makanan & minuman</p>
                </div>
                <a href="{{ route('menu.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Tambah Menu
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wide">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wide">Nama Menu</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wide">Kategori</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wide">Harga</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wide">Status</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600 uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($menus as $index => $menu)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($menu->image)
                                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-12 h-12 object-cover rounded-lg shadow flex-shrink-0">
                                            @else
                                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-image text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-semibold text-gray-800">{{ $menu->name }}</div>
                                                @if($menu->description)
                                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($menu->description, 50) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($menu->category === 'makanan')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Makanan</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Minuman</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-green-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @if($menu->is_available)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Tersedia</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Habis</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('menu.edit', $menu) }}" class="bg-blue-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-600 transition-all duration-150 active:scale-95" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('menu.destroy', $menu) }}" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-600 transition-all duration-150 active:scale-95" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <i class="fas fa-utensils text-4xl text-gray-300 mb-3 block"></i>
                                        Belum ada menu. Klik "Tambah Menu" untuk menambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

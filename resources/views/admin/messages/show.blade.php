<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan dari {{ $message->name }} - Bakso Pim</title>
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
        <div class="container mx-auto px-4 max-w-2xl">
            <h1 class="text-2xl sm:text-3xl font-bold text-green-700 mb-2">Detail Pesan</h1>
            <p class="text-gray-500 mb-6 sm:mb-8">{{ $message->created_at->format('d M Y, H:i') }}</p>

            <div class="bg-white rounded-xl shadow-lg p-5 sm:p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Pengirim</h2>
                <div class="space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                        <span class="text-sm text-gray-500 sm:w-24 flex-shrink-0">Nama</span>
                        <span class="font-semibold text-gray-800">{{ $message->name }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                        <span class="text-sm text-gray-500 sm:w-24 flex-shrink-0">Email</span>
                        <span class="font-semibold text-gray-800">{{ $message->email }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                        <span class="text-sm text-gray-500 sm:w-24 flex-shrink-0">Waktu</span>
                        <span class="font-semibold text-gray-800">{{ $message->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-5 sm:p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Isi Pesan</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $message->message }}</p>
                </div>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <a href="mailto:{{ $message->email }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-all duration-150 active:scale-95 text-center">
                    <i class="fas fa-reply mr-2"></i>Balas via Email
                </a>
                <form method="POST" action="{{ route('messages.destroy', $message) }}" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-600 transition-all duration-150 active:scale-95">
                        <i class="fas fa-trash mr-2"></i>Hapus Pesan
                    </button>
                </form>
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

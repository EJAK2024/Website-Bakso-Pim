<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan - Bakso Pim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-green-800 text-white py-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold">
                    <a href="/" class="flex items-center drop-shadow-sm">
                        <img src="/images/logo.png" alt="Bakso Pim" class="inline-block h-12 w-12 object-cover rounded-full mr-2 shadow-md">
                        <span class="drop-shadow-sm">Bakso Pim</span>
                    </a>
                </div>
                <a href="/" class="font-medium text-green-100 hover:text-white transition-all duration-150 drop-shadow-sm active:scale-95">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </a>
            </div>
        </div>
    </nav>

    <section class="py-12">
        <div class="container mx-auto px-4 max-w-3xl">
            <h1 class="text-4xl font-bold text-center text-green-700 mb-2">Form Pemesanan</h1>
            <p class="text-gray-500 text-center mb-10">Isi data diri dan pilih menu favorit Anda</p>

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

            <form method="POST" action="{{ route('order.submit') }}" class="bg-white rounded-xl shadow-lg p-8">
                @csrf

                <div class="mb-6">
                    <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" placeholder="Masukkan nama Anda" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-6">
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">No. HP / Telepon</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Contoh: 0812-3456-7890" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Pengiriman</label>
                    <textarea name="address" id="address" rows="3" placeholder="Masukkan alamat lengkap" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('address') }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Menu</label>
                    <div class="flex gap-3 mb-4">
                        <button type="button" onclick="showFormCategory('makanan')" id="form-tab-makanan" class="px-6 py-2 rounded-lg font-semibold transition-all duration-150 bg-green-600 text-white shadow active:scale-95">Makanan</button>
                        <button type="button" onclick="showFormCategory('minuman')" id="form-tab-minuman" class="px-6 py-2 rounded-lg font-semibold transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95">Minuman</button>
                    </div>
                    <div id="form-menu-makanan" class="grid md:grid-cols-2 gap-3">
                        @forelse ($makanan as $item)
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                                <input type="checkbox" name="menu_ids[]" value="{{ $item->id }}" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3" onchange="toggleQty(this)">
                                <div class="flex-1">
                                    <span class="font-semibold text-gray-800">{{ $item->name }}</span>
                                    <span class="text-green-600 font-bold ml-2">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                <input type="number" name="quantities[]" min="1" value="1" class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm hidden qty-input focus:outline-none focus:ring-1 focus:ring-green-500">
                            </label>
                        @empty
                            <p class="text-gray-500 col-span-2">Belum ada menu makanan tersedia.</p>
                        @endforelse
                    </div>
                    <div id="form-menu-minuman" class="grid md:grid-cols-2 gap-3 hidden">
                        @forelse ($minuman as $item)
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                                <input type="checkbox" name="menu_ids[]" value="{{ $item->id }}" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3" onchange="toggleQty(this)">
                                <div class="flex-1">
                                    <span class="font-semibold text-gray-800">{{ $item->name }}</span>
                                    <span class="text-green-600 font-bold ml-2">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                <input type="number" name="quantities[]" min="1" value="1" class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm hidden qty-input focus:outline-none focus:ring-1 focus:ring-green-500">
                            </label>
                        @empty
                            <p class="text-gray-500 col-span-2">Belum ada menu minuman tersedia.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-8">
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Catatan (opsional)</label>
                    <textarea name="notes" id="notes" rows="2" placeholder="Contoh: tidak pakai micin, level pedas 3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Pesanan
                </button>
            </form>
        </div>
    </section>

    <footer class="bg-green-900 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2026 Bakso Pim. Semua hak dilindungi.</p>
        </div>
    </footer>
    <script>
        function showFormCategory(category) {
            const makanan = document.getElementById('form-menu-makanan');
            const minuman = document.getElementById('form-menu-minuman');
            const tabMakanan = document.getElementById('form-tab-makanan');
            const tabMinuman = document.getElementById('form-tab-minuman');

            if (category === 'makanan') {
                makanan.classList.remove('hidden');
                minuman.classList.add('hidden');
                tabMakanan.className = 'px-6 py-2 rounded-lg font-semibold transition-all duration-150 bg-green-600 text-white shadow active:scale-95';
                tabMinuman.className = 'px-6 py-2 rounded-lg font-semibold transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95';
            } else {
                minuman.classList.remove('hidden');
                makanan.classList.add('hidden');
                tabMinuman.className = 'px-6 py-2 rounded-lg font-semibold transition-all duration-150 bg-green-600 text-white shadow active:scale-95';
                tabMakanan.className = 'px-6 py-2 rounded-lg font-semibold transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95';
            }
        }

        function toggleQty(checkbox) {
            const qtyInput = checkbox.closest('label').querySelector('.qty-input');
            if (checkbox.checked) {
                qtyInput.classList.remove('hidden');
            } else {
                qtyInput.classList.add('hidden');
                qtyInput.value = 1;
            }
        }
    </script>
</body>
</html>

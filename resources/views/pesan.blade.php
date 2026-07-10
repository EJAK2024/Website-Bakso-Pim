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

            <form class="bg-white rounded-xl shadow-lg p-8">
                <div class="mb-6">
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="nama" placeholder="Masukkan nama Anda" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-6">
                    <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-1">No. HP / Telepon</label>
                    <input type="tel" id="no_hp" placeholder="Contoh: 0812-3456-7890" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-6">
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Pengiriman</label>
                    <textarea id="alamat" rows="3" placeholder="Masukkan alamat lengkap" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Menu</label>
                    <div class="flex gap-3 mb-4">
                        <button type="button" onclick="showFormCategory('makanan')" id="form-tab-makanan" class="px-6 py-2 rounded-lg font-semibold transition-all duration-150 bg-green-600 text-white shadow active:scale-95">Makanan</button>
                        <button type="button" onclick="showFormCategory('minuman')" id="form-tab-minuman" class="px-6 py-2 rounded-lg font-semibold transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95">Minuman</button>
                    </div>
                    <div id="form-menu-makanan" class="grid md:grid-cols-2 gap-3">
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                            <div>
                                <span class="font-semibold text-gray-800">Bakso Biasa</span>
                                <span class="text-green-600 font-bold ml-2">Rp 15,000</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                            <div>
                                <span class="font-semibold text-gray-800">Bakso Besar</span>
                                <span class="text-green-600 font-bold ml-2">Rp 25,000</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                            <div>
                                <span class="font-semibold text-gray-800">Bakso Spesial</span>
                                <span class="text-green-600 font-bold ml-2">Rp 35,000</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                            <div>
                                <span class="font-semibold text-gray-800">Paket Keluarga</span>
                                <span class="text-green-600 font-bold ml-2">Rp 100,000</span>
                            </div>
                        </label>
                    </div>
                    <div id="form-menu-minuman" class="grid md:grid-cols-2 gap-3 hidden">
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                            <div>
                                <span class="font-semibold text-gray-800">Es Teh Manis</span>
                                <span class="text-green-600 font-bold ml-2">Rp 5,000</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                            <div>
                                <span class="font-semibold text-gray-800">Es Jeruk</span>
                                <span class="text-green-600 font-bold ml-2">Rp 7,000</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                            <div>
                                <span class="font-semibold text-gray-800">Kopi Hitam</span>
                                <span class="text-green-600 font-bold ml-2">Rp 8,000</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                            <div>
                                <span class="font-semibold text-gray-800">Air Mineral</span>
                                <span class="text-green-600 font-bold ml-2">Rp 3,000</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="jumlah" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Porsi</label>
                    <input type="number" id="jumlah" min="1" value="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-8">
                    <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-1">Catatan (opsional)</label>
                    <textarea id="catatan" rows="2" placeholder="Contoh: tidak pakai micin, level pedas 3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"></textarea>
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
    </script>
</body>
</html>
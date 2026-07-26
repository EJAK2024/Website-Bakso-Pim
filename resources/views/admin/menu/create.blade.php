<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Bakso Pim</title>
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
                <a href="{{ route('menu.index') }}" class="font-medium text-green-100 hover:text-white transition-all duration-150 active:scale-95">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </a>
            </div>
        </div>
    </nav>

    <section class="flex-1 py-10">
        <div class="container mx-auto px-4 max-w-lg">
            <h1 class="text-3xl font-bold text-green-700 mb-2">Tambah Menu Baru</h1>
            <p class="text-gray-500 mb-8">Isi data menu yang ingin ditambahkan</p>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('menu.store') }}" class="bg-white rounded-xl shadow-lg p-8">
                @csrf

                <div class="mb-5">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Menu</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Bakso Urat" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-5">
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                    <select name="category" id="category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="makanan" {{ old('category') === 'makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="minuman" {{ old('category') === 'minuman' ? 'selected' : '' }}>Minuman</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi (opsional)</label>
                    <textarea name="description" id="description" rows="3" placeholder="Deskripsi singkat menu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('description') }}</textarea>
                </div>

                <div class="mb-5">
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="Contoh: 20000" min="0" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-5">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Gambar (opsional)</label>
                    <input type="text" name="image" id="image" value="{{ old('image') }}" placeholder="Path gambar" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', '1') ? 'checked' : '' }} class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                        <span class="text-sm font-semibold text-gray-700">Tersedia (Stok ada)</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    <i class="fas fa-save mr-2"></i>Simpan Menu
                </button>
            </form>
        </div>
    </section>

    <footer class="bg-green-900 text-white py-4">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>&copy; 2026 Bakso Pim. Panel administrasi.</p>
        </div>
    </footer>
</body>
</html>

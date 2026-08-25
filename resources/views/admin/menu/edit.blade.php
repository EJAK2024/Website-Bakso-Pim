@extends('layouts.admin')

@section('content')
    <section class="flex-1 py-10">
        <div class="container mx-auto px-4 max-w-lg">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('menu.index') }}" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-300 transition-all duration-150 active:scale-95">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </a>
                <h1 class="text-3xl font-bold text-green-700">Edit Menu</h1>
            </div>
            <p class="text-gray-500 mb-8">Perbarui data menu "{{ $menu->name }}"</p>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('menu.update', $menu) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-lg p-5 sm:p-8">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Menu</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-5">
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                    <select name="category" id="category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="makanan" {{ old('category', $menu->category) === 'makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="minuman" {{ old('category', $menu->category) === 'minuman' ? 'selected' : '' }}>Minuman</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi (opsional)</label>
                    <textarea name="description" id="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('description', $menu->description) }}</textarea>
                </div>

                <div class="mb-5">
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $menu->price) }}" min="0" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-5">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Gambar (opsional)</label>
                    @if($menu->image)
                        <div id="preview-edit" class="mb-3">
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-32 h-32 object-cover rounded-lg shadow">
                        </div>
                    @else
                        <div id="preview-edit" class="mb-3 hidden">
                            <img src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg shadow">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(this, 'preview-edit')" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 file:font-semibold hover:file:bg-green-100">
                </div>

                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $menu->is_available) ? 'checked' : '' }} class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3">
                        <span class="text-sm font-semibold text-gray-700">Tersedia (Stok ada)</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-blue-700 transition-all duration-150 active:scale-95 shadow-lg">
                    <i class="fas fa-save mr-2"></i>Perbarui Menu
                </button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
        }
    }
</script>
@endpush

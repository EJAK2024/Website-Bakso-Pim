@extends('layouts.public')

@section('content')
    <section class="flex-1 py-10">
        <div class="container mx-auto px-4 max-w-lg">
            <h1 class="text-3xl font-bold text-green-700 mb-2">Tambah Admin Baru</h1>
            <p class="text-gray-500 mb-8">Buat akun admin baru untuk mengelola website</p>

            @if (session('success'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/register" class="bg-white rounded-xl shadow-lg p-8">
                @csrf

                <div class="mb-5">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Nama admin" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-5">
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">No. HP (opsional)</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Contoh: 0812-3456-7890" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="admin@baksopim.com" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-5">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="admin" {{ old('status') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ old('status') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="staff" {{ old('status') === 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <p class="text-xs text-gray-400 mt-1">Harus mengandung huruf besar, huruf kecil, dan angka</p>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    &#128100; Tambah Admin
                </button>
            </form>
        </div>
    </section>
@endsection

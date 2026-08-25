@extends('layouts.public')

@section('title', 'Reset Password - Bakso Pim')

@section('content')
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <span class="text-2xl text-green-600">&#128274;</span>
                </div>
                <h1 class="text-3xl font-bold text-green-700">Reset Password</h1>
                <p class="text-gray-500 mt-1">Masukkan password baru Anda</p>
            </div>

            <form method="POST" action="/reset-password" class="bg-white rounded-xl shadow-lg p-8">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="absolute -left-[9999px]" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                @if ($errors->any())
                    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-600 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <p class="text-xs text-gray-400 mt-1">Harus mengandung huruf besar, huruf kecil, dan angka</p>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    &#128274; Reset Password
                </button>
            </form>
        </div>
    </section>
@endsection

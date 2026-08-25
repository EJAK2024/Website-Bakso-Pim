@extends('layouts.public')

@section('title', 'Lupa Password - Bakso Pim')

@section('content')
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-100 rounded-full mb-4">
                    <span class="text-2xl text-amber-600">&#128273;</span>
                </div>
                <h1 class="text-3xl font-bold text-green-700">Lupa Password</h1>
                <p class="text-gray-500 mt-1">Masukkan email Anda untuk reset password</p>
            </div>

            @if (session('status'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <p class="text-green-700 text-sm">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="/forgot-password" class="bg-white rounded-xl shadow-lg p-8">
                @csrf
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

                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan email akun Anda" required autofocus class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    &#128233; Kirim Link Reset
                </button>

                <div class="mt-4 text-center">
                    <a href="/login" class="text-sm text-green-600 hover:text-green-800 font-medium">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </section>
@endsection

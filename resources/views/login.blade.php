@extends('layouts.public')

@section('content')
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <span class="text-2xl text-green-600">&#128274;</span>
                </div>
                <h1 class="text-3xl font-bold text-green-700">Masuk Admin</h1>
                <p class="text-gray-500 mt-1">Silakan masuk untuk mengelola website</p>
            </div>

            <form method="POST" action="/login" class="bg-white rounded-xl shadow-lg p-8">
                @csrf

                @if ($errors->any())
                    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start">
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-red-600 text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="dummy_email" id="dummy_email" tabindex="-1" class="absolute -left-[9999px]" aria-hidden="true">
                    <input type="email" name="email" id="email" placeholder="Masukkan email admin" required autofocus autocomplete="off" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required autocomplete="new-password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat Saya</label>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    &#128274; Login Admin
                </button>

                <div class="mt-4 text-center">
                    <a href="/forgot-password" class="text-sm text-green-600 hover:text-green-800 font-medium">Lupa Password?</a>
                </div>
            </form>
        </div>
    </section>
@endsection

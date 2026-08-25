@extends('layouts.public')

@section('title', 'Verifikasi 2FA - Bakso Pim')

@section('content')
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <span class="text-2xl text-green-600">&#128274;</span>
                </div>
                <h1 class="text-3xl font-bold text-green-700">Two-Factor Auth</h1>
                <p class="text-gray-500 mt-1">Masukkan kode dari aplikasi authenticator</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/admin/2fa/verify" class="bg-white rounded-xl shadow-lg p-8">
                @csrf

                <div class="mb-6">
                    <label for="otp" class="block text-sm font-semibold text-gray-700 mb-1">Kode OTP</label>
                    <input type="text" name="otp" id="otp" placeholder="Masukkan 6 digit kode" required maxlength="6" pattern="[0-9]{6}" inputmode="numeric" autofocus class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-center text-lg tracking-widest">
                    <p class="text-xs text-gray-400 mt-2 text-center">Atau masukkan salah satu kode recovery Anda</p>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    &#10004; Verifikasi
                </button>
            </form>
        </div>
    </section>
@endsection

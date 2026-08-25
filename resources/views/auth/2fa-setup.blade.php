@extends('layouts.public')

@section('title', 'Setup 2FA - Bakso Pim')

@section('content')
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-lg">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <span class="text-2xl text-green-600">&#128274;</span>
                </div>
                <h1 class="text-3xl font-bold text-green-700">Setup Two-Factor Auth</h1>
                <p class="text-gray-500 mt-1">Aktifkan 2FA untuk keamanan ekstra</p>
            </div>

            @if (session('success'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2">1. Scan QR Code</h3>
                    <p class="text-sm text-gray-500 mb-4">Gunakan aplikasi authenticator (Google Authenticator, Authy, dll) untuk scan QR code di bawah.</p>
                    <div class="flex justify-center mb-4">
                        <div class="bg-gray-50 p-4 rounded-xl border-2 border-dashed border-gray-300">
                            <img
                                src="{{ $qrCodeSvg }}"
                                alt="QR Code 2FA"
                                class="w-48 h-48 object-contain"
                            >
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2">2. Atau masukkan manual</h3>
                    <p class="text-sm text-gray-500 mb-2">Masukkan kode ini di aplikasi authenticator:</p>
                    <div class="bg-gray-50 p-3 rounded-lg font-mono text-lg text-center tracking-widest text-green-700 font-bold break-all">
                        {{ $secret }}
                    </div>
                </div>

                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                    <h3 class="font-semibold text-amber-700 mb-2">&#9888; Simpan Kode Recovery</h3>
                    <p class="text-sm text-amber-600 mb-3">Simpan kode-kode ini di tempat yang aman. Kode ini bisa digunakan jika Anda kehilangan akses ke aplikasi authenticator:</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($recoveryCodes as $code)
                            <div class="bg-white px-3 py-2 rounded border font-mono text-sm text-center">{{ $code }}</div>
                        @endforeach
                    </div>
                </div>

                <form method="POST" action="/admin/2fa/enable">
                    @csrf
                    <div class="mb-6">
                        <label for="otp" class="block text-sm font-semibold text-gray-700 mb-1">3. Masukkan Kode OTP</label>
                        <input type="text" name="otp" id="otp" placeholder="Masukkan 6 digit kode dari aplikasi" required maxlength="6" pattern="[0-9]{6}" inputmode="numeric" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-center text-lg tracking-widest">
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                        &#10004; Aktifkan 2FA
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.public')

@section('title', 'Verifikasi Email - Bakso Pim')

@section('content')
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <span class="text-2xl text-blue-600">&#128231;</span>
                </div>
                <h1 class="text-3xl font-bold text-green-700">Verifikasi Email</h1>
                <p class="text-gray-500 mt-1">Silakan verifikasi email Anda terlebih dahulu</p>
            </div>

            @if (session('status'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <p class="text-green-700 text-sm">{{ session('status') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg p-8">
                <p class="text-gray-600 text-center mb-6">
                    Kami telah mengirim link verifikasi ke email Anda. Silakan klik link tersebut untuk melanjutkan.
                </p>

                <form method="POST" action="/email/verification-notification" class="mb-4">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                        &#128233; Kirim Ulang Link Verifikasi
                    </button>
                </form>

                <div class="text-center">
                    <a href="/login" class="text-sm text-green-600 hover:text-green-800 font-medium">Kembali ke Login</a>
                </div>
            </div>
        </div>
    </section>
@endsection

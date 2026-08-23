@extends('layouts.admin')

@section('content')
    <section class="flex-1 py-6 sm:py-10">
        <div class="container mx-auto px-4 max-w-2xl">
            <h1 class="text-2xl sm:text-3xl font-bold text-green-700 mb-2">Detail Pesan</h1>
            <p class="text-gray-500 mb-6 sm:mb-8">{{ $message->created_at->format('d M Y, H:i') }}</p>

            <div class="bg-white rounded-xl shadow-lg p-5 sm:p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Pengirim</h2>
                <div class="space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                        <span class="text-sm text-gray-500 sm:w-24 flex-shrink-0">Nama</span>
                        <span class="font-semibold text-gray-800">{{ $message->name }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                        <span class="text-sm text-gray-500 sm:w-24 flex-shrink-0">Email</span>
                        <span class="font-semibold text-gray-800">{{ $message->email }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                        <span class="text-sm text-gray-500 sm:w-24 flex-shrink-0">Waktu</span>
                        <span class="font-semibold text-gray-800">{{ $message->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-5 sm:p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Isi Pesan</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $message->message }}</p>
                </div>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <a href="mailto:{{ $message->email }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-all duration-150 active:scale-95 text-center">
                    <i class="fas fa-reply mr-2"></i>Balas via Email
                </a>
                <form method="POST" action="{{ route('messages.destroy', $message) }}" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-600 transition-all duration-150 active:scale-95">
                        <i class="fas fa-trash mr-2"></i>Hapus Pesan
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

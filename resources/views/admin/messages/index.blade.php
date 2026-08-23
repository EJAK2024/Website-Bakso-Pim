@extends('layouts.admin')

@section('content')
    <section class="flex-1 py-6 sm:py-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-green-700">Pesan Masuk</h1>
                    <p class="text-gray-500 text-sm sm:text-base">Pesan dari pengunjung website</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($unreadCount > 0)
                        <span class="bg-red-500 text-white text-xs sm:text-sm font-bold px-3 py-1 rounded-full animate-pulse">
                            {{ $unreadCount }} baru
                        </span>
                        <a href="{{ route('messages.readAll') }}" class="bg-gray-500 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm hover:bg-gray-600 transition-all duration-150 active:scale-95">
                            <i class="fas fa-check-double mr-1"></i>Tandai Sudah Dibaca
                        </a>
                    @endif
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="space-y-4">
                @forelse ($messages as $msg)
                    <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 {{ !$msg->is_read ? 'border-l-4 border-red-500 bg-red-50/30' : '' }}">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-base sm:text-lg font-bold text-gray-800 truncate">{{ $msg->name }}</h3>
                                    @if(!$msg->is_read)
                                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full flex-shrink-0">BARU</span>
                                    @endif
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope mr-2 text-green-600"></i>{{ $msg->email }}
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-clock mr-2 text-green-600"></i>{{ $msg->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ Str::limit($msg->message, 120) }}</p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <a href="{{ route('messages.show', $msg) }}" class="bg-green-600 text-white px-3 sm:px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition-all duration-150 active:scale-95">
                                    <i class="fas fa-eye mr-1"></i>Lihat
                                </a>
                                <form method="POST" action="{{ route('messages.destroy', $msg) }}" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-600 transition-all duration-150 active:scale-95">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <i class="fas fa-envelope-open-text text-5xl text-gray-300 mb-4 block"></i>
                        <p class="text-gray-500 text-lg">Belum ada pesan masuk</p>
                        <p class="text-gray-400 text-sm mt-1">Pesan dari pengunjung akan muncul di sini</p>
                    </div>
                @endforelse
            </div>

            @if($messages->hasPages())
                <div class="mt-6">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

@extends('layouts.public')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-green-600 to-green-800 text-white">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative container mx-auto px-4 py-12 sm:py-16 md:py-20">
            <div class="max-w-2xl">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Selamat Datang di Bakso Pim</h1>
                <p class="text-base sm:text-lg md:text-xl mb-6 sm:mb-8">Nikmati bakso berkualitas terbaik dengan resep tradisional yang telah terpercaya sejak tahun 1983</p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <a href="#BaksoPim" onclick="smoothScroll(event, 'BaksoPim')" class="bg-white text-green-600 px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-green-50 transition-all duration-150 text-center active:scale-95">
                        Lihat Menu
                    </a>
                    <a href="/pesan" class="border-2 border-white text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-all duration-150 text-center active:scale-95">
                        Pesan Sekarang
                    </a>
                </div>
                <div class="flex gap-6 sm:gap-10 mt-8 sm:mt-12">
                    <div class="text-center">
                        <p class="text-2xl sm:text-3xl font-extrabold counter" data-target="42">0</p>
                        <p class="text-green-200 text-xs sm:text-sm">Menu Tersedia</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl sm:text-3xl font-extrabold counter" data-target="43">0</p>
                        <p class="text-green-200 text-xs sm:text-sm">Tahun Pengalaman</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl sm:text-3xl font-extrabold counter" data-target="5000">0</p>
                        <p class="text-green-200 text-xs sm:text-sm">Pelanggan Puas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="relative py-10 sm:py-14 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/backgroundvideo.png.jpg')"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/70 via-green-800/50 to-green-900/70"></div>
        <div class="absolute inset-0 backdrop-blur-sm"></div>
        <div class="relative container mx-auto px-4 max-w-4xl">
            <div class="relative rounded-xl overflow-hidden shadow-2xl ring-2 ring-white/20 ring-offset-2 ring-offset-transparent">
                <video id="aboutVideo" autoplay muted loop playsinline class="w-full">
                    <source src="/images/about-video.mp4" type="video/mp4">
                </video>
                <button onclick="toggleSound()" id="soundBtn" class="absolute bottom-4 right-4 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition-all duration-150 active:scale-90 backdrop-blur-md">
                    <span id="soundIcon">&#128263;</span>
                </button>
            </div>
        </div>
    </section>

    <div class="h-2 bg-gradient-to-r from-green-800 via-green-500 to-green-800"></div>

    <!-- Menu Section -->
    <section id="BaksoPim" class="py-12 sm:py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-center text-green-600 fade-in">Katalog Menu</h2>
            <!-- Tab Buttons -->
            <div class="flex justify-center gap-3 sm:gap-4 mb-8 sm:mb-10 fade-in">
                <button onclick="showCategory('makanan')" id="tab-makanan" class="px-5 sm:px-8 py-2 sm:py-3 rounded-lg font-semibold text-sm sm:text-lg transition-all duration-150 bg-green-600 text-white shadow-lg active:scale-95">
                    &#127869; Makanan
                </button>
                <button onclick="showCategory('minuman')" id="tab-minuman" class="px-5 sm:px-8 py-2 sm:py-3 rounded-lg font-semibold text-sm sm:text-lg transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95">
                    &#127861; Minuman
                </button>
            </div>

            <!-- Makanan -->
            <div id="menu-makanan" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
                @forelse ($makanan as $item)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden menu-card fade-in">
                        <div class="h-40 sm:h-48 bg-green-100 flex items-center justify-center overflow-hidden">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <span class="text-4xl sm:text-5xl">&#127869;</span>
                            @endif
                        </div>
                        <div class="p-4 sm:p-6">
                            <h3 class="text-lg sm:text-xl font-bold mb-2">{{ $item->name }}</h3>
                            <p class="text-gray-600 mb-4 text-sm sm:text-base">{{ $item->description ?? 'Menu spesial dari Bakso Pim' }}</p>
                            <div class="text-xl sm:text-2xl font-bold text-green-600">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-1 sm:col-span-2 lg:col-span-4 text-center py-8">Belum ada menu makanan tersedia.</p>
                @endforelse
            </div>

            <!-- Minuman -->
            <div id="menu-minuman" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8 hidden">
                @forelse ($minuman as $item)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden menu-card fade-in">
                        <div class="h-40 sm:h-48 bg-amber-100 flex items-center justify-center overflow-hidden">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <span class="text-4xl sm:text-5xl">&#9749;</span>
                            @endif
                        </div>
                        <div class="p-4 sm:p-6">
                            <h3 class="text-lg sm:text-xl font-bold mb-2">{{ $item->name }}</h3>
                            <p class="text-gray-600 mb-4 text-sm sm:text-base">{{ $item->description ?? 'Minuman segar dari Bakso Pim' }}</p>
                            <div class="text-xl sm:text-2xl font-bold text-green-600">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-1 sm:col-span-2 lg:col-span-4 text-center py-8">Belum ada menu minuman tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <div class="h-2 bg-gradient-to-r from-green-800 via-green-500 to-green-800"></div>

    <!-- Contact Section -->
    <section id="contact" class="py-12 sm:py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold mb-8 sm:mb-12 text-center text-green-600 fade-in">Hubungi Kami</h2>

            @if (session('success'))
                <div class="max-w-4xl mx-auto mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="max-w-4xl mx-auto mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-8 sm:gap-12 max-w-4xl mx-auto">
                <div class="md:w-1/2">
                    <h3 class="text-lg sm:text-xl font-bold mb-4">Informasi Kontak</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <span class="text-green-600 mt-1 mr-3">&#128205;</span>
                            <div>
                                <p>Jl. Bakso Jaya No. 456</p>
                                <p>Kota Ini, Indonesia 12345</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-600 mr-3">&#128222;</span>
                            <p>+62 123 4567 890</p>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-600 mr-3">&#9993;</span>
                            <p>info@warungbakso.com</p>
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-600 mr-3">&#128336;</span>
                            <div>
                                <p>Senin - Minggu: 10:00 - 23:00 WIB</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Ikuti Kami</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-green-600 hover:text-green-800 transition-all duration-150 active:scale-95 inline-block">&#128247; Instagram</a>
                            <a href="#" class="text-green-600 hover:text-green-800 transition-all duration-150 active:scale-95 inline-block">&#128172; WhatsApp</a>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <form method="POST" action="{{ route('kontak.submit') }}" class="bg-white p-5 sm:p-6 rounded-lg shadow-md">
                        @csrf
                        <h3 class="text-xl font-bold mb-4">Kirim Pesan</h3>
                        <div class="absolute -left-[9999px]" aria-hidden="true">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama Anda" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea name="message" id="message" rows="4" placeholder="Tulis pesan Anda" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-all duration-150 active:scale-95">
                            &#128640; Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Kritik & Saran Section -->
    <section id="kritik-saran" class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center text-green-600 fade-in">Kritik & Saran</h2>
            <p class="text-gray-600 text-center mb-8 text-sm sm:text-base fade-in">Kami sangat menghargai masukan Anda untuk perbaikan layanan kami.</p>
            <div class="max-w-3xl mx-auto text-center">
                <div class="bg-gray-50 rounded-xl shadow-lg border border-gray-200 p-8">
                    <div class="mb-6">
                        <svg class="mx-auto h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Formulir Kritik & Saran</h3>
                    <p class="text-gray-600 mb-6 text-sm sm:text-base">Klik tombol di bawah untuk mengisi form kritik dan saran secara langsung di Google Forms.</p>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSdhPgtgb23ETav6DX2H9CXmvMVWFCc_hka-gOcbc2zjTzyufg/viewform?usp=header"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Buka Form Kritik & Saran
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-12 sm:py-16" style="background-color: #f0f5f0;">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-green-600 fade-in">Tentang Bakso Pim</h2>
                <p class="text-gray-600 mb-8 text-sm sm:text-base leading-relaxed fade-in">Didirikan pada tahun 1983, Bakso Pim telah menjadi tujuan utama bagi para pecinta bakso di kota ini. Dengan lebih dari 30 tahun pengalaman, kami menggunakan resep tradisional yang dijaga keasliannya, sementara menggunakan bahan-bahan pilihan berkualitas.</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl mx-auto">
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow fade-in">
                        <span class="text-green-500 text-2xl mb-2">&#10004;</span>
                        <span class="text-sm font-medium text-gray-700">Bahan Berkualitas</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow fade-in">
                        <span class="text-green-500 text-2xl mb-2">&#10004;</span>
                        <span class="text-sm font-medium text-gray-700">Resep Asli</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow fade-in">
                        <span class="text-green-500 text-2xl mb-2">&#10004;</span>
                        <span class="text-sm font-medium text-gray-700">Layanan Ramah</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow fade-in">
                        <span class="text-green-500 text-2xl mb-2">&#10004;</span>
                        <span class="text-sm font-medium text-gray-700">Harga PAS</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-green-900 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-2xl font-bold"><img src="/images/logo.png" alt="Bakso Pim" class="inline-block h-8 w-8 object-cover rounded-full mr-2"> Bakso Pim</h3>
                    <p class="text-green-200">Nikmati bakso berkualitas sejak tahun 1990</p>
                </div>
                <div class="text-center md:text-right">
                    <p>&copy; 2026 <img src="/images/logo.png" alt="Bakso Pim" class="inline-block h-6 w-6 object-cover rounded-full mr-1"> Bakso Pim. Semua hak dilindungi.</p>
                    <p class="text-green-200">Dibuat dengan cinta untuk pecinta bakso</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <div class="bg-white rounded-xl shadow-2xl border border-gray-100 p-4 flex items-center min-w-[300px]">
            <div id="toast-icon" class="w-10 h-10 rounded-full flex items-center justify-center mr-3 flex-shrink-0"></div>
            <div>
                <p id="toast-title" class="font-bold text-gray-800 text-sm"></p>
                <p id="toast-message" class="text-gray-500 text-xs"></p>
            </div>
            <button onclick="hideToast()" class="ml-4 text-gray-400 hover:text-gray-600">&#10005;</button>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="text-center">
            <div class="spinner mx-auto mb-3"></div>
            <p class="text-green-700 font-semibold">Memproses...</p>
        </div>
    </div>

    <!-- Back to Top -->
    <button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" class="fixed bottom-6 right-6 w-12 h-12 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 transition-all duration-300 active:scale-90 z-50 flex items-center justify-center">
        &#9650;
    </button>
@endsection

@push('styles')
<style>
    .fade-in { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .fade-in.visible { opacity: 1; transform: translateY(0); }
    .slide-left { opacity: 0; transform: translateX(-40px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .slide-left.visible { opacity: 1; transform: translateX(0); }
    .slide-right { opacity: 0; transform: translateX(40px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .slide-right.visible { opacity: 1; transform: translateX(0); }
    .toast { position: fixed; top: 20px; right: 20px; z-index: 9999; transform: translateX(120%); transition: transform 0.4s cubic-bezier(0.68,-0.55,0.27,1.55); }
    .toast.show { transform: translateX(0); }
    #backToTop { opacity: 0; transform: translateY(20px); transition: opacity 0.3s, transform 0.3s; }
    #backToTop.visible { opacity: 1; transform: translateY(0); }
    .menu-card { transition: all 0.3s ease; }
    .menu-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .loading-overlay { position: fixed; inset: 0; background: rgba(255,255,255,0.8); z-index: 9998; display: none; backdrop-filter: blur(4px); }
    .loading-overlay.active { display: flex; align-items: center; justify-content: center; }
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner { width: 48px; height: 48px; border: 4px solid #e5e7eb; border-top-color: #16a34a; border-radius: 50%; animation: spin 0.8s linear infinite; }
    @keyframes countUp { from { opacity: 0; transform: scale(0.5); } to { opacity: 1; transform: scale(1); } }
    .counter-num { animation: countUp 0.5s ease forwards; }
</style>
@endpush

@push('scripts')
<script>
    function smoothScroll(e, id) {
        e.preventDefault();
        if (id === 'top') {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        const el = document.getElementById(id);
        if (el) {
            const nav = document.querySelector('nav');
            const offset = nav ? nav.offsetHeight + 10 : 0;
            const top = el.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top, behavior: 'smooth' });
        }
    }

    function showCategory(category) {
        const makanan = document.getElementById('menu-makanan');
        const minuman = document.getElementById('menu-minuman');
        const tabMakanan = document.getElementById('tab-makanan');
        const tabMinuman = document.getElementById('tab-minuman');

        if (category === 'makanan') {
            makanan.classList.remove('hidden');
            minuman.classList.add('hidden');
            tabMakanan.className = 'px-5 sm:px-8 py-2 sm:py-3 rounded-lg font-semibold text-sm sm:text-lg transition-all duration-150 bg-green-600 text-white shadow-lg active:scale-95';
            tabMinuman.className = 'px-5 sm:px-8 py-2 sm:py-3 rounded-lg font-semibold text-sm sm:text-lg transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95';
        } else {
            minuman.classList.remove('hidden');
            makanan.classList.add('hidden');
            tabMinuman.className = 'px-5 sm:px-8 py-2 sm:py-3 rounded-lg font-semibold text-sm sm:text-lg transition-all duration-150 bg-green-600 text-white shadow-lg active:scale-95';
            tabMakanan.className = 'px-5 sm:px-8 py-2 sm:py-3 rounded-lg font-semibold text-sm sm:text-lg transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95';
        }
    }

    function toggleSound() {
        const video = document.getElementById('aboutVideo');
        const icon = document.getElementById('soundIcon');
        if (video.muted) {
            video.muted = false;
            icon.innerHTML = '&#128266;';
        } else {
            video.muted = true;
            icon.innerHTML = '&#128263;';
        }
    }

    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('toast');
        const icon = document.getElementById('toast-icon');
        const titleEl = document.getElementById('toast-title');
        const msgEl = document.getElementById('toast-message');

        titleEl.textContent = title;
        msgEl.textContent = message;

        if (type === 'success') {
            icon.className = 'w-10 h-10 rounded-full flex items-center justify-center mr-3 flex-shrink-0 bg-green-100';
            icon.innerHTML = '&#10004;';
        } else if (type === 'error') {
            icon.className = 'w-10 h-10 rounded-full flex items-center justify-center mr-3 flex-shrink-0 bg-red-100';
            icon.innerHTML = '&#10005;';
        } else {
            icon.className = 'w-10 h-10 rounded-full flex items-center justify-center mr-3 flex-shrink-0 bg-blue-100';
            icon.innerHTML = '&#8505;';
        }

        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 4000);
    }

    function hideToast() {
        document.getElementById('toast').classList.remove('show');
    }

    function showLoading() {
        document.getElementById('loadingOverlay').classList.add('active');
    }

    // Intersection Observer for fade-in
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, index * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in, .slide-left, .slide-right').forEach(el => observer.observe(el));

    // Back to top
    window.addEventListener('scroll', () => {
        const btn = document.getElementById('backToTop');
        if (window.scrollY > 400) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    });

    // Animated Counter
    function animateCounters() {
        document.querySelectorAll('.counter').forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const update = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.floor(current).toLocaleString('id-ID');
                    requestAnimationFrame(update);
                } else {
                    counter.textContent = target.toLocaleString('id-ID') + '+';
                }
            };
            update();
        });
    }

    const heroObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                heroObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    const heroSection = document.querySelector('.counter');
    if (heroSection) heroObserver.observe(heroSection.closest('section'));

    @if(session('success'))
        showToast('Berhasil!', @json(session('success')), 'success');
    @endif
</script>
@endpush

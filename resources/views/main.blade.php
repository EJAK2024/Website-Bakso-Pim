<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakso Pim - Rumah Makan Bakso Terpercaya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-white" style="scroll-behavior: smooth;">
    <!-- Navigation -->
    <nav class="bg-white py-4 sticky top-0 z-50 shadow-lg border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold">
                    <a href="/" class="flex items-center focus:outline-none focus:ring-0 focus:bg-transparent">
                        <img src="/images/logo.png" alt="Bakso Pim" class="inline-block h-12 w-12 object-cover rounded-full mr-2 shadow-md">
                        <span class="text-green-800" style="-webkit-text-stroke: 0.5px #166534; paint-order: stroke fill;">Bakso Pim</span>
                    </a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#" onclick="smoothScroll(event, 'top')" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">Beranda</a>
                    <a href="#BaksoPim" onclick="smoothScroll(event, 'BaksoPim')" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">Menu</a>
                    <a href="#about" onclick="smoothScroll(event, 'about')" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">Tentang Kami</a>
                    <a href="#contact" onclick="smoothScroll(event, 'contact')" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">Kontak</a>
                    <a href="/login" class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition-all duration-150 font-semibold shadow-md active:scale-95">
                        <i class="fas fa-lock mr-1"></i>Masuk
                    </a>
                </div>
                <button class="md:hidden text-gray-700 active:scale-95 transition-transform duration-150">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-green-600 to-green-800 text-white">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative container mx-auto px-4 py-20">
            <div class="max-w-2xl">
                <h1 class="text-5xl md:text-6xl font-bold mb-4">Selamat Datang di Bakso Pim</h1>
                <p class="text-xl mb-8">Nikmati bakso berkualitas terbaik dengan resep tradisional yang telah terpercaya sejak tahun 1998</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#BaksoPim" onclick="smoothScroll(event, 'BaksoPim')" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-green-50 transition-all duration-150 text-center active:scale-95">
                        Lihat Menu
                    </a>
                    <a href="/pesan" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-all duration-150 text-center active:scale-95">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <div class="relative">
                    <video id="aboutVideo" autoplay muted loop playsinline class="rounded-lg shadow-2xl w-full">
                        <source src="/images/about-video.mp4" type="video/mp4">
                    </video>
                    <button onclick="toggleSound()" id="soundBtn" class="absolute bottom-3 right-3 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition-all duration-150 active:scale-90">
                        <i id="soundIcon" class="fas fa-volume-mute"></i>
                    </button>
                </div>
                </div>
                <div class="md:w-1/2 md:pl-12">
                    <h2 class="text-3xl font-bold mb-4 text-green-600">Tentang Bakso Pim</h2>
                    <p class="text-gray-600 mb-6">Didirikan pada tahun 1998, Bakso Pim telah menjadi tujuan utama bagi para pecinta bakso di kota ini. Dengan lebih dari 30 tahun lebih pengalaman, kami menggunakan resep tradisional yang dijaga keasliannya, sementara menggunakan bahan-bahan pilihan berkualitas.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Bahan Berkualitas</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Resep Asli</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Layanan Ramah</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Harga PAS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>-

    <div class="h-2 bg-gradient-to-r from-green-800 via-green-500 to-green-800"></div>

    <!-- Menu Section -->
    <section id="BaksoPim" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center text-green-600">Katalog Menu</h2>
            <!-- Tab Buttons -->
            <div class="flex justify-center gap-4 mb-10">
                <button onclick="showCategory('makanan')" id="tab-makanan" class="px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-150 bg-green-600 text-white shadow-lg active:scale-95">
                    <i class="fas fa-utensils mr-2"></i>Makanan
                </button>
                <button onclick="showCategory('minuman')" id="tab-minuman" class="px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95">
                    <i class="fas fa-glass-martini-alt mr-2"></i>Minuman
                </button>
            </div>

            <!-- Makanan -->
            <div id="menu-makanan" class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($makanan as $item)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-150 active:scale-[1.02] cursor-pointer">
                        <div class="h-48 bg-green-100 flex items-center justify-center">
                            <i class="fas fa-utensils text-5xl text-green-600"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $item->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $item->description ?? 'Menu spesial dari Bakso Pim' }}</p>
                            <div class="text-2xl font-bold text-green-600">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-4 text-center py-8">Belum ada menu makanan tersedia.</p>
                @endforelse
            </div>

            <!-- Minuman -->
            <div id="menu-minuman" class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 hidden">
                @forelse ($minuman as $item)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-150 active:scale-[1.02] cursor-pointer">
                        <div class="h-48 bg-amber-100 flex items-center justify-center">
                            <i class="fas fa-mug-hot text-5xl text-amber-600"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $item->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $item->description ?? 'Minuman segar dari Bakso Pim' }}</p>
                            <div class="text-2xl font-bold text-green-600">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-4 text-center py-8">Belum ada menu minuman tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        function toggleSound() {
            const video = document.getElementById('aboutVideo');
            const icon = document.getElementById('soundIcon');
            if (video.muted) {
                video.muted = false;
                icon.className = 'fas fa-volume-up';
            } else {
                video.muted = true;
                icon.className = 'fas fa-volume-mute';
            }
        }

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
                tabMakanan.className = 'px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-150 bg-green-600 text-white shadow-lg active:scale-95';
                tabMinuman.className = 'px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95';
            } else {
                minuman.classList.remove('hidden');
                makanan.classList.add('hidden');
                tabMinuman.className = 'px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-150 bg-green-600 text-white shadow-lg active:scale-95';
                tabMakanan.className = 'px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95';
            }
        }
    </script>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center text-green-600">Hubungi Kami</h2>
            <div class="flex flex-col md:flex-row gap-12 max-w-4xl mx-auto">
                <div class="md:w-1/2">
                    <h3 class="text-xl font-bold mb-4">Informasi Kontak</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-green-600 mt-1 mr-3"></i>
                            <div>
                            <p>Jl. Bakso Jaya No. 456</p>
                            <p>Kota Ini, Indonesia 12345</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-green-600 mr-3"></i>
                            <p>+62 123 4567 890</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-green-600 mr-3"></i>
                            <p>info@warungbakso.com</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-green-600 mr-3"></i>
                            <div>
                                <p>Senin - Minggu: 10:00 - 22:00</p>
                                <p>24 Jam Service</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Ikuti Kami</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-green-600 hover:text-green-800 transition-all duration-150 active:scale-95 inline-block"><i class="fab fa-instagram fa-2x"></i></a>
                            <a href="#" class="text-green-600 hover:text-green-800 transition-all duration-150 active:scale-95 inline-block"><i class="fab fa-facebook fa-2x"></i></a>
                            <a href="#" class="text-green-600 hover:text-green-800 transition-all duration-150 active:scale-95 inline-block"><i class="fab fa-twitter fa-2x"></i></a>
                            <a href="#" class="text-green-600 hover:text-green-800 transition-all duration-150 active:scale-95 inline-block"><i class="fab fa-whatsapp fa-2x"></i></a>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <form class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold mb-4">Kirim Pesan</h3>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea id="message" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-all duration-150 active:scale-95">Kirim Pesan</button>
                    </form>
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
</body>
</html>

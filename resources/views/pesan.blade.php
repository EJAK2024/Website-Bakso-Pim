@extends('layouts.public')

@section('content')
    <section class="py-8 sm:py-12">
        <div class="container mx-auto px-4 max-w-3xl">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center text-green-700 mb-2">Form Pemesanan</h1>
            <p class="text-gray-500 text-center mb-8 sm:mb-10 text-sm sm:text-base">Isi data diri dan pilih menu favorit Anda</p>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(!\App\Models\Order::isOperationalHours())
                <div class="mb-6 p-6 bg-red-50 border-2 border-red-200 rounded-xl text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                        <span class="text-red-500 text-3xl">&#128336;</span>
                    </div>
                    <h3 class="text-xl font-bold text-red-700 mb-2">Toko Sedang Tutup</h3>
                    <p class="text-red-600 mb-1">Jam operasional Bakso Pim:</p>
                    <p class="text-lg font-bold text-red-700">10:00 - 23:00 WIB</p>
                    <p class="text-red-500 text-sm mt-3">Silakan kembali pada jam operasional untuk melakukan pemesanan.</p>
                    <a href="/" class="inline-block mt-4 bg-red-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-700 transition-all duration-150 active:scale-95">
                        &#127968; Kembali ke Beranda
                    </a>
                </div>
            @endif

            <form method="POST" action="{{ route('order.submit') }}" class="bg-white rounded-xl shadow-lg p-5 sm:p-8 {{ !\App\Models\Order::isOperationalHours() ? 'opacity-50 pointer-events-none' : '' }}">
                @csrf
                <div class="absolute -left-[9999px]" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="mb-6">
                    <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" placeholder="Masukkan nama Anda" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-6">
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">No. HP / Telepon</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" inputmode="numeric" pattern="[0-9]*" onkeypress="return /\d/.test(String.fromCharCode(event.keyCode || event.which))" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Pengiriman</label>
                    <textarea name="address" id="address" rows="3" placeholder="Masukkan alamat lengkap" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('address') }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Menu</label>
                    <div class="flex gap-2 sm:gap-3 mb-4">
                        <button type="button" onclick="showFormCategory('makanan')" id="form-tab-makanan" class="px-4 sm:px-6 py-2 rounded-lg font-semibold text-sm sm:text-base transition-all duration-150 bg-green-600 text-white shadow active:scale-95">Makanan</button>
                        <button type="button" onclick="showFormCategory('minuman')" id="form-tab-minuman" class="px-4 sm:px-6 py-2 rounded-lg font-semibold text-sm sm:text-base transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95">Minuman</button>
                    </div>
                    <div id="form-menu-makanan" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @forelse ($makanan as $item)
                            <label class="flex items-center p-3 sm:p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                                <input type="checkbox" name="menu_ids[]" value="{{ $item->id }}" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3 flex-shrink-0" onchange="toggleQty(this)">
                                <div class="flex-1 min-w-0">
                                    <span class="font-semibold text-gray-800 text-sm sm:text-base">{{ $item->name }}</span>
                                    <span class="menu-price text-green-600 font-bold text-sm sm:text-base block sm:inline sm:ml-2" data-price="{{ $item->price }}">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                <input type="number" name="quantities[]" min="1" value="1" class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm hidden qty-input focus:outline-none focus:ring-1 focus:ring-green-500">
                            </label>
                        @empty
                            <p class="text-gray-500 col-span-2">Belum ada menu makanan tersedia.</p>
                        @endforelse
                    </div>
                    <div id="form-menu-minuman" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                        @forelse ($minuman as $item)
                            <label class="flex items-center p-3 sm:p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-150 active:scale-[1.02]">
                                <input type="checkbox" name="menu_ids[]" value="{{ $item->id }}" class="w-5 h-5 text-green-600 rounded border-gray-300 mr-3 flex-shrink-0" onchange="toggleQty(this)">
                                <div class="flex-1 min-w-0">
                                    <span class="font-semibold text-gray-800 text-sm sm:text-base">{{ $item->name }}</span>
                                    <span class="menu-price text-green-600 font-bold text-sm sm:text-base block sm:inline sm:ml-2" data-price="{{ $item->price }}">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                <input type="number" name="quantities[]" min="1" value="1" class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm hidden qty-input focus:outline-none focus:ring-1 focus:ring-green-500">
                            </label>
                        @empty
                            <p class="text-gray-500 col-span-2">Belum ada menu minuman tersedia.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-8">
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Catatan (opsional)</label>
                    <textarea name="notes" id="notes" rows="2" placeholder="Contoh: tidak pakai micin, level pedas 3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('notes') }}</textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Metode Pembayaran</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all duration-150 {{ old('payment_method') == 'qris' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
                            <input type="radio" name="payment_method" value="qris" class="w-5 h-5 text-green-600 mr-3" {{ old('payment_method') == 'qris' ? 'checked' : '' }} required>
                            <div class="flex items-center">
                                <span class="text-green-600 text-2xl mr-3">&#9641;</span>
                                <div>
                                    <span class="font-semibold text-gray-800 block">QRIS</span>
                                    <span class="text-gray-500 text-xs">Bayar via QR Code</span>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all duration-150 {{ old('payment_method') == 'kasir' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
                            <input type="radio" name="payment_method" value="kasir" class="w-5 h-5 text-green-600 mr-3" {{ old('payment_method') == 'kasir' ? 'checked' : '' }} required>
                            <div class="flex items-center">
                                <span class="text-green-600 text-2xl mr-3">&#127978;</span>
                                <div>
                                    <span class="font-semibold text-gray-800 block">Bayar di Kasir</span>
                                    <span class="text-gray-500 text-xs">Tunjukkan struk ke kasir</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="totalPreview" class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg hidden">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-semibold">Total Pembayaran:</span>
                        <span id="totalAmount" class="text-2xl font-bold text-green-700">Rp 0</span>
                    </div>
                </div>

                <button type="submit" onclick="return confirmOrder()" class="w-full bg-green-600 text-white py-4 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    &#128640; Buat Pesanan
                </button>
            </form>
        </div>
    </section>

    <!-- Confirm Modal -->
    <div id="confirmModal" class="modal-overlay">
        <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm mx-4 text-center transform transition-all">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-green-600 text-2xl">&#128722;</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Pesanan</h3>
            <p class="text-gray-500 text-sm mb-6">Apakah kamu yakin ingin membuat pesanan ini?</p>
            <div class="flex gap-3">
                <button onclick="closeConfirm()" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-all active:scale-95">Batal</button>
                <button onclick="submitOrder()" class="flex-1 bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-all active:scale-95">Ya, Pesan</button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="text-center">
            <div class="spinner mx-auto mb-3"></div>
            <p class="text-green-700 font-semibold">Memproses pesanan...</p>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast" class="toast">
        <div class="bg-white rounded-xl shadow-2xl border border-gray-100 p-4 flex items-center min-w-[300px]">
            <div id="toast-icon" class="w-10 h-10 rounded-full flex items-center justify-center mr-3 flex-shrink-0"></div>
            <div>
                <p id="toast-title" class="font-bold text-gray-800 text-sm"></p>
                <p id="toast-message" class="text-gray-500 text-xs"></p>
            </div>
            <button onclick="document.getElementById('toast').classList.remove('show')" class="ml-4 text-gray-400 hover:text-gray-600">&#10005;</button>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .loading-overlay { position: fixed; inset: 0; background: rgba(255,255,255,0.8); z-index: 9998; display: none; backdrop-filter: blur(4px); }
    .loading-overlay.active { display: flex; align-items: center; justify-content: center; }
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner { width: 48px; height: 48px; border: 4px solid #e5e7eb; border-top-color: #16a34a; border-radius: 50%; animation: spin 0.8s linear infinite; }
    .toast { position: fixed; top: 20px; right: 20px; z-index: 9999; transform: translateX(120%); transition: transform 0.4s cubic-bezier(0.68,-0.55,0.27,1.55); }
    .toast.show { transform: translateX(0); }
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; display: none; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .modal-overlay.active { display: flex; }
</style>
@endpush

@push('scripts')
<script>
    function showFormCategory(category) {
        const makanan = document.getElementById('form-menu-makanan');
        const minuman = document.getElementById('form-menu-minuman');
        const tabMakanan = document.getElementById('form-tab-makanan');
        const tabMinuman = document.getElementById('form-tab-minuman');

        if (category === 'makanan') {
            makanan.classList.remove('hidden');
            minuman.classList.add('hidden');
            tabMakanan.className = 'px-4 sm:px-6 py-2 rounded-lg font-semibold text-sm sm:text-base transition-all duration-150 bg-green-600 text-white shadow active:scale-95';
            tabMinuman.className = 'px-4 sm:px-6 py-2 rounded-lg font-semibold text-sm sm:text-base transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95';
        } else {
            minuman.classList.remove('hidden');
            makanan.classList.add('hidden');
            tabMinuman.className = 'px-4 sm:px-6 py-2 rounded-lg font-semibold text-sm sm:text-base transition-all duration-150 bg-green-600 text-white shadow active:scale-95';
            tabMakanan.className = 'px-4 sm:px-6 py-2 rounded-lg font-semibold text-sm sm:text-base transition-all duration-150 bg-gray-200 text-gray-700 hover:bg-gray-300 active:scale-95';
        }
    }

    function toggleQty(checkbox) {
        const qtyInput = checkbox.closest('label').querySelector('.qty-input');
        if (checkbox.checked) {
            qtyInput.classList.remove('hidden');
        } else {
            qtyInput.classList.add('hidden');
            qtyInput.value = 1;
        }
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        const checkedMenus = document.querySelectorAll('input[name="menu_ids[]"]:checked');
        const preview = document.getElementById('totalPreview');
        const totalAmount = document.getElementById('totalAmount');

        checkedMenus.forEach(checkbox => {
            const label = checkbox.closest('label');
            const priceText = label.querySelector('.menu-price');
            const qtyInput = label.querySelector('.qty-input');
            if (priceText && qtyInput) {
                const price = parseInt(priceText.dataset.price) || 0;
                const qty = parseInt(qtyInput.value) || 1;
                total += price * qty;
            }
        });

        if (checkedMenus.length > 0) {
            preview.classList.remove('hidden');
            totalAmount.textContent = 'Rp ' + total.toLocaleString('id-ID');
        } else {
            preview.classList.add('hidden');
        }
    }

    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('input', updateTotal);
    });

    function confirmOrder() {
        const name = document.getElementById('customer_name').value;
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;
        const menus = document.querySelectorAll('input[name="menu_ids[]"]:checked');
        const payment = document.querySelector('input[name="payment_method"]:checked');

        if (!name || !phone || !address) {
            showToast('Peringatan!', 'Mohon lengkapi data diri Anda', 'error');
            return false;
        }
        if (menus.length === 0) {
            showToast('Peringatan!', 'Pilih minimal satu menu', 'error');
            return false;
        }
        if (!payment) {
            showToast('Peringatan!', 'Pilih metode pembayaran', 'error');
            return false;
        }

        document.getElementById('confirmModal').classList.add('active');
        return false;
    }

    function closeConfirm() {
        document.getElementById('confirmModal').classList.remove('active');
    }

    function submitOrder() {
        closeConfirm();
        document.querySelectorAll('.qty-input.hidden').forEach(input => input.disabled = true);
        document.getElementById('loadingOverlay').classList.add('active');
        document.querySelector('form').submit();
    }

    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('toast');
        const icon = document.getElementById('toast-icon');
        document.getElementById('toast-title').textContent = title;
        document.getElementById('toast-message').textContent = message;

        if (type === 'success') {
            icon.className = 'w-10 h-10 rounded-full flex items-center justify-center mr-3 flex-shrink-0 bg-green-100';
            icon.innerHTML = '&#10004;';
        } else {
            icon.className = 'w-10 h-10 rounded-full flex items-center justify-center mr-3 flex-shrink-0 bg-red-100';
            icon.innerHTML = '&#9888;';
        }
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 4000);
    }

    @if(session('success'))
        showToast('Berhasil!', @json(session('success')), 'success');
    @endif

    @if($errors->any())
        showToast('Gagal!', @json($errors->first()), 'error');
    @endif
</script>
@endpush

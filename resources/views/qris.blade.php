@extends('layouts.public')

@section('content')
    <section class="py-8 sm:py-12 flex-1">
        <div class="container mx-auto px-4 max-w-lg">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <span class="text-green-600 text-3xl">&#9641;</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-green-700">Pembayaran QRIS</h1>
                <p class="text-gray-500 mt-2 text-sm">Scan QR Code di bawah untuk membayar</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 text-center">
                <div class="mb-4">
                    <span class="text-sm text-gray-500">Nomor Pesanan</span>
                    <p class="text-2xl font-bold text-green-700">#{{ $order->daily_order_number }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 mb-6 border-2 border-dashed border-gray-300">
                    <img src="/images/qris-placeholder.png" alt="QRIS Code" class="w-56 h-56 mx-auto object-contain">
                    <p class="text-xs text-gray-400 mt-3">Ganti gambar ini dengan QR Code QRIS asli di <code class="bg-gray-200 px-1 rounded">public/images/qris-placeholder.png</code></p>
                </div>

                <div class="bg-green-50 rounded-lg p-4 mb-6">
                    <span class="text-sm text-gray-600">Total yang harus dibayar</span>
                    <p class="text-3xl font-bold text-green-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>

                <div class="text-left bg-gray-50 rounded-lg p-4 mb-6 text-sm">
                    <p class="font-semibold text-gray-700 mb-2">Cara Bayar:</p>
                    <ol class="list-decimal list-inside text-gray-600 space-y-1">
                        <li>Buka aplikasi mobile banking / e-wallet</li>
                        <li>Pilih menu <strong>Scan QR</strong></li>
                        <li>Scan QR Code di atas</li>
                        <li>Masukkan nominal sesuai total</li>
                        <li>Konfirmasi pembayaran</li>
                    </ol>
                </div>

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-left">
                        @foreach($errors->all() as $error)
                            <p class="text-red-600 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('order.uploadProof', $order->id) }}" enctype="multipart/form-data" id="paymentForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-4 text-left">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti Pembayaran <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-400 transition-colors cursor-pointer" id="dropZone" onclick="document.getElementById('payment_proof').click()">
                            <input type="file" name="payment_proof" id="payment_proof" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewImage(this)">
                            <div id="uploadPlaceholder">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <span class="text-gray-400 text-2xl">&#128247;</span>
                                </div>
                                <p class="text-sm text-gray-500">Klik untuk upload gambar</p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, atau WebP (Maks. 2MB)</p>
                            </div>
                            <div id="imagePreview" class="hidden">
                                <img id="previewImg" class="max-h-48 mx-auto rounded-lg mb-2">
                                <p id="fileName" class="text-sm text-gray-600 truncate"></p>
                                <button type="button" onclick="removeImage(event)" class="mt-2 text-sm text-red-500 hover:text-red-700 font-semibold">Hapus Gambar</button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" onclick="return validateUpload()" class="block w-full bg-green-600 text-white py-4 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg no-print">
                        &#10004; Sudah Bayar
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
    }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran gambar maksimal 2MB!');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('uploadPlaceholder').classList.add('hidden');
                document.getElementById('imagePreview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImage(e) {
        e.preventDefault();
        e.stopPropagation();
        document.getElementById('payment_proof').value = '';
        document.getElementById('uploadPlaceholder').classList.remove('hidden');
        document.getElementById('imagePreview').classList.add('hidden');
    }

    function validateUpload() {
        const input = document.getElementById('payment_proof');
        if (!input.files || !input.files[0]) {
            alert('Mohon upload bukti pembayaran terlebih dahulu!');
            return false;
        }
        return true;
    }
</script>
@endpush

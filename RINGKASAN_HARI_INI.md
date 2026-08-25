# Ringkasan Pekerjaan - 24 Agustus 2026

## Pemesanan Bakso (Bakso Pim)

---

## Bug Fixes

### 1. Missing Route Name
- **File:** `routes/web.php`
- **Masalah:** Route `GET /pesan` tidak punya nama, menyebabkan crash `RouteNotFoundException` saat redirect error di luar jam operasional
- **Fix:** Tambah `->name('pesan')`

### 2. Unsigned URL di Halaman QRIS
- **File:** `resources/views/qris.blade.php`
- **Masalah:** Link "Sudah Bayar" ke `order.struk` generate URL biasa, tapi route-nya pakai middleware `signed` → error 403
- **Fix:** Ganti `route()` dengan `URL::temporarySignedRoute()` (expire 30 menit)

### 3. Quantity Mismatch
- **File:** `resources/views/pesan.blade.php`
- **Masalah:** Input quantity untuk menu yang tidak dicentang tetap terkirim, menyebabkan index `menu_ids[]` dan `quantities[]` tidak cocok
- **Fix:** Disable input quantity yang tersembunyi sebelum form di-submit

### 4. RateLimiter Class Not Found
- **File:** `app/Providers/AppServiceProvider.php`
- **Masalah:** Namespace `\Illuminate\Support\RateLimiter\Limit` salah → error `Class not found`
- **Fix:** Ganti ke `\Illuminate\Cache\RateLimiting\Limit`

### 5. Double Escaping di Struk
- **File:** `app/Http/Controllers/HomeController.php`
- **Masalah:** `e()` di controller escape saat simpan, Blade `{{ }}` escape lagi → kode HTML entities muncul sebagai teks
- **Fix:** Hapus `e()` dari controller (Blade sudah auto-escape)

### 6. Double Escaping di Menu
- **File:** `app/Http/Controllers/MenuController.php`
- **Masalah:** Sama seperti di atas, `e()` di `name` dan `description`
- **Fix:** Hapus `e()` dari method `store()` dan `update()`

### 7. HTML Entity di Struk (Payment Method)
- **File:** `resources/views/struk.blade.php`
- **Masalah:** `&#9641;` di dalam `{{ }}` di-escape menjadi teks literal
- **Fix:** Ganti `{{ }}` dengan `{!! !!}` untuk rendering HTML entity

### 8. Field Phone Bisa Input Huruf
- **File:** `resources/views/pesan.blade.php` + `HomeController.php`
- **Masalah:** Field No. HP menerima karakter non-angka
- **Fix:** Tambah `inputmode="numeric"`, `pattern="[0-9]*"`, `onkeypress` filter, validasi regex `/^[0-9]+$/`

---

## Fitur Baru: Upload Bukti Pembayaran QRIS

### Database
- **Migration:** `2026_08_24_000000_add_payment_proof_to_orders_table.php` — tambah kolom `payment_proof` (nullable string) di tabel `orders`
- **Model:** Tambah `payment_proof` ke `$fillable` di `Order.php`

### Form Upload (User Side)
- **File:** `resources/views/qris.blade.php`
- Form upload gambar dengan drag/drop zone
- Validasi client-side: max 2MB, JPG/PNG/WebP
- Preview gambar sebelum upload
- Tombol hapus gambar

### Controller
- **File:** `app/Http/Controllers/HomeController.php`
- Method `uploadProof()` — validasi & simpan gambar ke `storage/app/public/payment-proofs`
- Route: `PUT /pesan/{order}/upload-proof`

### Halaman Admin (Bukti Bayar)
- **File:** `app/Http/Controllers/OrderController.php` — method `paymentProofs()`
- **File:** `resources/views/admin/orders/payment-proofs.blade.php` — halaman gallery bukti bayar
- **File:** `routes/web.php` — route `GET /admin/payment-proofs`
- Grid card menampilkan: no. pesanan, nama, HP, total, status, gambar bukti bayar
- Link "Lihat Full" untuk buka gambar ukuran penuh

### Dashboard
- **File:** `resources/views/admin/index.blade.php` — card navigasi "Bukti Bayar QRIS"

---

## Fix: Notifikasi Tidak Hilang Setelah "Baca Semua"

### Controller Changes
- **`OrderController@markAllRead`** — redirect ke `/admin` (dashboard), bukan `back()`
- **`MessageController@markAllRead`** — redirect ke `/admin` (dashboard), bukan `back()`
- **`AdminController@dashboard`** — tambah header `Cache-Control: no-cache, no-store, must-revalidate`

### Layout Changes
- **File:** `resources/views/layouts/admin.blade.php` — tambah meta tag anti-cache di `<head>`

---

## Fix: Tombol Kembali di Semua Halaman Admin

Ditambahkan tombol "Kembali" (`fas fa-arrow-left`) di 7 halaman:

| File | Target Kembali |
|------|---------------|
| `admin/orders/index.blade.php` | `/admin` |
| `admin/orders/show.blade.php` | `/admin/orders` |
| `admin/menu/index.blade.php` | `/admin` |
| `admin/menu/create.blade.php` | `/admin/menu` |
| `admin/menu/edit.blade.php` | `/admin/menu` |
| `admin/messages/index.blade.php` | `/admin` |
| `admin/messages/show.blade.php` | `/admin/messages` |

---

## Analisis & Dokumentasi

### Analisis Sistem Lengkap
- **File:** `ANALISIS_SISTEM.md`
- Cakupan: User, Scope, Business Constraints, Requirements, Measurable Metrics, Technical Feasibility, Architecture, Database (ERD + detail kolom), Security, Scalability

### Analisis Responsif
- 15 file blade dianalisis — skor **9.2/10**
- Semua halaman sudah responsif dengan Tailwind responsive classes
- 6 minor issues kosmetik teridentifikasi (belum diperbaiki)

---

## Daftar File yang Diubah/Dibuat

| File | Aksi |
|------|------|
| `routes/web.php` | Diubah (3 route baru + 1 nama route) |
| `app/Providers/AppServiceProvider.php` | Diubah (fix namespace Limit) |
| `app/Http/Controllers/HomeController.php` | Diubah (fix escaping + upload proof) |
| `app/Http/Controllers/MenuController.php` | Diubah (fix escaping) |
| `app/Http/Controllers/OrderController.php` | Diubah (markAllRead + paymentProofs) |
| `app/Http/Controllers/MessageController.php` | Diubah (markAllRead redirect) |
| `app/Models/Order.php` | Diubah (tambah payment_proof ke fillable) |
| `resources/views/qris.blade.php` | Diulis ulang (form upload bukti bayar) |
| `resources/views/struk.blade.php` | Diubah (fix HTML entity) |
| `resources/views/pesan.blade.php` | Diubah (fix quantity + phone numeric) |
| `resources/views/layouts/admin.blade.php` | Diubah (anti-cache meta tags) |
| `resources/views/admin/index.blade.php` | Diubah (tambah card bukti bayar) |
| `resources/views/admin/orders/index.blade.php` | Diubah (tambah tombol kembali) |
| `resources/views/admin/orders/show.blade.php` | Diubah (tambah tombol kembali) |
| `resources/views/admin/orders/payment-proofs.blade.php` | **Baru** |
| `resources/views/admin/menu/index.blade.php` | Diubah (tambah tombol kembali) |
| `resources/views/admin/menu/create.blade.php` | Diubah (tambah tombol kembali) |
| `resources/views/admin/menu/edit.blade.php` | Diubah (tambah tombol kembali) |
| `resources/views/admin/messages/index.blade.php` | Diubah (tambah tombol kembali) |
| `resources/views/admin/messages/show.blade.php` | Diubah (tambah tombol kembali) |
| `database/migrations/2026_08_24_000000_add_payment_proof_to_orders_table.php` | **Baru** |
| `ANALISIS_SISTEM.md` | **Baru** |
| `RINGKASAN_HARI_INI.md` | **Baru** (file ini) |

**Total: 23 file** (21 diubah/dibuat + 2 dokumen)

---

## Statistik

| Kategori | Jumlah |
|----------|--------|
| Bug fixes | 8 |
| Fitur baru | 1 (Upload Bukti Bayar QRIS) |
| Halaman admin diperbaiki | 7 (tombol kembali) |
| File diubah | 21 |
| File baru | 2 |

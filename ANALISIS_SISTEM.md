# Analisis Sistem - Bakso Pim

> Sistem Pemesanan Online Restoran Bakso Pim
> Laravel 12 | PHP 8.2 | MySQL | Tailwind CSS
> Terakhir diperbarui: 24 Agustus 2026

---

## Daftar Isi

1. [User](#1-user)
2. [Scope Website](#2-scope-website)
3. [Business Constraints](#3-business-constraints)
4. [Requirements](#4-requirements)
5. [Measurable Metrics](#5-measurable-metrics)
6. [Technical Feasibility](#6-technical-feasibility)
7. [Architecture](#7-architecture)
8. [Database](#8-database)
9. [Security](#9-security)
10. [Scalability](#10-scalability)

---

## 1. User

| Role | Akses | Fungsi |
|------|-------|--------|
| **Pelanggan** | Halaman publik | Lihat menu, buat pesanan, upload bukti bayar QRIS, lihat struk, kirim pesan/kontak |
| **Admin** | Panel admin (`/admin`) | Kelola menu (CRUD), kelola pesanan (status), lihat bukti bayar QRIS, baca pesan, tambah admin baru, generate QR Code meja |
| **Kasir/Staff** | Panel admin | Role tersedia di registrasi, tapi belum ada pembagian hak akses per-role (semua role bisa akses semua fitur admin) |

---

## 2. Scope Website

### Yang Sudah Ada

- Homepage (info restoran + katalog menu)
- Sistem pemesanan online (form → struk/QRIS)
- Pembayaran QRIS (upload bukti bayar)
- Pembayaran kasir (bayar di tempat)
- Panel admin (CRUD menu, manage pesanan, lihat bukti bayar, baca pesan)
- QR Code generator untuk meja
- Form kontak/pesan
- Logging aktivitas admin
- Rate limiting & security headers

### Yang BELUM Ada

- Tidak ada auth per-role (admin/kasir/staff semua sama aksesnya)
- Tidak ada fitur pencarian/filter pesanan
- Tidak ada notifikasi real-time (WebSocket/push)
- Tidak ada integrasi pembayaran asli (QRIS masih placeholder)
- Tidak ada fitur cetak struk otomatis
- Tidak ada halaman riwayat pesanan untuk pelanggan
- Tidak ada dashboard analitik (grafik penjualan, dll)
- Tidak ada fitur promo/diskon
- Tidak ada multi-outlet/branch
- Tidak ada API untuk mobile app

---

## 3. Business Constraints

| Constraint | Keterangan |
|------------|------------|
| **Jam operasional** | Hanya bisa pesan jam 10:00 - 23:00 WIB |
| **Lokasi** | Restoran fisik, pengiriman berdasarkan alamat |
| **Pembayaran** | QRIS (manual upload bukti) atau kasir (bayar di tempat) |
| **Menu** | Hanya 2 kategori: makanan & minuman |
| **Order per hari** | Tidak ada batasan, tapi `daily_order_number` di-reset tiap hari |
| **Harga** | Integer (Rp), max Rp 10.000.000 |
| **Ukuran gambar** | Menu: 2MB, Bukti bayar: 2MB |
| **Rate limit** | Login: 5/menit, Order: 3/menit, Kontak: 3/menit, Register: 2/menit |

---

## 4. Requirements

### Functional

1. Pelanggan bisa lihat menu, pilih item + jumlah, isi data diri, pilih metode bayar
2. Pelanggan upload bukti bayar QRIS (wajib, max 2MB)
3. Admin bisa CRUD menu (nama, kategori, deskripsi, harga, gambar, status)
4. Admin bisa lihat & update status pesanan (pending → diproses → dikirim → selesai / dibatalkan)
5. Admin bisa lihat bukti bayar QRIS
6. Admin bisa baca/hapus pesan dari pengunjung
7. Sistem generate struk printable setelah order

### Non-Functional

1. Mobile responsive (Tailwind CSS)
2. Anti-cache di halaman admin
3. Security headers (HSTS, XSS protection, nosniff, DENY frame)
4. Activity logging untuk audit trail
5. Spam prevention

---

## 5. Measurable Metrics

| Metrik | Cara Ukur |
|--------|-----------|
| **Jumlah pesanan/hari** | Query `orders` WHERE `created_at` = hari ini |
| **Total penjualan/hari** | SUM `total_price` dari orders hari ini |
| **Menu paling laris** | COUNT order_items GROUP BY `menu_id` |
| **Waktu rata-rata pemrosesan** | Selisih `updated_at` status diproses → dikirim |
| **Tingkat pembatalan** | COUNT status `dibatalkan` / total orders |
| **Jumlah pesan masuk** | COUNT `messages` |
| **Admin aktif** | COUNT unique users di activity log |
| **Response time** | Bisa ditambahkan logging middleware |

> Catatan: Saat ini belum ada dashboard analitik otomatis. Metrics di atas baru bisa dihitung manual via query database.

---

## 6. Technical Feasibility

| Aspek | Status | Keterangan |
|-------|--------|------------|
| **Tech stack** | Solid | Laravel 12 + PHP 8.2 + MySQL + Tailwind CSS |
| **Deployment** | Siap | Dockerfile + Railway config sudah ada |
| **Payment integration** | Partial | QRIS masih placeholder, perlu integrasi gateway asli (Midtrans/Xendit) |
| **Real-time** | Belum | Tidak ada WebSocket, semua HTTP polling |
| **Mobile app** | Belum | Tidak ada API, hanya web |
| **Multi-tenant** | Belum | Single restoran only |
| **Testing** | Minimal | Hanya 1 Feature test + 1 Unit test |
| **CI/CD** | Belum | Tidak ada GitHub Actions/GitLab CI |

---

## 7. Architecture

```
┌─────────────────────────────────────────────────────┐
│                    BROWSER (CLIENT)                  │
│  Public: Homepage, Pesan, QRIS, Struk, Login, Reg   │
│  Admin:  Dashboard, Menu CRUD, Orders, Messages     │
└──────────────────────┬──────────────────────────────┘
                       │ HTTP Request
┌──────────────────────▼──────────────────────────────┐
│                 LARAVEL 12 (MVC)                     │
│                                                      │
│  ┌─────────┐  ┌──────────────┐  ┌───────────────┐  │
│  │ Routes  │→ │ Controllers  │→ │    Views       │  │
│  │web.php  │  │ Home, Admin, │  │ (Blade 19     │  │
│  │ 24 rts  │  │ Menu, Order, │  │  templates)   │  │
│  │         │  │ Message      │  │               │  │
│  └─────────┘  └──────┬───────┘  └───────────────┘  │
│                      │                               │
│  ┌───────────────────▼──────────────────────────┐   │
│  │              MODELS (Eloquent)                │   │
│  │  User, Menu, Order, OrderItem, Message        │   │
│  └───────────────────┬──────────────────────────┘   │
│                      │                               │
│  ┌───────────────────▼──────────────────────────┐   │
│  │           MIDDLEWARE STACK                    │   │
│  │  SecurityHeaders, CSRF, Auth, Activity,       │   │
│  │  RateLimit (login/order/contact/register)     │   │
│  └───────────────────┬──────────────────────────┘   │
│                      │                               │
│  ┌───────────────────▼──────────────────────────┐   │
│  │           STORAGE (filesystem)                │   │
│  │  public/menu/* (menu images)                  │   │
│  │  public/payment-proofs/* (bukti bayar)        │   │
│  │  storage/logs/activity.log (audit trail)      │   │
│  └──────────────────────────────────────────────┘   │
└──────────────────────┬──────────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────────┐
│                  MySQL DATABASE                      │
│  users, menus, orders, order_items, messages,        │
│  sessions, cache, jobs, failed_jobs                   │
└─────────────────────────────────────────────────────┘
```

**Pattern:** Monolithic MVC, server-side rendering (Blade), database-backed sessions/queue/cache.

### Flow Aplikasi

1. Pelanggan buka homepage (`/`), lihat menu dari database `menus`
2. Pelanggan klik "Pesan Sekarang" (`/pesan`), isi form (nama/telepon/alamat/pilih menu/catatan/metode bayar)
3. Order disubmit (`POST /pesan`) → buat `orders` + `order_items` dalam database transaction
4. Jika QRIS → redirect ke signed URL (QR code + form upload bukti bayar)
5. Jika Kasir → redirect ke signed URL (struk/cetak)
6. Admin login, lihat dashboard (unread orders & messages)
7. Admin kelola menu, update status pesanan, lihat bukti bayar, baca pesan

### File Structure

```
resources/views/
├── layouts/
│   ├── public.blade.php          # Layout halaman publik
│   └── admin.blade.php           # Layout panel admin
├── main.blade.php                # Homepage
├── pesan.blade.php               # Form pemesanan
├── qris.blade.php                # Halaman pembayaran QRIS
├── struk.blade.php               # Struk/cetak
├── login.blade.php               # Login admin
├── register.blade.php            # Registrasi admin
└── admin/
    ├── index.blade.php           # Dashboard admin
    ├── qrcode.blade.php          # QR Code generator
    ├── menu/
    │   ├── index.blade.php       # Daftar menu
    │   ├── create.blade.php      # Tambah menu
    │   └── edit.blade.php        # Edit menu
    └── orders/
        ├── index.blade.php       # Daftar pesanan
        ├── show.blade.php        # Detail pesanan
        └── payment-proofs.blade.php  # Bukti bayar QRIS
```

---

## 8. Database

### Entity Relationship Diagram

```
┌──────────────┐     ┌──────────────┐
│    users      │     │    menus      │
│──────────────│     │──────────────│
│ id (PK)      │     │ id (PK)      │
│ name         │     │ name         │
│ email        │     │ category     │ ← enum: makanan/minuman
│ password     │     │ description  │ ← nullable
│ phone        │     │ price        │
│ status       │     │ image        │ ← nullable
│ created_at   │     │ is_available │
│ updated_at   │     │ created_at   │
└──────────────┘     │ updated_at   │
                     └──────┬───────┘
                            │ 1:N
┌──────────────┐     ┌──────▼───────┐
│   messages    │     │   orders      │
│──────────────│     │──────────────│
│ id (PK)      │     │ id (PK)      │
│ name         │     │ customer_name│
│ email        │     │ phone        │
│ message      │     │ address      │
│ is_read      │     │ notes        │ ← nullable
│ created_at   │     │ total_price  │
│ updated_at   │     │ status       │ ← enum: 5 values
└──────────────┘     │ is_read      │
                     │ payment_method│ ← enum: qris/kasir
                     │ payment_proof│ ← nullable
                     │ created_at   │
                     └──────┬───────┘
                            │ 1:N
                     ┌──────▼───────┐
                     │ order_items   │
                     │──────────────│
                     │ id (PK)      │
                     │ order_id (FK)│ ← cascade delete
                     │ menu_id (FK) │ ← cascade delete
                     │ quantity     │
                     │ price        │
                     │ created_at   │
                     │ updated_at   │
                     └──────────────┘
```

### Tabel Detail

#### users

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint, PK | Auto increment |
| name | string | Nama admin/kasir/staff |
| email | string, unique | Email login |
| email_verified_at | timestamp, nullable | Verifikasi email |
| password | string | Hashed password |
| remember_token | string, nullable | Remember me token |
| phone | string, nullable | Nomor HP |
| status | enum | admin / kasir / staff |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

#### menus

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint, PK | Auto increment |
| name | string | Nama menu |
| category | enum | makanan / minuman |
| description | text, nullable | Deskripsi menu |
| price | integer | Harga dalam Rupiah |
| image | string, nullable | Path gambar (storage) |
| is_available | boolean | Status ketersediaan |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

#### orders

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint, PK | Auto increment |
| customer_name | string | Nama pelanggan |
| phone | string | Nomor HP pelanggan |
| address | text | Alamat pengiriman |
| notes | text, nullable | Catatan pesanan |
| total_price | integer | Total harga (default: 0) |
| status | enum | pending / diproses / dikirim / selesai / dibatalkan |
| is_read | boolean | Sudah dibaca admin (default: false) |
| payment_method | enum | qris / kasir |
| payment_proof | string, nullable | Path bukti bayar (storage) |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

#### order_items

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint, PK | Auto increment |
| order_id | bigint, FK | Relasi ke orders (cascade delete) |
| menu_id | bigint, FK | Relasi ke menus (cascade delete) |
| quantity | integer | Jumlah item (default: 1) |
| price | integer | Harga satuan saat order |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

#### messages

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint, PK | Auto increment |
| name | string | Nama pengirim |
| email | string | Email pengirim |
| message | text | Isi pesan |
| is_read | boolean | Sudah dibaca admin (default: false) |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### Tabel Laravel Bawaan

| Tabel | Fungsi |
|-------|--------|
| sessions | Session storage (database-backed) |
| cache | Cache storage (database-backed) |
| cache_locks | Cache lock mechanism |
| jobs | Queue jobs |
| job_batches | Batch job tracking |
| failed_jobs | Failed job logging |
| password_reset_tokens | Password reset |
| migrations | Migration tracking |

---

## 9. Security

### Yang Sudah Diimplementasi

| Layer | Implementasi | Status |
|-------|-------------|--------|
| **CSRF** | Laravel default (token per-form) | ✓ |
| **SQL Injection** | Eloquent ORM (parameterized queries) | ✓ |
| **XSS** | Blade `{{ }}` auto-escape + SecurityHeaders middleware | ✓ |
| **Signed URLs** | Order pages (QRIS/struk) expire 30 menit | ✓ |
| **Rate Limiting** | 4 rate limiters (login, order, contact, register) | ✓ |
| **Password** | Min 8 chars, mixed case + numbers, hashed | ✓ |
| **Session** | Database-backed, encrypted, regenerate on login | ✓ |
| **Honeypot** | Field `dummy_email` di form login | ✓ |
| **Security Headers** | HSTS, X-Frame-Options: DENY, nosniff, XSS protection, Referrer-Policy, Permissions-Policy | ✓ |
| **Activity Logging** | Admin actions logged ke `activity.log` | ✓ |
| **Operational Hours** | Server-side check jam 10-23 | ✓ |
| **Spam Prevention** | Custom `PreventSpam` middleware | ✓ |

### Security Headers (Global Middleware)

```
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=()
Strict-Transport-Security: max-age=31536000; includeSubDomains
```

### Rate Limiters

| Nama | Limit | Key |
|------|-------|-----|
| `login` | 5 per menit | email + IP |
| `order` | 3 per menit | IP |
| `contact` | 3 per menit | IP |
| `register` | 2 per menit | IP |

### Yang Kurang

- Tidak ada Two-Factor Authentication (2FA)
- Tidak ada email verification
- Tidak ada password reset (fitur belum di-build)
- Tidak ada CAPTCHA (honeypot saja)
- Upload proof route tidak ada rate limit
- Tidak ada input sanitization tambahan (selain Blade escape)

---

## 10. Scalability

### Kondisi Saat Ini

| Aspek | Saat Ini | Masalah | Solusi yang Disarankan |
|-------|----------|---------|------------------------|
| **Users** | Single restoran | Tidak scalable ke multi-outlet | Perlu multi-tenant architecture |
| **Database** | MySQL, no indexing strategy | Lambat jika order ribuan/hari | Tambah index di `orders.is_read`, `orders.created_at`, `orders.status` |
| **Sessions** | Database-backed | Lambat di high traffic | Pindah ke Redis |
| **Cache** | Database-backed | Lambat | Pindah ke Redis/Memcached |
| **Queue** | Database-backed | Tidak cocok untuk high throughput | Pindah ke Redis/SQS |
| **File Storage** | Local filesystem | Tidak scalable | Pindah ke S3/Cloudinary |
| **Assets** | Vite build | OK untuk single server | Tambah CDN |
| **Search** | Manual query | Lambat dengan data besar | Tambah full-text search / Meilisearch |
| **Real-time** | Tidak ada | Tidak ada notifikasi push | Tambah WebSocket (Laravel Echo + Pusher/Soketi) |
| **Horizontal Scale** | Single server (Docker) | Stateless OK, tapi DB jadi bottleneck | Database read replica + Redis session/cache |

### Estimasi Kapasitas

| Kondisi | Kapasitas |
|---------|-----------|
| **Saat ini** | Cocok untuk 1 restoran, 1-2 admin, ~50-100 order/hari |
| **Dengan optimasi DB + Redis** | Bisa naik ke 500-1000 order/hari |
| **Multi-outlet / franchise** | Perlu arsitektur ulang (multi-tenant, API-first, queue workers) |

### Rekomendasi Optimasi

**Prioritas Tinggi:**
1. Pindah session & cache ke Redis
2. Tambah database index pada kolom yang sering di-query
3. Tambah rate limit pada upload proof route
4. Implementasi password reset

**Prioritas Menengah:**
1. Tambah dashboard analitik (grafik penjualan, menu terlaris)
2. Implementasi pencarian & filter pesanan
3. Tambah notifikasi real-time untuk pesanan baru
4. Integrasi payment gateway asli (Midtrans/Xendit)

**Prioritas Rendah:**
1. Buat API untuk mobile app
2. Implementasi multi-tenant untuk franchise
3. Tambah CI/CD pipeline
4. Tambah test coverage
5. Implementasi 2FA untuk admin

---

## Lampiran: Daftar File

### Controllers

| File | Method | Fungsi |
|------|--------|--------|
| `app/Http/Controllers/HomeController.php` | `index()` | Homepage |
| | `pesan()` | Form pemesanan |
| | `submitOrder()` | Proses order |
| | `qris()` | Halaman QRIS |
| | `struk()` | Struk/cetak |
| | `uploadProof()` | Upload bukti bayar |
| `app/Http/Controllers/AdminController.php` | `loginForm()` | Form login |
| | `login()` | Proses login |
| | `logout()` | Proses logout |
| | `dashboard()` | Dashboard admin |
| | `qrcode()` | QR Code generator |
| | `registerForm()` | Form registrasi |
| | `register()` | Proses registrasi |
| `app/Http/Controllers/MenuController.php` | `index()` | Daftar menu |
| | `create()` | Form tambah menu |
| | `store()` | Simpan menu |
| | `edit()` | Form edit menu |
| | `update()` | Update menu |
| | `destroy()` | Hapus menu |
| `app/Http/Controllers/OrderController.php` | `index()` | Daftar pesanan |
| | `show()` | Detail pesanan |
| | `updateStatus()` | Update status |
| | `markAllRead()` | Tandai semua dibaca |
| | `paymentProofs()` | Bukti bayar QRIS |
| `app/Http/Controllers/MessageController.php` | `index()` | Daftar pesan |
| | `show()` | Detail pesan |
| | `markAllRead()` | Tandai semua dibaca |
| | `destroy()` | Hapus pesan |
| | `store()` | Kirim pesan (kontak) |

### Models

| File | Relasi | Accessor/Method |
|------|--------|-----------------|
| `app/Models/User.php` | - | - |
| `app/Models/Menu.php` | `hasMany(OrderItem)` | - |
| `app/Models/Order.php` | `hasMany(OrderItem)` | `getTotalAttribute()`, `getDailyOrderNumberAttribute()`, `isOperationalHours()`, `getTodayOrderCount()` |
| `app/Models/OrderItem.php` | `belongsTo(Order)`, `belongsTo(Menu)` | - |
| `app/Models/Message.php` | - | - |

### Middleware

| File | Alias | Fungsi |
|------|-------|--------|
| `app/Http/Middleware/SecurityHeaders` | global | Security headers (HSTS, X-Frame-Options, nosniff, XSS) |
| `app/Http/Middleware/PreventSpam` | `spam` | Rate limiting custom |
| `app/Http/Middleware/AdminActivity` | `activity` | Log aktivitas admin |

### Routes (24 total)

| Method | URI | Middleware | Fungsi |
|--------|-----|-----------|--------|
| GET | `/` | - | Homepage |
| POST | `/kontak` | throttle:contact | Kirim pesan |
| GET | `/pesan` | - | Form pesanan |
| POST | `/pesan` | throttle:order | Submit order |
| GET | `/pesan/{order}/qris` | signed | Halaman QRIS |
| GET | `/pesan/{order}/struk` | signed | Struk |
| PUT | `/pesan/{order}/upload-proof` | - | Upload bukti bayar |
| GET | `/login` | - | Form login |
| POST | `/login` | throttle:login | Proses login |
| POST | `/logout` | - | Logout |
| GET | `/admin` | auth, activity | Dashboard |
| GET | `/register` | auth | Form registrasi |
| POST | `/register` | auth, throttle:register | Proses registrasi |
| GET | `/admin/qrcode` | auth | QR Code generator |
| GET | `/admin/payment-proofs` | auth | Bukti bayar QRIS |
| GET | `/admin/menu` | auth, activity | Daftar menu |
| GET | `/admin/menu/create` | auth, activity | Form tambah menu |
| POST | `/admin/menu` | auth, activity | Simpan menu |
| GET | `/admin/menu/{menu}/edit` | auth, activity | Form edit menu |
| PUT | `/admin/menu/{menu}` | auth, activity | Update menu |
| DELETE | `/admin/menu/{menu}` | auth, activity | Hapus menu |
| GET | `/admin/orders` | auth, activity | Daftar pesanan |
| GET | `/admin/orders/read-all` | auth, activity | Tandai semua dibaca |
| GET | `/admin/orders/{order}` | auth, activity | Detail pesanan |
| PUT | `/admin/orders/{order}/status` | auth, activity | Update status |
| GET | `/admin/messages` | auth, activity | Daftar pesan |
| GET | `/admin/messages/read-all` | auth, activity | Tandai semua dibaca |
| GET | `/admin/messages/{message}` | auth, activity | Detail pesan |
| DELETE | `/admin/messages/{message}` | auth, activity | Hapus pesan |

# 📋 Rule Web — Sistem Pembelian Tiket & Booking Tempat
## Pemandian Air Panas Banyu Biru Nganjuk

---

## 🧱 Tech Stack

| Komponen | Teknologi |
|---|---|
| Framework | Laravel 11 |
| Database | MySQL |
| Templating | Blade Templating (layouts, partials) |
| Styling | Bootstrap 5 (CDN) + Custom CSS |
| Icons | Font Awesome 6 (CDN) |
| Alert/Notifikasi | SweetAlert2 (CDN) |
| Tabel Admin | DataTables (CDN) |
| Grafik Dashboard | Chart.js (CDN) |
| QR Code Generate | `simplesoftwareio/simple-qrcode` |
| QR Code Scan | `instascan.js` atau `html5-qrcode` |
| PDF Generate | `barryvdh/laravel-dompdf` |
| Permission | `spatie/laravel-permission` |
| File Upload | Laravel Storage (drag & drop) |

---

## 📦 Paket Composer yang Dibutuhkan

```bash
composer require spatie/laravel-permission
composer require barryvdh/laravel-dompdf
composer require simplesoftwareio/simple-qrcode
```

---

## 🗄️ Struktur Database & Relasi

### Tabel: `users`
```sql
id              BIGINT PK AUTO_INCREMENT
name            VARCHAR(100)
email           VARCHAR(150) UNIQUE
password        VARCHAR(255)
phone           VARCHAR(20) NULLABLE
address         TEXT NULLABLE
avatar          VARCHAR(255) NULLABLE
email_verified_at TIMESTAMP NULLABLE
remember_token  VARCHAR(100) NULLABLE
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Tabel: `roles` (spatie)
```sql
id              BIGINT PK
name            VARCHAR(125) -- 'admin' | 'user'
guard_name      VARCHAR(125)
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Tabel: `model_has_roles` (spatie)
```sql
role_id         BIGINT FK -> roles.id
model_type      VARCHAR(255)
model_id        BIGINT
```

### Tabel: `tickets`
```sql
id              BIGINT PK AUTO_INCREMENT
name            VARCHAR(100)       -- Nama tiket (Dewasa, Anak-anak, dll)
description     TEXT NULLABLE
price           DECIMAL(10,2)
quota_per_day   INT DEFAULT 100    -- Kuota harian
is_active       BOOLEAN DEFAULT 1
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Tabel: `ticket_orders`
```sql
id              BIGINT PK AUTO_INCREMENT
user_id         BIGINT FK -> users.id
order_code      VARCHAR(20) UNIQUE  -- Format: AT-XXXXX (random 5 digit)
visit_date      DATE
total_qty       INT
total_price     DECIMAL(10,2)
payment_proof   VARCHAR(255) NULLABLE
status          ENUM('pending','confirmed','rejected') DEFAULT 'pending'
confirmed_at    TIMESTAMP NULLABLE
confirmed_by    BIGINT FK -> users.id NULLABLE
rejection_note  TEXT NULLABLE
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Tabel: `ticket_order_items`
```sql
id              BIGINT PK AUTO_INCREMENT
ticket_order_id BIGINT FK -> ticket_orders.id
ticket_id       BIGINT FK -> tickets.id
ticket_code     VARCHAR(20) UNIQUE  -- Format: AT-XXXXX per tiket individual
qr_code_path    VARCHAR(255)        -- Path file QR code image
qty             INT
price           DECIMAL(10,2)       -- Harga saat beli (snapshot)
is_used         BOOLEAN DEFAULT 0
used_at         TIMESTAMP NULLABLE
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Tabel: `places`
```sql
id              BIGINT PK AUTO_INCREMENT
name            VARCHAR(100)        -- Nama kolam/tempat
description     TEXT NULLABLE
capacity        INT                 -- Kapasitas per booking
price_per_day   DECIMAL(10,2)
image           VARCHAR(255) NULLABLE
is_active       BOOLEAN DEFAULT 1
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Tabel: `bookings`
```sql
id              BIGINT PK AUTO_INCREMENT
user_id         BIGINT FK -> users.id
place_id        BIGINT FK -> places.id
booking_code    VARCHAR(20) UNIQUE  -- Format: AB-XXXXX
booking_date    DATE                -- Tanggal booking (UNIQUE per place_id)
visitor_name    VARCHAR(100)
visitor_phone   VARCHAR(20)
visitor_address TEXT
num_persons     INT
total_price     DECIMAL(10,2)
payment_proof   VARCHAR(255) NULLABLE
status          ENUM('pending','confirmed','rejected') DEFAULT 'pending'
confirmed_at    TIMESTAMP NULLABLE
confirmed_by    BIGINT FK -> users.id NULLABLE
rejection_note  TEXT NULLABLE
notes           TEXT NULLABLE
created_at      TIMESTAMP
updated_at      TIMESTAMP
```
> **Constraint**: `UNIQUE(place_id, booking_date)` — satu tempat hanya bisa dibooking 1x per tanggal.

### Tabel: `bank_accounts`
```sql
id              BIGINT PK AUTO_INCREMENT
bank_name       VARCHAR(100)        -- BRI, BNI, Mandiri, dll
account_number  VARCHAR(50)
account_name    VARCHAR(100)
is_active       BOOLEAN DEFAULT 1
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Tabel: `settings`
```sql
id              BIGINT PK AUTO_INCREMENT
key             VARCHAR(100) UNIQUE
value           TEXT
created_at      TIMESTAMP
updated_at      TIMESTAMP
```
> Contoh key: `site_name`, `site_logo`, `ticket_note`, `booking_note`

---

## 🗂️ Struktur Direktori Proyek

```
resources/
└── views/
    ├── layouts/
    │   ├── app.blade.php           # Layout utama user (navbar, footer)
    │   ├── admin.blade.php         # Layout admin (sidebar, topbar)
    │   └── auth.blade.php          # Layout halaman auth (login/register)
    ├── partials/
    │   ├── navbar.blade.php
    │   ├── footer.blade.php
    │   ├── admin/
    │   │   ├── sidebar.blade.php
    │   │   └── topbar.blade.php
    │   └── alerts.blade.php        # SweetAlert global
    ├── auth/
    │   ├── login.blade.php
    │   └── register.blade.php
    ├── user/
    │   ├── dashboard.blade.php
    │   ├── profile.blade.php
    │   ├── tickets/
    │   │   ├── index.blade.php     # Pembelian tiket
    │   │   ├── payment.blade.php   # Input bukti bayar
    │   │   └── download.blade.php  # Download tiket PDF
    │   └── bookings/
    │       ├── index.blade.php     # Form booking tempat
    │       ├── payment.blade.php   # Input bukti bayar booking
    │       └── status.blade.php    # Status booking
    ├── admin/
    │   ├── dashboard.blade.php
    │   ├── tickets/
    │   │   ├── index.blade.php
    │   │   ├── create.blade.php
    │   │   └── edit.blade.php
    │   ├── ticket-orders/
    │   │   ├── index.blade.php
    │   │   └── show.blade.php
    │   ├── bookings/
    │   │   ├── index.blade.php
    │   │   └── show.blade.php
    │   ├── admins/
    │   │   ├── index.blade.php
    │   │   ├── create.blade.php
    │   │   └── edit.blade.php
    │   ├── profile.blade.php
    │   └── check/
    │       ├── ticket.blade.php    # Check tiket (scan QR / input kode)
    │       └── booking.blade.php   # Check booking (input kode)
    └── pdf/
        └── ticket.blade.php        # Template PDF tiket
```

---

## 📐 Layouts & @stack Convention

### `layouts/app.blade.php` (User)
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Banyu Biru') - Pemandian Air Panas</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <main class="main-content">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.alerts')

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>
```

### `layouts/admin.blade.php` (Admin)
```html
<!DOCTYPE html>
<html lang="id">
<head>
    ...CDN Links...
    <!-- DataTables CDN -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-body">
    @include('partials.admin.sidebar')
    <div class="admin-wrapper">
        @include('partials.admin.topbar')
        <main class="admin-content">
            @yield('content')
        </main>
    </div>

    ...CDN Scripts...
    <!-- jQuery (required DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS CDN -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
</body>
</html>
```

### Penggunaan di halaman child:
```blade
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    /* custom style khusus halaman ini */
</style>
@endpush

@section('content')
    <!-- konten halaman -->
@endsection

@push('scripts')
<script>
    // JS khusus halaman ini
</script>
@endpush
```

---

## 🛣️ Routes

```php
// routes/web.php

// ─── AUTH ────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── USER ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:user'])->prefix('')->name('user.')->group(function () {

    // Tiket
    Route::get('/tiket',                  [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tiket/order',           [TicketController::class, 'order'])->name('tickets.order');
    Route::get('/tiket/payment/{code}',   [TicketController::class, 'payment'])->name('tickets.payment');
    Route::post('/tiket/upload/{code}',   [TicketController::class, 'uploadProof'])->name('tickets.upload');
    Route::get('/tiket/download/{code}',  [TicketController::class, 'download'])->name('tickets.download');
    Route::get('/tiket/pdf/{itemId}',     [TicketController::class, 'downloadPdf'])->name('tickets.pdf');

    // Booking
    Route::get('/booking',                [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/booking/store',         [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking/payment/{code}', [BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('/booking/upload/{code}', [BookingController::class, 'uploadProof'])->name('bookings.upload');
    Route::get('/booking/status/{code}',  [BookingController::class, 'status'])->name('bookings.status');

    // API: cek ketersediaan tanggal booking
    Route::get('/booking/check-date',     [BookingController::class, 'checkDate'])->name('bookings.checkDate');

    // Profil
    Route::get('/profil',                 [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil',                 [ProfileController::class, 'update'])->name('profile.update');
});

// ─── ADMIN ────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard',              [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Tiket
    Route::resource('tickets',            Admin\TicketController::class);

    // Manajemen Penjualan Tiket
    Route::get('ticket-orders',           [Admin\TicketOrderController::class, 'index'])->name('ticket-orders.index');
    Route::get('ticket-orders/{id}',      [Admin\TicketOrderController::class, 'show'])->name('ticket-orders.show');
    Route::post('ticket-orders/{id}/confirm',  [Admin\TicketOrderController::class, 'confirm'])->name('ticket-orders.confirm');
    Route::post('ticket-orders/{id}/reject',   [Admin\TicketOrderController::class, 'reject'])->name('ticket-orders.reject');

    // Manajemen Booking Tempat
    Route::get('bookings',                [Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{id}',           [Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{id}/confirm',  [Admin\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{id}/reject',   [Admin\BookingController::class, 'reject'])->name('bookings.reject');

    // Manajemen Admin
    Route::resource('admins',             Admin\AdminController::class)->except('show');

    // Profil Admin
    Route::get('profil',                  [Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profil',                  [Admin\ProfileController::class, 'update'])->name('profile.update');

    // Check Tiket & Booking
    Route::get('check/ticket',            [Admin\CheckController::class, 'ticketIndex'])->name('check.ticket');
    Route::post('check/ticket',           [Admin\CheckController::class, 'checkTicket'])->name('check.ticket.check');
    Route::get('check/booking',           [Admin\CheckController::class, 'bookingIndex'])->name('check.booking');
    Route::post('check/booking',          [Admin\CheckController::class, 'checkBooking'])->name('check.booking.check');

    // Bank Account (opsional)
    Route::resource('bank-accounts',      Admin\BankAccountController::class)->except('show');
});
```

---

## 🔄 Alur Fitur

### ✅ Alur Pembelian Tiket

```
1. [GET]  /tiket
   → Halaman form pembelian tiket
   → User isi: Nama, Email, No HP, Tanggal Kunjungan
   → Pilih jenis tiket + quantity (tombol - dan +)
   → Klik "Beli Sekarang"
   → Jika belum login → SweetAlert "Silakan login terlebih dahulu"

2. [POST] /tiket/order
   → Simpan ticket_orders + ticket_order_items
   → Generate kode unik AT-XXXXX per item tiket
   → Generate QR Code per item (simpan di storage)
   → Redirect ke halaman payment

3. [GET]  /tiket/payment/{order_code}
   → Tampilkan total pembayaran
   → Tampilkan nomor rekening + tombol salin (icon copy)
   → Drag & drop upload bukti transfer (file input area)

4. [POST] /tiket/upload/{order_code}
   → Upload payment_proof ke storage
   → Update status order → 'pending'
   → Redirect ke halaman download tiket

5. [GET]  /tiket/download/{order_code}
   → Tampilkan peringatan download segera (SweetAlert / Alert Bootstrap)
   → Tampilkan card tiket per item (qty tiket = jumlah card)
   → Setiap card: info tiket + tombol "Download PDF"

6. [GET]  /tiket/pdf/{item_id}
   → Generate PDF tiket (dompdf)
   → Berisi: nama, tanggal kunjungan, jenis tiket, kode tiket, QR Code
```

### ✅ Alur Booking Tempat

```
1. [GET]  /booking
   → Form booking: Nama, No HP, Alamat, Pilih Tempat, Tanggal Booking, Jumlah Orang, Catatan
   → Saat pilih tanggal → AJAX cek ketersediaan tanggal (/booking/check-date)
   → Jika tanggal sudah dipakai → tampilkan SweetAlert "Tanggal sudah dibooking, pilih tanggal lain"
   → Jika belum login → SweetAlert "Silakan login terlebih dahulu"

2. [POST] /booking/store
   → Simpan booking ke tabel bookings
   → Generate kode unik AB-XXXXX
   → status = 'pending'
   → Redirect ke halaman payment booking

3. [GET]  /booking/payment/{booking_code}
   → Tampilkan total pembayaran
   → Tampilkan nomor rekening + tombol salin (icon copy)
   → Drag & drop upload bukti transfer

4. [POST] /booking/upload/{booking_code}
   → Upload payment_proof
   → Redirect ke halaman status booking

5. [GET]  /booking/status/{booking_code}
   → Tampilkan status booking: pending / dikonfirmasi / ditolak
   → Badge warna sesuai status
   → Jika ditolak, tampilkan alasan penolakan
```

---

## 🎨 UI/UX Rules

### Global
- Font: **Inter** atau **Poppins** dari Google Fonts
- Warna utama: `#1a6b4a` (hijau air / alam) + `#f0a500` (kuning aksen)
- Radius card: `12px`, shadow soft `box-shadow: 0 4px 20px rgba(0,0,0,0.08)`
- Semua notifikasi/konfirmasi/alert menggunakan **SweetAlert2**
- Tombol aksi menggunakan class Bootstrap + custom CSS gradient

### Komponen Quantity Tiket
```html
<div class="quantity-control d-flex align-items-center gap-2">
    <button class="btn btn-outline-secondary btn-sm qty-minus" type="button">
        <i class="fas fa-minus"></i>
    </button>
    <input type="number" class="form-control text-center qty-input" 
           value="1" min="1" max="20" style="width: 70px;">
    <button class="btn btn-outline-secondary btn-sm qty-plus" type="button">
        <i class="fas fa-plus"></i>
    </button>
</div>
```

### Komponen Salin Nomor Rekening
```html
<div class="rekening-box d-flex align-items-center gap-2 p-3 bg-light rounded-3 border">
    <div>
        <small class="text-muted">{{ $bank->bank_name }} — a/n {{ $bank->account_name }}</small>
        <div class="fw-bold fs-5" id="noRek">{{ $bank->account_number }}</div>
    </div>
    <button class="btn btn-outline-primary btn-sm ms-auto copy-btn" 
            data-clipboard-target="#noRek" title="Salin Nomor Rekening">
        <i class="fas fa-copy"></i>
    </button>
</div>
<!-- JS: clipboard copy menggunakan navigator.clipboard.writeText() + SweetAlert Toast konfirmasi salin -->
```

### Komponen Drag & Drop Upload
```html
<div class="upload-area border-dashed rounded-3 p-4 text-center" id="dropZone">
    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
    <p class="mb-1 fw-semibold">Drag & Drop bukti transfer di sini</p>
    <p class="text-muted small">atau klik untuk pilih file</p>
    <input type="file" id="proofFile" name="payment_proof" class="d-none" 
           accept="image/*,.pdf">
    <img id="previewImg" class="mt-3 rounded d-none" style="max-height:200px;">
</div>
```

### Status Badge
```html
@switch($status)
    @case('pending')
        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu</span>
        @break
    @case('confirmed')
        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Dikonfirmasi</span>
        @break
    @case('rejected')
        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
        @break
@endswitch
```

---

## 🔐 Autentikasi & Permission (Spatie)

### Setup
```php
// Seeder: DatabaseSeeder.php
Role::create(['name' => 'admin']);
Role::create(['name' => 'user']);

// Admin default
$admin = User::create([...]);
$admin->assignRole('admin');
```

### Middleware
```php
// Lindungi route admin
Route::middleware(['auth', 'role:admin'])

// Lindungi route user
Route::middleware(['auth', 'role:user'])
```

### Register (hanya untuk user)
```php
// AuthController@register
$user = User::create([...]);
$user->assignRole('user'); // selalu role user
```

### Redirect setelah login
```php
// AuthController@login
if ($user->hasRole('admin')) {
    return redirect()->route('admin.dashboard');
}
return redirect()->route('user.tickets.index');
```

### Jika belum login (middleware redirect + SweetAlert)
```php
// Middleware atau di controller
if (!auth()->check()) {
    session()->flash('swal_login_required', true);
    return redirect()->route('login');
}
```
```blade
{{-- partials/alerts.blade.php --}}
@if(session('swal_login_required'))
<script>
Swal.fire({
    icon: 'warning',
    title: 'Login Diperlukan',
    text: 'Silakan login terlebih dahulu untuk melanjutkan.',
    confirmButtonText: 'Login Sekarang',
    confirmButtonColor: '#1a6b4a'
}).then((result) => {
    if (result.isConfirmed) {
        window.location.href = '{{ route("login") }}';
    }
});
</script>
@endif
```

---

## 🖥️ Admin Dashboard

### Widget Statistik
```
┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐
│  Total Tiket    │  │ Penjualan Tiket │  │  Total Booking  │  │ Pendapatan Total│
│  Terjual        │  │  (bulan ini)    │  │  (bulan ini)    │  │  (bulan ini)    │
└─────────────────┘  └─────────────────┘  └─────────────────┘  └─────────────────┘
```

### Grafik (Chart.js)
1. **Line Chart** — Penjualan tiket per bulan (12 bulan terakhir)
2. **Bar Chart** — Booking tempat per bulan (12 bulan terakhir)
3. **Doughnut Chart** — Perbandingan status pesanan (pending/confirmed/rejected)

```javascript
// @push('scripts') di admin/dashboard.blade.php
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'Tiket Terjual',
            data: @json($ticketData),
            borderColor: '#1a6b4a',
            backgroundColor: 'rgba(26,107,74,0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'top' } } }
});
```

---

## 📊 Admin Tables (DataTables + Pagination)

### Contoh implementasi di setiap tabel admin:
```blade
{{-- @push('scripts') --}}
<script>
$(document).ready(function() {
    $('#tableTicketOrders').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, 'desc']],
        columnDefs: [
            { orderable: false, targets: -1 } // kolom aksi tidak bisa diurutkan
        ]
    });
});
</script>
```

Semua tabel admin menggunakan:
- `id="tableXxx"` → diinisialisasi DataTables
- Fitur search bawaan DataTables
- Pagination otomatis DataTables
- Bahasa Indonesia (`i18n/id.json`)

---

## 🎫 Template PDF Tiket

```blade
{{-- resources/views/pdf/ticket.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        .ticket-box { border: 2px dashed #1a6b4a; border-radius: 12px; padding: 20px; }
        .header { background: #1a6b4a; color: white; text-align: center; padding: 15px; }
        .qr-section { text-align: center; margin: 20px 0; }
        .ticket-code { font-size: 24px; font-weight: bold; letter-spacing: 4px; }
        .info-row { display: flex; justify-content: space-between; margin: 8px 0; }
        .watermark { position: fixed; opacity: 0.05; font-size: 60px; top: 40%; left: 20%; transform: rotate(-45deg); }
    </style>
</head>
<body>
    <div class="watermark">BANYU BIRU</div>
    <div class="ticket-box">
        <div class="header">
            <h2>🌊 BANYU BIRU</h2>
            <p>Pemandian Air Panas Nganjuk</p>
        </div>
        <div class="qr-section">
            {!! QrCode::size(150)->generate($item->ticket_code) !!}
            <div class="ticket-code mt-2">{{ $item->ticket_code }}</div>
        </div>
        <div class="info-row">
            <span>Nama Pemesan</span>
            <span>{{ $order->user->name }}</span>
        </div>
        <div class="info-row">
            <span>Jenis Tiket</span>
            <span>{{ $item->ticket->name }}</span>
        </div>
        <div class="info-row">
            <span>Tanggal Kunjungan</span>
            <span>{{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
        <div class="info-row">
            <span>Harga</span>
            <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
        </div>
        <p class="text-center text-muted small mt-3">
            Tunjukkan tiket ini kepada petugas. Tiket hanya berlaku 1x.
        </p>
    </div>
</body>
</html>
```

---

## 🔍 Check Tiket & Booking (Admin)

### Check Tiket (`/admin/check/ticket`)
- Input manual kode format `AT-XXXXX`
- **ATAU** scan QR Code menggunakan kamera (`html5-qrcode`)
- Jika ditemukan → tampilkan detail tiket + status (valid/sudah dipakai)
- Konfirmasi "Tandai sebagai dipakai" → SweetAlert confirm → update `is_used = 1`

### Check Booking (`/admin/check/booking`)
- Input manual kode format `AB-XXXXX`
- Jika ditemukan → tampilkan detail booking + status
- Admin bisa konfirmasi/tolak dari halaman ini

### Format Kode Generator
```php
// Helper function
function generateUniqueCode(string $prefix, string $model): string
{
    do {
        $code = $prefix . '-' . strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5));
    } while ($model::where('order_code', $code)->exists() 
          || $model::where('ticket_code', $code)->exists());
    return $code;
}

// Contoh: AT-A2B9C, AB-X7Y3Z
```

---

## 🧪 SweetAlert Conventions

```javascript
// Konfirmasi aksi
Swal.fire({
    title: 'Konfirmasi',
    text: 'Apakah Anda yakin?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Lanjutkan',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#1a6b4a',
    cancelButtonColor: '#6c757d'
})

// Sukses
Swal.fire({ icon: 'success', title: 'Berhasil!', text: '...', timer: 2500, showConfirmButton: false })

// Error
Swal.fire({ icon: 'error', title: 'Gagal!', text: '...' })

// Toast notifikasi salin
Swal.fire({
    toast: true, position: 'top-end', icon: 'success',
    title: 'Nomor rekening berhasil disalin!',
    showConfirmButton: false, timer: 2000
})

// Warning login
Swal.fire({ icon: 'warning', title: 'Login Diperlukan', text: 'Silakan login terlebih dahulu.' })

// Warning tanggal sudah dibooking
Swal.fire({ icon: 'warning', title: 'Tanggal Tidak Tersedia', text: 'Tanggal ini sudah dibooking. Silakan pilih tanggal lain.' })
```

---

## 📁 Struktur Controller

```
app/Http/Controllers/
├── AuthController.php
├── User/
│   ├── TicketController.php
│   ├── BookingController.php
│   └── ProfileController.php
└── Admin/
    ├── DashboardController.php
    ├── TicketController.php
    ├── TicketOrderController.php
    ├── BookingController.php
    ├── AdminController.php
    ├── ProfileController.php
    └── CheckController.php
```

---

## 🌱 Seeder & Default Data

```php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    // Roles
    Role::create(['name' => 'admin', 'guard_name' => 'web']);
    Role::create(['name' => 'user',  'guard_name' => 'web']);

    // Admin default
    $admin = User::create([
        'name'     => 'Administrator',
        'email'    => 'admin@banyubiru.com',
        'password' => Hash::make('password'),
    ]);
    $admin->assignRole('admin');

    // Tiket default
    Ticket::insert([
        ['name' => 'Dewasa',    'price' => 15000, 'quota_per_day' => 200],
    ]);

    // Tempat default
    Place::insert([
        ['name' => 'Pendopo',   'price_per_day' => 500000,  'capacity' => 50],
    ]);

    // Bank account default
    BankAccount::create([
        'bank_name'      => 'BRI',
        'account_number' => '1234567890',
        'account_name'   => 'Banyu Biru Nganjuk',
        'is_active'      => 1,
    ]);
}
```

---

## ⚙️ Environment & Config

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wisata_web
DB_USERNAME=root
DB_PASSWORD=

```

```php
// config/app.php
'locale' => 'id',
'timezone' => 'Asia/Jakarta',
```

---

## 📌 Catatan Penting

1. **Unique constraint booking**: `UNIQUE(place_id, booking_date)` diterapkan di database dan dicek ulang di Controller sebelum insert.
2. **QR Code** dibuat saat order dibuat (bukan saat download), disimpan di `storage/app/public/qrcodes/`.
3. **PDF Tiket** dibuat on-demand saat user klik "Download" menggunakan `dompdf`.
4. **File upload bukti transfer** disimpan di `storage/app/public/payment-proofs/` dan bisa diakses admin.
5. **Pagination DataTables** sepenuhnya client-side (data sudah di-load ke halaman). Untuk data sangat besar bisa beralih ke server-side DataTables.
6. **Role admin tidak bisa diregister** — hanya dibuat melalui seeder atau panel Manajemen Admin (oleh admin yang sudah ada).
7. **Salin nomor rekening** menggunakan `navigator.clipboard.writeText()` dengan fallback `document.execCommand('copy')`.
8. Seluruh **konfirmasi destruktif** (tolak, hapus, dll) harus melewati SweetAlert confirm dialog terlebih dahulu.

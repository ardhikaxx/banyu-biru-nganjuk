# 🎫 Banyu Biru Ticketing & Booking System

<p align="center">
  <a href="#-fitur-utama">
    <img src="https://img.shields.io/badge/Features-✨-FF6B6B?style=for-the-badge" alt="Features">
  </a>
  <a href="#-teknologi-yang-digunakan">
    <img src="https://img.shields.io/badge/Tech Stack-🛠️-4ECDC4?style=for-the-badge" alt="Tech Stack">
  </a>
  <a href="#-instalasi">
    <img src="https://img.shields.io/badge/Installation-🚀-45B7D1?style=for-the-badge" alt="Installation">
  </a>
  <a href="#-dokumentasi">
    <img src="https://img.shields.io/badge/Documentation-📄-96CEB4?style=for-the-badge" alt="Documentation">
  </a>
  <a href="#-license">
    <img src="https://img.shields.io/badge/License-MIT-FFEAA7?style=for-the-badge" alt="License">
  </a>
</p>

---

## 📋 Table of Contents

- [🎯 Tentang Sistem](#-tentang-sistem)
- [✨ Fitur Utama](#-fitur-utama)
  - [👥 Fitur User](#-fitur-user-pengunjung)
  - [🔐 Fitur Admin](#-fitur-admin)
- [🛠️ Teknologi yang Digunakan](#️-teknologi-yang-digunakan)
- [📋 Persyaratan Sistem](#-persyaratan-sistem)
- [🚀 Instalasi](#-instalasi)
- [👤 Default Login](#-default-login)
- [📁 Struktur Folder](#-struktur-folder)
- [🎨 Tema & Desain](#-tema--desain)
- [📊 Database Schema](#-database-schema)
- [🔐 Keamanan](#-keamanan)
- [📱 Fitur QR Code](#-fitur-qr-code)
- [🔄 Workflow Sistem](#-workflow-sistem)
- [🐛 Troubleshooting](#-troubleshooting)
- [🤝 Kontribusi](#-kontribusi)
- [📝 License](#-license)
- [👨‍💻 Developer](#-developer)
- [📞 Kontak & Support](#-kontak--support)
- [🙏 Acknowledgments](#-acknowledgments)

---

## 🎯 Tentang Sistem

<table>
<tr>
<td>

**Banyu Biru Ticketing & Booking System** adalah sistem manajemen tiket dan booking berbasis web untuk objek wisata Banyu Biru di Nganjuk. Sistem ini memudahkan pengunjung untuk membeli tiket masuk dan melakukan booking pendopo secara online, serta membantu admin dalam mengelola transaksi dan verifikasi pembayaran.

</td>
</tr>
</table>

### 🎯 Tujuan Sistem

| Tujuan | Deskripsi |
|--------|-----------|
| 🚀 | Digitalisasi proses pembelian tiket dan booking pendopo |
| 💳 | Mempermudah pengunjung dalam melakukan transaksi online |
| 📈 | Meningkatkan efisiensi pengelolaan transaksi oleh admin |
| 📱 | Menyediakan sistem verifikasi tiket dengan QR code |
| 📊 | Memberikan laporan statistik penjualan real-time |

---

## ✨ Fitur Utama

### 👥 Fitur User (Pengunjung)

#### 🎟️ Pembelian Tiket

| Fitur | Deskripsi |
|-------|-----------|
| 📋 | Lihat daftar tiket yang tersedia dengan harga |
| 📅 | Pilih tanggal kunjungan dan jumlah tiket |
| 📲 | Generate QR code otomatis untuk setiap tiket |
| 💰 | Upload bukti pembayaran transfer |
| 📄 | Download tiket dalam format PDF setelah dikonfirmasi |
| 🖨️ | Print tiket langsung dari browser |

#### 🏛️ Booking Pendopo

| Fitur | Deskripsi |
|-------|-----------|
| 📆 | Cek ketersediaan tanggal booking secara real-time |
| 📝 | Form booking dengan data pengunjung lengkap |
| 💳 | Upload bukti pembayaran booking |
| 📊 | Lihat status booking (pending/confirmed/rejected) |
| 🔔 | Notifikasi status verifikasi |

#### 📜 Riwayat Transaksi

| Fitur | Deskripsi |
|-------|-----------|
| 📋 | Lihat riwayat pembelian tiket |
| 📑 | Lihat riwayat booking pendopo |
| 🔍 | Filter berdasarkan status transaksi |
| ⬇️ | Download ulang tiket yang sudah dikonfirmasi |

#### 👤 Manajemen Profil

| Fitur | Deskripsi |
|-------|-----------|
| ✏️ | Edit profil (nama, email, telepon, alamat) |
| 🔑 | Ubah password dengan verifikasi password lama |
| 👁️ | Lihat informasi akun |

---

### 🔐 Fitur Admin

#### 📊 Dashboard

| Fitur | Deskripsi |
|-------|-----------|
| 🎫 | Statistik total tiket terjual (confirmed) |
| 💵 | Penjualan bulan ini (tiket + booking) |
| 💰 | Total pendapatan dari transaksi terkonfirmasi |
| 📈 | Chart penjualan 6 bulan terakhir |
| 📋 | Daftar order dan booking terbaru |

#### ✅ Verifikasi Pembayaran

| Fitur | Deskripsi |
|-------|-----------|
| 📋 | Lihat daftar order tiket dengan status |
| 🔎 | Lihat detail order dan bukti pembayaran |
| ✓️ | Konfirmasi pembayaran tiket |
| ❌ | Tolak pembayaran dengan alasan |
| ✔️ | Verifikasi pembayaran booking |

#### 📱 QR Scanner Verifikasi Tiket

| Fitur | Deskripsi |
|-------|-----------|
| 📷 | Scan QR code tiket menggunakan kamera |
| ⌨️ | Input manual kode tiket |
| 🔒 | Verifikasi validitas tiket |
| ✓️ | Tandai tiket sebagai sudah dipakai |
| 📊 | Cek status tiket (valid/sudah dipakai) |

#### 🎫 Manajemen Tiket

| Fitur | Deskripsi |
|-------|-----------|
| ➕ | CRUD tiket (Create, Read, Update, Delete) |
| 💵 | Set harga tiket |
| 🔄 | Toggle status aktif/nonaktif tiket |
| 📝 | Deskripsi tiket |

#### 🏦 Manajemen Rekening Bank

| Fitur | Deskripsi |
|-------|-----------|
| ➕ | CRUD rekening bank untuk pembayaran |
| 🔄 | Set rekening aktif/nonaktif |
| 👁️ | Tampilkan rekening di halaman pembayaran user |

#### 👨‍💼 Manajemen Admin

| Fitur | Deskripsi |
|-------|-----------|
| ➕ | CRUD akun admin |
| 👥 | Assign role admin ke user |
| ✏️ | Edit profil admin |
| 🔑 | Ubah password admin |

---

## 🛠️ Teknologi yang Digunakan

### Backend
<div align="center">

| Technology | Description |
|------------|-------------|
| <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" height="25"> | PHP Framework |
| <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" height="25"> | Programming Language |
| <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" height="25"> | Database |
| <img src="https://img.shields.io/badge/Spatie-0052CC?style=for-the-badge" height="25"> | Role & Permission |

</div>

### Frontend
<div align="center">

| Technology | Description |
|------------|-------------|
| <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" height="25"> | CSS Framework |
| <img src="https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge&logo=chart.js&logoColor=white" height="25"> | Data Visualization |
| <img src="https://img.shields.io/badge/SweetAlert2-FF6B6B?style=for-the-badge" height="25"> | Beautiful Alerts |
| <img src="https://img.shields.io/badge/Font_Awesome-6-528DD7?style=for-the-badge&logo=font-awesome&logoColor=white" height="25"> | Icons |
| <img src="https://img.shields.io/badge/html5--qrcode-000000?style=for-the-badge" height="25"> | QR Code Scanner |

</div>

### Libraries & Tools
<div align="center">

| Library | Description |
|---------|-------------|
| 🔲 SimpleSoftwareIO/simple-qrcode | QR Code Generator |
| 📄 Barryvdh/laravel-dompdf | PDF Generator |
| 🔐 Laravel Breeze | Authentication Scaffolding |

</div>

---

## 📋 Persyaratan Sistem

| Requirement | Description |
|-------------|-------------|
| 🟢 | PHP >= 8.2 |
| 📦 | Composer |
| 🗄️ | MySQL >= 8.0 |
| 📦 | Node.js & NPM (untuk asset compilation) |
| 🌐 | Web Server (Apache/Nginx) |

### 📦 PHP Extensions Required
```
BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, GD
```

---

## 🚀 Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/ardhikaxx/banyu-biru-nganjuk.git
cd banyu-biru-nganjuk
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install
```

### 3️⃣ Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wisata_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Migrasi Database
```bash
php artisan migrate
```

### 5️⃣ Seed Data (Opsional)
```bash
php artisan db:seed
```

### 6️⃣ Compile Assets
```bash
npm run build
# atau untuk development
npm run dev
```

### 7️⃣ Storage Link
```bash
php artisan storage:link
```

### 8️⃣ Jalankan Server
```bash
php artisan serve
```

> 🌐 **Akses**: `http://127.0.0.1:8000`

---

## 👤 Default Login

| Role | Email | Password |
|------|-------|----------|
| 🔴 Admin | admin@banyubiru.com | password |
| 🔵 User 1 | pengguna1@banyubiru.test | password |
| 🔵 User 2 | pengguna2@banyubiru.test | password |
| ... | ... | ... |
| 🔵 User 8 | pengguna8@banyubiru.test | password |

> ⚠️ **Penting**: Ubah password default setelah login pertama kali!

---

## 📁 Struktur Folder

```
📂 wisata-web/
├── 📂 app/
│   ├── 📂 Http/Controllers/
│   │   ├── 📂 Admin/          # Controller untuk admin
│   │   ├── 📂 User/           # Controller untuk user
│   │   └── AuthController.php
│   ├── 📂 Models/             # Eloquent Models
│   └── 📂 Support/            # Helper functions
├── 📂 database/
│   ├── 📂 migrations/         # Database migrations
│   └── 📂 seeders/           # Database seeders
├── 📂 public/
│   ├── 📂 css/                # Compiled CSS
│   ├── 📂 images/             # Static images
│   ├── 📂 payment-proofs/     # Bukti pembayaran
│   └── 📂 qrcodes/            # Generated QR codes
├── 📂 resources/
│   ├── 📂 css/                # Source CSS
│   ├── 📂 js/                 # Source JavaScript
│   └── 📂 views/              # Blade templates
│       ├── 📂 admin/          # Admin views
│       ├── 📂 auth/           # Auth views
│       ├── 📂 user/           # User views
│       ├── 📂 layouts/        # Layout templates
│       └── 📂 partials/      # Reusable components
├── 📂 routes/
│   └── web.php               # Web routes
├── 📂 flowcharts/            # Flowchart documentation
├── 📄 database.md            # Database documentation
├── 📄 usecase.md             # Use case documentation
└── 📄 activity-diagram.md    # Activity diagram documentation
```

---

## 🎨 Tema & Desain

### 🎨 Color Palette

| Color | Hex Code | Usage |
|-------|----------|-------|
| 🟦 Primary | `#0f766e` | Main buttons, headers |
| 🟦 Secondary | `#14b8a6` | Accents, highlights |
| 🟩 Accent | `#5eead4` | Hover states |
| ⬜ Background | `#f0fdfa` | Page background |

### ✨ UI/UX Features

- 📱 **Responsive** - Mobile, tablet, dan desktop
- 🌙 **Dark Sidebar** - Dengan gradient teal
- 🃏 **Modern Cards** - Dengan border teal
- 🔘 **Rounded Buttons** - Desain modern
- ✨ **Animations** - Smooth transitions
- 🔔 **SweetAlert** - Konfirmasi yang indah
- 👁️ **Password Toggle** - Show/hide password
- ⏳ **Loading States** - User feedback

---

## 📊 Database Schema

### 📋 Tabel Utama

| No | Tabel | Deskripsi |
|----|-------|-----------|
| 1 | `users` | Data user dan admin |
| 2 | `tickets` | Master data tiket |
| 3 | `ticket_orders` | Order pembelian tiket |
| 4 | `ticket_order_items` | Detail tiket per order |
| 5 | `bookings` | Data booking pendopo |
| 6 | `places` | Master data tempat (pendopo) |
| 7 | `bank_accounts` | Rekening bank untuk pembayaran |
| 8 | `roles & permissions` | Role-based access control |

> 📖 **Lihat dokumentasi lengkap**: [database.md](database.md)

---

## 🔐 Keamanan

| Feature | Description |
|---------|-------------|
| 🔒 | Password hashing menggunakan bcrypt |
| 🛡️ | CSRF protection pada semua form |
| 👥 | Role-based authorization (admin/user) |
| ✅ | Input validation & sanitization |
| 🗄️ | SQL injection protection (Eloquent ORM) |
| 🚫 | XSS protection |
| 📁 | File upload validation (type & size) |
| ⏰ | Session management |

---

## 📱 Fitur QR Code

### 🔲 Generate QR Code

| Feature | Description |
|---------|-------------|
| ⚡ | Otomatis generate saat pembelian tiket |
| 📐 | Format: SVG (scalable) |
| 🔢 | Berisi kode tiket unik (AT-XXXXX) |
| 📁 | Disimpan di `/public/qrcodes/` |

### 📷 Scan QR Code

| Feature | Description |
|---------|-------------|
| 📷 | Menggunakan library html5-qrcode |
| 📸 | Akses kamera untuk scanning |
| 🤖 | Auto-detect dan submit |
| ⌨️ | Fallback: input manual kode tiket |

---

## 🔄 Workflow Sistem

### 📈 Alur Pembelian Tiket

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│  Login   │───▶│  Pilih   │───▶│  Jumlah  │───▶│ Generate │
│          │    │  Tiket   │    │  Tiket   │    │   QR     │
└──────────┘    └──────────┘    └──────────┘    └──────────┘
                                                      │
                                                      ▼
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│ Download │◀───│ Verified │◀───│ Upload   │◀───│  Payment │
│  Tiket   │    │   (✓)    │    │  Bukti   │    │          │
└──────────┘    └──────────┘    └──────────┘    └──────────┘
```

### 🏛️ Alur Booking Pendopo

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│  Login   │───▶│  Cek     │───▶│   Isi    │───▶│  Upload  │
│          │    │Ketersediaan│  │  Form    │    │  Bukti   │
└──────────┘    └──────────┘    └──────────┘    └──────────┘
                                                      │
                                                      ▼
                   ┌──────────┐    ┌──────────┐    ┌──────────┐
                   │ Booking  │◀───│ Verified │◀───│ Admin    │
                   │Confirmed │    │   (✓)    │    │ Verifikasi│
                   └──────────┘    └──────────┘    └──────────┘
```

### 📷 Alur Verifikasi Tiket

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│   Scan   │───▶│  Cek     │───▶│ Tampilkan│───▶│ Tandai   │
│    QR    │    │ Validitas│    │  Info    │    │ Dipakai  │
└──────────┘    └──────────┘    └──────────┘    └──────────┘
```

---

## 🐛 Troubleshooting

### ❌ Error: Class "SimpleSoftwareIO\QrCode\Facades\QrCode" not found
```bash
composer require simplesoftwareio/simple-qrcode
```

### ❌ Error: Storage link not found
```bash
php artisan storage:link
```

### ❌ Error: Permission denied pada folder storage
```bash
chmod -R 775 storage bootstrap/cache
```

### 📷 QR Scanner tidak bisa akses kamera
- ✅ Pastikan browser memiliki izin akses kamera
- ✅ Gunakan HTTPS (atau localhost)
- ✅ Coba browser lain (Chrome/Firefox)

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

```
1. 🍴 Fork repository ini
2. 🌿 Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. 💾 Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. 📤 Push ke branch (`git push origin feature/AmazingFeature'`)
5. 🔀 Buat Pull Request
```

---

## 📝 License

<p align="center">
  <img src="https://img.shields.io/badge/License-MIT-FF6B6B?style=for-the-badge" alt="License">
</p>

<p align="center">
  Sistem ini menggunakan framework Laravel yang berlisensi 
  <a href="https://opensource.org/licenses/MIT">MIT license</a>
</p>

---

## 👨‍💻 Developer

<div align="center">

| | |
|:---:|:---|
| **Ardhika** | |
| 🔗 | [GitHub](https://github.com/ardhikaxx) |
| 📦 | [Repository](https://github.com/ardhikaxx/banyu-biru-nganjuk) |

</div>

---

## 📞 Kontak & Support

Jika ada pertanyaan atau masalah, silakan:

| Contact | Link |
|---------|------|
| 🐛 | [Buat Issue](https://github.com/ardhikaxx/banyu-biru-nganjuk/issues) |
| 📧 | [Email](mailto:email@example.com) |

---

## 🙏 Acknowledgments

<div align="center">

| Thanks To | Description |
|-----------|-------------|
| 🦁 | Laravel Framework |
| 🎨 | Bootstrap Team |
| 🔰 | Font Awesome |
| 📊 | Chart.js |
| 🔔 | SweetAlert2 |
| 🔲 | SimpleSoftwareIO QR Code |
| 📷 | html5-qrcode Library |

</div>

---

<p align="center">
  <img src="https://komarev.com/ghpvc/?username=ardhikaxx&label=Views&color=0f766e&style=flat" alt="Views">
</p>

<p align="center">
  <strong>Made with ❤️ for Banyu Biru Nganjuk</strong>
</p>

<p align="center">
  <strong>© 2026 Banyu Biru Ticketing & Booking System</strong>
</p>

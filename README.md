# 🎫 Banyu Biru Ticketing & Booking System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
</p>

## 📖 Tentang Sistem

**Banyu Biru Ticketing & Booking System** adalah sistem manajemen tiket dan booking berbasis web untuk objek wisata Banyu Biru di Nganjuk. Sistem ini memudahkan pengunjung untuk membeli tiket masuk dan melakukan booking pendopo secara online, serta membantu admin dalam mengelola transaksi dan verifikasi pembayaran.

### 🎯 Tujuan Sistem
- Digitalisasi proses pembelian tiket dan booking pendopo
- Mempermudah pengunjung dalam melakukan transaksi online
- Meningkatkan efisiensi pengelolaan transaksi oleh admin
- Menyediakan sistem verifikasi tiket dengan QR code
- Memberikan laporan statistik penjualan real-time

---

## ✨ Fitur Utama

### 👥 Fitur User (Pengunjung)

#### 🎟️ Pembelian Tiket
- Lihat daftar tiket yang tersedia dengan harga
- Pilih tanggal kunjungan dan jumlah tiket
- Generate QR code otomatis untuk setiap tiket
- Upload bukti pembayaran transfer
- Download tiket dalam format PDF setelah dikonfirmasi
- Print tiket langsung dari browser

#### 🏛️ Booking Pendopo
- Cek ketersediaan tanggal booking secara real-time
- Form booking dengan data pengunjung lengkap
- Upload bukti pembayaran booking
- Lihat status booking (pending/confirmed/rejected)
- Notifikasi status verifikasi

#### 📜 Riwayat Transaksi
- Lihat riwayat pembelian tiket
- Lihat riwayat booking pendopo
- Filter berdasarkan status transaksi
- Download ulang tiket yang sudah dikonfirmasi

#### 👤 Manajemen Profil
- Edit profil (nama, email, telepon, alamat)
- Ubah password dengan verifikasi password lama
- Lihat informasi akun

### 🔐 Fitur Admin

#### 📊 Dashboard
- Statistik total tiket terjual (confirmed)
- Penjualan bulan ini (tiket + booking)
- Total pendapatan dari transaksi terkonfirmasi
- Chart penjualan 6 bulan terakhir
- Daftar order dan booking terbaru

#### ✅ Verifikasi Pembayaran
- Lihat daftar order tiket dengan status
- Lihat detail order dan bukti pembayaran
- Konfirmasi pembayaran tiket
- Tolak pembayaran dengan alasan
- Verifikasi pembayaran booking

#### 📱 QR Scanner Verifikasi Tiket
- Scan QR code tiket menggunakan kamera
- Input manual kode tiket
- Verifikasi validitas tiket
- Tandai tiket sebagai sudah dipakai
- Cek status tiket (valid/sudah dipakai)

#### 🎫 Manajemen Tiket
- CRUD tiket (Create, Read, Update, Delete)
- Set harga tiket
- Toggle status aktif/nonaktif tiket
- Deskripsi tiket

#### 🏦 Manajemen Rekening Bank
- CRUD rekening bank untuk pembayaran
- Set rekening aktif/nonaktif
- Tampilkan rekening di halaman pembayaran user

#### 👨‍💼 Manajemen Admin
- CRUD akun admin
- Assign role admin ke user
- Edit profil admin
- Ubah password admin

---

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 11.x** - PHP Framework
- **PHP 8.2+** - Programming Language
- **MySQL 8.0+** - Database
- **Spatie Laravel Permission** - Role & Permission Management

### Frontend
- **Bootstrap 5.3** - CSS Framework
- **Chart.js** - Data Visualization
- **SweetAlert2** - Beautiful Alerts
- **Font Awesome 6** - Icons
- **html5-qrcode** - QR Code Scanner

### Libraries & Tools
- **SimpleSoftwareIO/simple-qrcode** - QR Code Generator
- **Barryvdh/laravel-dompdf** - PDF Generator
- **Laravel Breeze** - Authentication Scaffolding

---

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM (untuk asset compilation)
- Web Server (Apache/Nginx)
- Extension PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, GD

---

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/ardhikaxx/banyu-biru-nganjuk.git
cd banyu-biru-nganjuk
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
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

### 4. Migrasi Database
```bash
php artisan migrate
```

### 5. Seed Data (Opsional)
```bash
php artisan db:seed
```

### 6. Compile Assets
```bash
npm run build
# atau untuk development
npm run dev
```

### 7. Storage Link
```bash
php artisan storage:link
```

### 8. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000`

---

## 👤 Default Login

### Admin
- **Email**: admin@example.com
- **Password**: password

### User
- **Email**: user@example.com
- **Password**: password

> ⚠️ **Penting**: Ubah password default setelah login pertama kali!

---

## 📁 Struktur Folder

```
wisata-web/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controller untuk admin
│   │   ├── User/           # Controller untuk user
│   │   └── AuthController.php
│   ├── Models/             # Eloquent Models
│   └── Support/            # Helper functions
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── public/
│   ├── css/                # Compiled CSS
│   ├── images/             # Static images
│   ├── payment-proofs/     # Bukti pembayaran
│   └── qrcodes/            # Generated QR codes
├── resources/
│   ├── css/                # Source CSS
│   ├── js/                 # Source JavaScript
│   └── views/              # Blade templates
│       ├── admin/          # Admin views
│       ├── auth/           # Auth views
│       ├── user/           # User views
│       ├── layouts/        # Layout templates
│       └── partials/       # Reusable components
├── routes/
│   └── web.php             # Web routes
├── flowcharts/             # Flowchart documentation
├── database.md             # Database documentation
├── usecase.md              # Use case documentation
└── activity-diagram.md     # Activity diagram documentation
```

---

## 🎨 Tema & Desain

Sistem menggunakan tema **Teal Modern** dengan palet warna:
- **Primary**: #0f766e (Teal 700)
- **Secondary**: #14b8a6 (Teal 500)
- **Accent**: #5eead4 (Teal 300)
- **Background**: #f0fdfa (Teal 50)

### Fitur UI/UX
- Responsive design (mobile, tablet, desktop)
- Dark sidebar dengan gradient teal
- Modern card design dengan border teal
- Rounded-full buttons
- Smooth animations & transitions
- SweetAlert untuk konfirmasi
- Password toggle (show/hide)
- Loading states

---

## 📊 Database Schema

Sistem menggunakan 8 tabel utama:

1. **users** - Data user dan admin
2. **tickets** - Master data tiket
3. **ticket_orders** - Order pembelian tiket
4. **ticket_order_items** - Detail tiket per order
5. **bookings** - Data booking pendopo
6. **places** - Master data tempat (pendopo)
7. **bank_accounts** - Rekening bank untuk pembayaran
8. **roles & permissions** - Role-based access control

Lihat dokumentasi lengkap di [database.md](database.md)

---

## 🔐 Keamanan

- Password hashing menggunakan bcrypt
- CSRF protection pada semua form
- Role-based authorization (admin/user)
- Input validation & sanitization
- SQL injection protection (Eloquent ORM)
- XSS protection
- File upload validation (type & size)
- Session management

---

## 📱 Fitur QR Code

### Generate QR Code
- Otomatis generate saat pembelian tiket
- Format: SVG (scalable)
- Berisi kode tiket unik (AT-XXXXX)
- Disimpan di `/public/qrcodes/`

### Scan QR Code
- Menggunakan library html5-qrcode
- Akses kamera untuk scanning
- Auto-detect dan submit
- Fallback: input manual kode tiket

---

## 📄 Dokumentasi

### Flowchart
Dokumentasi flowchart lengkap untuk setiap fitur tersedia di folder `flowcharts/`:
- [Auth Flowchart](flowcharts/auth-flowchart.md)
- [Ticket Purchase Flowchart](flowcharts/ticket-purchase-flowchart.md)
- [Booking Flowchart](flowcharts/booking-flowchart.md)
- [Payment Verification Flowchart](flowcharts/payment-verification-flowchart.md)
- [QR Scanner Flowchart](flowcharts/qr-scanner-flowchart.md)
- Dan lainnya...

### Use Case Diagram
Dokumentasi use case dengan 3 actor dan 30 use cases: [usecase.md](usecase.md)

### Activity Diagram
Dokumentasi activity diagram untuk 5 proses utama: [activity-diagram.md](activity-diagram.md)

### Database Schema
Dokumentasi struktur database lengkap: [database.md](database.md)

---

## 🔄 Workflow Sistem

### Alur Pembelian Tiket
1. User login/register
2. Pilih tiket dan tanggal kunjungan
3. Tentukan jumlah tiket
4. Sistem generate order dan QR code
5. User upload bukti pembayaran
6. Admin verifikasi pembayaran
7. User download tiket (jika confirmed)

### Alur Booking Pendopo
1. User login/register
2. Cek ketersediaan tanggal
3. Isi form booking
4. Upload bukti pembayaran
5. Admin verifikasi pembayaran
6. Booking confirmed/rejected

### Alur Verifikasi Tiket
1. Admin scan QR code tiket
2. Sistem cek validitas tiket
3. Tampilkan informasi tiket
4. Admin tandai sebagai dipakai
5. Tiket tidak dapat digunakan lagi

---

## 🐛 Troubleshooting

### Error: Class "SimpleSoftwareIO\QrCode\Facades\QrCode" not found
```bash
composer require simplesoftwareio/simple-qrcode
```

### Error: Storage link not found
```bash
php artisan storage:link
```

### Error: Permission denied pada folder storage
```bash
chmod -R 775 storage bootstrap/cache
```

### QR Scanner tidak bisa akses kamera
- Pastikan browser memiliki izin akses kamera
- Gunakan HTTPS (atau localhost)
- Coba browser lain (Chrome/Firefox)

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:
1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📝 License

Sistem ini menggunakan framework Laravel yang berlisensi [MIT license](https://opensource.org/licenses/MIT).

---

## 👨‍💻 Developer

Dikembangkan oleh **Ardhika**

- GitHub: [@ardhikaxx](https://github.com/ardhikaxx)
- Repository: [banyu-biru-nganjuk](https://github.com/ardhikaxx/banyu-biru-nganjuk)

---

## 📞 Kontak & Support

Jika ada pertanyaan atau masalah, silakan:
- Buat [Issue](https://github.com/ardhikaxx/banyu-biru-nganjuk/issues) di GitHub
- Email: [email@example.com](mailto:email@example.com)

---

## 🙏 Acknowledgments

- Laravel Framework
- Bootstrap Team
- Font Awesome
- Chart.js
- SweetAlert2
- SimpleSoftwareIO QR Code
- html5-qrcode Library

---

<p align="center">
  Made with ❤️ for Banyu Biru Nganjuk
</p>

<p align="center">
  <strong>© 2026 Banyu Biru Ticketing & Booking System</strong>
</p>

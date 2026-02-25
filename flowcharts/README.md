# Flowchart Dokumentasi - Banyu Biru Ticketing & Booking System

Dokumentasi flowchart lengkap untuk setiap fitur dalam sistem. Setiap file berisi flowchart detail yang dapat digunakan untuk membuat diagram di Draw.io.

## 📋 Daftar Flowchart

### 1. Autentikasi
**File:** [auth-flowchart.md](auth-flowchart.md)

Fitur yang didokumentasikan:
- Login (User & Admin)
- Register (User Baru)
- Logout (dengan konfirmasi SweetAlert)

---

### 2. Pembelian Tiket
**File:** [ticket-purchase-flowchart.md](ticket-purchase-flowchart.md)

Fitur yang didokumentasikan:
- Lihat Daftar Tiket
- Beli Tiket (dengan generate QR code)
- Upload Bukti Pembayaran
- Download Tiket (berdasarkan status)

---

### 3. Booking Pendopo
**File:** [booking-flowchart.md](booking-flowchart.md)

Fitur yang didokumentasikan:
- Lihat Halaman Booking
- Cek Ketersediaan Tanggal (AJAX)
- Buat Booking
- Upload Bukti Pembayaran Booking
- Lihat Status Booking

---

### 4. Verifikasi Pembayaran Admin
**File:** [payment-verification-flowchart.md](payment-verification-flowchart.md)

Fitur yang didokumentasikan:
- Lihat Daftar Order Tiket
- Lihat Detail Order Tiket
- Konfirmasi Pembayaran Tiket
- Tolak Pembayaran Tiket
- Verifikasi Pembayaran Booking

---

### 5. QR Scanner Verifikasi Tiket
**File:** [qr-scanner-flowchart.md](qr-scanner-flowchart.md)

Fitur yang didokumentasikan:
- Scan QR Code Tiket (menggunakan kamera)
- Input Manual Kode Tiket
- Verifikasi Tiket
- Tandai Tiket Sebagai Dipakai

---

### 6. Manajemen Tiket Admin
**File:** [ticket-management-flowchart.md](ticket-management-flowchart.md)

Fitur yang didokumentasikan:
- Lihat Daftar Tiket
- Tambah Tiket Baru
- Edit Tiket
- Hapus Tiket
- Toggle Status Aktif Tiket

---

### 7. Manajemen Admin
**File:** [admin-management-flowchart.md](admin-management-flowchart.md)

Fitur yang didokumentasikan:
- Lihat Daftar Admin
- Tambah Admin Baru
- Edit Admin
- Hapus Admin
- Edit Profil Admin

---

### 8. Dashboard & Statistik
**File:** [dashboard-flowchart.md](dashboard-flowchart.md)

Fitur yang didokumentasikan:
- Tampilkan Dashboard Admin
- Hitung Total Tiket Terjual
- Hitung Penjualan Bulan Ini
- Hitung Total Pendapatan
- Generate Chart Penjualan
- Tampilkan Order Terbaru
- Tampilkan Booking Terbaru

---

### 9. Manajemen Rekening Bank
**File:** [bank-account-flowchart.md](bank-account-flowchart.md)

Fitur yang didokumentasikan:
- Lihat Daftar Rekening Bank
- Tambah Rekening Bank
- Edit Rekening Bank
- Hapus Rekening Bank
- Toggle Status Aktif Rekening

---

### 10. Riwayat User
**File:** [user-history-flowchart.md](user-history-flowchart.md)

Fitur yang didokumentasikan:
- Lihat Riwayat Tiket
- Lihat Riwayat Booking
- Lihat Detail Tiket dari Riwayat
- Lihat Detail Booking dari Riwayat

---

### 11. Profil User
**File:** [user-profile-flowchart.md](user-profile-flowchart.md)

Fitur yang didokumentasikan:
- Lihat Profil User
- Edit Profil User
- Ubah Password User

---

## 🎨 Panduan Umum Draw.io

### Simbol Flowchart Standar
- **Terminator (Oval)** - START/END
- **Process (Rectangle)** - Proses/aksi
- **Decision (Diamond)** - Kondisi/percabangan
- **Data (Parallelogram)** - Input/Output
- **Database (Cylinder)** - Operasi database
- **Document (Rectangle with wavy bottom)** - Form/dokumen
- **Loop (Hexagon)** - Perulangan
- **Predefined Process (Rectangle with double lines)** - Subprocess

### Palet Warna Konsisten
```
START/END:           #14B8A6 (Teal)
Process:             #E3F2FD (Biru Muda)
Decision:            #FFF59D (Kuning)
Database Operation:  #E1BEE7 (Ungu Muda)
Form:                #BBDEFB (Biru Tua Muda)
Create:              #C8E6C9 (Hijau Muda)
Update:              #B3E5FC (Biru Muda)
Delete:              #FFCDD2 (Merah Muda)
Success:             #C8E6C9 (Hijau Muda)
Error:               #FFCDD2 (Merah Muda)
Warning:             #FFF9C4 (Kuning Muda)
Loop:                #FFE0B2 (Oranye Muda)
Security Check:      #FFE0B2 (Oranye Muda)
```

### Tips Membuat Diagram
1. **Gunakan Swimlane** untuk memisahkan actor (User, Admin, System, Database)
2. **Konsisten dengan warna** untuk memudahkan identifikasi jenis proses
3. **Label yang jelas** pada setiap decision branch (YES/NO)
4. **Spacing yang rapi** antar simbol untuk readability
5. **Connector yang jelas** dengan arrow yang tepat
6. **Notes/Comments** untuk penjelasan kompleks
7. **Vertical flow** (top to bottom) untuk kemudahan membaca

### Langkah Membuat di Draw.io
1. Buka [draw.io](https://app.diagrams.net/)
2. Pilih "Create New Diagram"
3. Pilih template "Flowchart" atau "Blank"
4. Drag & drop simbol dari panel kiri
5. Gunakan connector tool untuk menghubungkan simbol
6. Atur warna sesuai panduan di atas
7. Export sebagai PNG/PDF/SVG

---

## 📊 Statistik Dokumentasi

- **Total Flowchart Files**: 11
- **Total Fitur Terdokumentasi**: 50+
- **Format**: Markdown dengan ASCII flowchart
- **Kompatibilitas**: Draw.io, Lucidchart, Visio

---

## 🔄 Update History

- **25 Februari 2026**: Pembuatan dokumentasi lengkap untuk semua fitur sistem

---

## 📝 Catatan

- Setiap flowchart sudah disesuaikan dengan implementasi aktual di kode
- Status order/booking: `pending`, `confirmed`, `rejected`
- Kode unik format: `AT-XXXXX` (tiket), `AB-XXXXX` (booking)
- Semua flowchart sudah termasuk validasi dan error handling
- Security checks sudah didokumentasikan (password hashing, authorization, dll)

---

**Sistem**: Banyu Biru Ticketing & Booking System  
**Dibuat**: 25 Februari 2026  
**Versi**: 1.0

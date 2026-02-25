# Activity Diagram - Sistem Tiket & Booking Banyu Biru

## Daftar Isi
1. [Overview](#overview)
2. [Activity Diagram 1: Proses Pembelian Tiket](#activity-diagram-1-proses-pembelian-tiket)
3. [Activity Diagram 2: Proses Verifikasi Pembayaran Tiket](#activity-diagram-2-proses-verifikasi-pembayaran-tiket)
4. [Activity Diagram 3: Proses Booking Tempat](#activity-diagram-3-proses-booking-tempat)
5. [Activity Diagram 4: Proses Verifikasi Tiket dengan QR Code](#activity-diagram-4-proses-verifikasi-tiket-dengan-qr-code)
6. [Activity Diagram 5: Proses Login](#activity-diagram-5-proses-login)
7. [Panduan Membuat Diagram di Draw.io](#panduan-membuat-diagram-di-drawio)

---

## Overview

Activity diagram menggambarkan alur aktivitas dalam sistem dari awal hingga akhir. Dokumen ini menyediakan 5 activity diagram utama yang mencakup proses bisnis penting dalam sistem.

**Notasi yang Digunakan**:
- **Initial Node** (●): Titik awal aktivitas
- **Activity** (Rounded Rectangle): Aktivitas/aksi yang dilakukan
- **Decision** (◇): Percabangan keputusan
- **Fork/Join** (Bar): Aktivitas paralel
- **Final Node** (◎): Titik akhir aktivitas
- **Swimlane**: Pembagian tanggung jawab (User, System, Admin)

---

## Activity Diagram 1: Proses Pembelian Tiket

### Deskripsi
Menggambarkan alur lengkap pembelian tiket dari user mulai dari memilih tiket hingga upload bukti pembayaran.

### Swimlanes
1. **User** - Pengguna yang membeli tiket
2. **System** - Sistem aplikasi
3. **Payment Gateway** - Sistem pembayaran (eksternal)

### Alur Aktivitas

```
[START]
│
├─ User: Login ke sistem
│
├─ System: Validasi kredensial
│
├─ Decision: Login berhasil?
│   ├─ [NO] → Tampilkan error → [END]
│   └─ [YES] ↓
│
├─ System: Tampilkan halaman pembelian tiket
│
├─ User: Pilih tanggal kunjungan
│
├─ System: Validasi tanggal
│
├─ Decision: Tanggal valid?
│   ├─ [NO] → Tampilkan error tanggal → Kembali ke pilih tanggal
│   └─ [YES] ↓
│
├─ User: Pilih jenis tiket
│
├─ User: Tentukan jumlah tiket
│
├─ System: Hitung total harga
│
├─ System: Tampilkan ringkasan pesanan
│
├─ User: Konfirmasi pesanan
│
├─ System: Generate kode order unik (AT-XXXXX)
│
├─ System: Generate QR code untuk setiap tiket
│
├─ System: Simpan data order dengan status "pending"
│
├─ System: Tampilkan halaman pembayaran
│
├─ System: Tampilkan nomor rekening bank
│
├─ User: Melakukan transfer ke rekening
│
├─ User: Upload bukti pembayaran
│
├─ System: Validasi file bukti pembayaran
│
├─ Decision: File valid?
│   ├─ [NO] → Tampilkan error format → Kembali ke upload
│   └─ [YES] ↓
│
├─ System: Simpan bukti pembayaran
│
├─ System: Update status order tetap "pending"
│
├─ System: Tampilkan halaman download tiket
│
├─ System: Tampilkan pesan "Menunggu verifikasi admin"
│
└─ [END]
```

### Decision Points
1. **Login berhasil?** - Validasi email dan password
2. **Tanggal valid?** - Cek apakah tanggal >= hari ini
3. **File valid?** - Cek format dan ukuran file

### Catatan
- QR code di-generate untuk setiap item tiket
- User bisa download tiket tapi tombol disabled sampai dikonfirmasi
- Status order: pending → menunggu verifikasi admin

---

## Activity Diagram 2: Proses Verifikasi Pembayaran Tiket

### Deskripsi
Menggambarkan alur verifikasi pembayaran tiket oleh admin.

### Swimlanes
1. **Admin** - Administrator yang memverifikasi
2. **System** - Sistem aplikasi
3. **User** - Pemilik tiket (menerima notifikasi)

### Alur Aktivitas

```
[START]
│
├─ Admin: Login ke dashboard admin
│
├─ System: Tampilkan dashboard
│
├─ Admin: Akses menu "Pesanan Tiket"
│
├─ System: Tampilkan daftar pesanan tiket
│
├─ System: Tampilkan filter status (pending/confirmed/rejected)
│
├─ Admin: Filter pesanan dengan status "pending"
│
├─ System: Tampilkan pesanan pending
│
├─ Admin: Pilih pesanan yang akan diverifikasi
│
├─ System: Tampilkan detail pesanan
│
├─ System: Tampilkan bukti pembayaran
│
├─ System: Tampilkan data user dan tiket
│
├─ Admin: Periksa bukti pembayaran
│
├─ Admin: Periksa kesesuaian nominal
│
├─ Decision: Pembayaran valid?
│   │
│   ├─ [YES] → Admin: Klik tombol "Konfirmasi"
│   │         │
│   │         ├─ System: Update status order menjadi "confirmed"
│   │         │
│   │         ├─ System: Simpan waktu konfirmasi (confirmed_at)
│   │         │
│   │         ├─ System: Simpan ID admin yang konfirmasi (confirmed_by)
│   │         │
│   │         ├─ System: Hitung ke total pendapatan
│   │         │
│   │         ├─ System: Aktifkan tombol download tiket untuk user
│   │         │
│   │         ├─ System: Tampilkan notifikasi sukses
│   │         │
│   │         └─ [END]
│   │
│   └─ [NO] → Admin: Klik tombol "Tolak"
│             │
│             ├─ System: Tampilkan form alasan penolakan
│             │
│             ├─ Admin: Isi alasan penolakan
│             │
│             ├─ Admin: Konfirmasi penolakan
│             │
│             ├─ System: Update status order menjadi "rejected"
│             │
│             ├─ System: Simpan alasan penolakan (rejection_note)
│             │
│             ├─ System: Tampilkan notifikasi penolakan
│             │
│             ├─ System: User bisa upload ulang bukti pembayaran
│             │
│             └─ [END]
```

### Decision Points
1. **Pembayaran valid?** - Admin memutuskan berdasarkan bukti transfer

### Catatan
- Admin bisa konfirmasi atau tolak pembayaran
- Jika ditolak, user bisa upload ulang bukti
- Hanya pesanan "confirmed" yang masuk ke laporan pendapatan

---

## Activity Diagram 3: Proses Booking Tempat

### Deskripsi
Menggambarkan alur booking tempat (pendopo) oleh user.

### Swimlanes
1. **User** - Pengguna yang booking
2. **System** - Sistem aplikasi

### Alur Aktivitas

```
[START]
│
├─ User: Login ke sistem
│
├─ System: Validasi kredensial
│
├─ Decision: Login berhasil?
│   ├─ [NO] → Tampilkan error → [END]
│   └─ [YES] ↓
│
├─ System: Tampilkan halaman booking
│
├─ System: Tampilkan informasi tempat (Pendopo)
│
├─ System: Tampilkan harga per hari
│
├─ User: Pilih tanggal booking
│
├─ System: Cek ketersediaan tanggal
│
├─ System: Query database untuk tanggal tersebut
│
├─ Decision: Tanggal tersedia?
│   ├─ [NO] → System: Tampilkan pesan "Tanggal sudah dibooking"
│   │         └─ Kembali ke pilih tanggal
│   └─ [YES] ↓
│
├─ Decision: Tanggal >= hari ini?
│   ├─ [NO] → System: Tampilkan error "Tanggal sudah lewat"
│   │         └─ Kembali ke pilih tanggal
│   └─ [YES] ↓
│
├─ User: Isi nama pengunjung
│
├─ User: Isi nomor telepon
│
├─ User: Isi alamat
│
├─ User: Isi catatan (opsional)
│
├─ System: Validasi data input
│
├─ Decision: Data valid?
│   ├─ [NO] → Tampilkan error validasi → Kembali ke form
│   └─ [YES] ↓
│
├─ System: Hitung total harga
│
├─ System: Tampilkan ringkasan booking
│
├─ User: Konfirmasi booking
│
├─ System: Generate kode booking unik (AB-XXXXX)
│
├─ System: Simpan data booking dengan status "pending"
│
├─ System: Block tanggal untuk booking lain
│
├─ System: Tampilkan halaman pembayaran
│
├─ System: Tampilkan nomor rekening bank
│
├─ User: Melakukan transfer
│
├─ User: Upload bukti pembayaran
│
├─ System: Validasi file
│
├─ Decision: File valid?
│   ├─ [NO] → Tampilkan error → Kembali ke upload
│   └─ [YES] ↓
│
├─ System: Simpan bukti pembayaran
│
├─ System: Tampilkan halaman status booking
│
├─ System: Tampilkan pesan "Menunggu verifikasi admin"
│
└─ [END]
```

### Decision Points
1. **Login berhasil?** - Validasi kredensial
2. **Tanggal tersedia?** - Cek di database apakah sudah dibooking
3. **Tanggal >= hari ini?** - Validasi tanggal tidak boleh masa lalu
4. **Data valid?** - Validasi form input
5. **File valid?** - Validasi bukti pembayaran

### Catatan
- Satu tempat hanya bisa dibooking 1x per tanggal
- Tanggal otomatis ter-block setelah booking dibuat
- Status awal selalu "pending"

---

## Activity Diagram 4: Proses Verifikasi Tiket dengan QR Code

### Deskripsi
Menggambarkan alur verifikasi tiket menggunakan QR code scanner di pintu masuk.

### Swimlanes
1. **Admin/Petugas** - Petugas di pintu masuk
2. **System** - Sistem aplikasi
3. **User** - Pengunjung dengan tiket

### Alur Aktivitas

```
[START]
│
├─ User: Datang ke pintu masuk dengan tiket
│
├─ Admin: Login ke sistem verifikasi
│
├─ System: Tampilkan halaman verifikasi tiket
│
├─ System: Tampilkan pilihan metode verifikasi
│
├─ Decision: Metode verifikasi?
│   │
│   ├─ [Scan QR] → System: Aktifkan kamera
│   │             │
│   │             ├─ System: Tampilkan scanner QR
│   │             │
│   │             ├─ Admin: Arahkan kamera ke QR code tiket
│   │             │
│   │             ├─ System: Baca QR code
│   │             │
│   │             ├─ System: Ekstrak kode tiket dari QR
│   │             │
│   │             └─ [Lanjut ke Validasi]
│   │
│   └─ [Input Manual] → Admin: Ketik kode tiket
│                       │
│                       ├─ System: Terima input kode
│                       │
│                       └─ [Lanjut ke Validasi]
│
├─ [Validasi]
│
├─ System: Cari tiket berdasarkan kode
│
├─ Decision: Tiket ditemukan?
│   ├─ [NO] → System: Tampilkan error "Tiket tidak ditemukan"
│   │         └─ [END]
│   └─ [YES] ↓
│
├─ System: Ambil data tiket dari database
│
├─ System: Cek status order tiket
│
├─ Decision: Order sudah dikonfirmasi?
│   ├─ [NO] → System: Tampilkan pesan "Pembayaran belum dikonfirmasi"
│   │         │
│   │         ├─ System: Tampilkan status "Pending"
│   │         │
│   │         └─ [END]
│   └─ [YES] ↓
│
├─ System: Cek status penggunaan tiket
│
├─ Decision: Tiket sudah dipakai?
│   ├─ [YES] → System: Tampilkan peringatan "Tiket sudah digunakan"
│   │          │
│   │          ├─ System: Tampilkan waktu penggunaan
│   │          │
│   │          ├─ System: Tampilkan badge merah "Sudah Dipakai"
│   │          │
│   │          └─ [END]
│   └─ [NO] ↓
│
├─ System: Tampilkan detail tiket
│
├─ System: Tampilkan data pengunjung
│
├─ System: Tampilkan tanggal kunjungan
│
├─ System: Tampilkan badge hijau "Valid"
│
├─ Admin: Verifikasi data pengunjung
│
├─ Decision: Data sesuai?
│   ├─ [NO] → Admin: Tolak masuk
│   │         └─ [END]
│   └─ [YES] ↓
│
├─ Admin: Klik tombol "Tandai Sebagai Dipakai"
│
├─ System: Update field is_used = true
│
├─ System: Simpan waktu penggunaan (used_at)
│
├─ System: Tampilkan notifikasi sukses
│
├─ System: Hide kamera scanner
│
├─ System: Tampilkan tombol "Scan Lagi"
│
├─ Admin: Izinkan pengunjung masuk
│
└─ [END]
```

### Decision Points
1. **Metode verifikasi?** - Scan QR atau input manual
2. **Tiket ditemukan?** - Cek keberadaan kode di database
3. **Order sudah dikonfirmasi?** - Cek status pembayaran
4. **Tiket sudah dipakai?** - Cek status penggunaan
5. **Data sesuai?** - Admin verifikasi manual

### Catatan
- Tiket hanya bisa dipakai 1x
- Sistem otomatis hide kamera setelah scan berhasil
- Admin bisa scan lagi dengan klik tombol "Scan Lagi"

---

## Activity Diagram 5: Proses Login

### Deskripsi
Menggambarkan alur login user dan admin ke sistem.

### Swimlanes
1. **User/Admin** - Pengguna yang login
2. **System** - Sistem aplikasi
3. **Database** - Database sistem

### Alur Aktivitas

```
[START]
│
├─ User: Akses halaman login
│
├─ System: Tampilkan form login
│
├─ User: Masukkan email
│
├─ User: Masukkan password
│
├─ User: Klik tombol "Login"
│
├─ System: Validasi format email
│
├─ Decision: Format email valid?
│   ├─ [NO] → System: Tampilkan error "Format email salah"
│   │         └─ Kembali ke form login
│   └─ [YES] ↓
│
├─ System: Validasi password tidak kosong
│
├─ Decision: Password terisi?
│   ├─ [NO] → System: Tampilkan error "Password wajib diisi"
│   │         └─ Kembali ke form login
│   └─ [YES] ↓
│
├─ System: Query database untuk email
│
├─ Database: Cari user berdasarkan email
│
├─ Decision: User ditemukan?
│   ├─ [NO] → System: Tampilkan error "Email tidak terdaftar"
│   │         └─ Kembali ke form login
│   └─ [YES] ↓
│
├─ System: Ambil data user dari database
│
├─ System: Verifikasi password (hash comparison)
│
├─ Decision: Password cocok?
│   ├─ [NO] → System: Tampilkan error "Password salah"
│   │         └─ Kembali ke form login
│   └─ [YES] ↓
│
├─ System: Buat session untuk user
│
├─ System: Simpan data user ke session
│
├─ System: Cek role user
│
├─ Decision: Role user?
│   │
│   ├─ [Admin] → System: Redirect ke dashboard admin
│   │           │
│   │           ├─ System: Tampilkan statistik
│   │           │
│   │           ├─ System: Tampilkan grafik
│   │           │
│   │           └─ [END]
│   │
│   └─ [User] → System: Redirect ke halaman beranda
│               │
│               ├─ System: Tampilkan menu tiket & booking
│               │
│               ├─ System: Tampilkan dropdown user
│               │
│               └─ [END]
```

### Decision Points
1. **Format email valid?** - Validasi format email
2. **Password terisi?** - Validasi password tidak kosong
3. **User ditemukan?** - Cek keberadaan email di database
4. **Password cocok?** - Verifikasi hash password
5. **Role user?** - Tentukan redirect berdasarkan role

### Catatan
- Password di-hash menggunakan bcrypt
- Session disimpan untuk maintain login state
- Redirect berbeda untuk admin dan user

---

## Panduan Membuat Diagram di Draw.io

### Langkah 1: Setup Canvas
1. Buka draw.io
2. Pilih "Blank Diagram"
3. Aktifkan library "UML" dari menu More Shapes
4. Set ukuran canvas: A4 Portrait atau Landscape

### Langkah 2: Buat Swimlanes
1. Drag "Swimlane" dari library UML
2. Buat 2-3 swimlanes sesuai kebutuhan:
   - **Vertical Swimlanes** untuk actor yang berbeda
   - Contoh: User | System | Admin
3. Beri label pada setiap swimlane
4. Atur lebar swimlane agar proporsional

### Langkah 3: Tambahkan Initial Node
1. Drag "Initial Node" (lingkaran hitam penuh)
2. Letakkan di bagian atas swimlane pertama
3. Ini adalah titik awal aktivitas

### Langkah 4: Tambahkan Activities
1. Drag "Activity" (rounded rectangle) dari library
2. Buat activity untuk setiap langkah:
   - Gunakan verb + object (contoh: "Pilih tanggal", "Validasi data")
   - Letakkan di swimlane yang sesuai
3. Hubungkan dengan arrow (Control Flow)

### Langkah 5: Tambahkan Decision Nodes
1. Drag "Decision" (diamond/rhombus)
2. Gunakan untuk percabangan kondisi
3. Beri label kondisi pada setiap arrow keluar:
   - [YES] atau [NO]
   - [Valid] atau [Invalid]
4. Merge kembali dengan "Merge Node" jika perlu

### Langkah 6: Tambahkan Fork/Join (Opsional)
1. Drag "Fork" (horizontal bar) untuk aktivitas paralel
2. Gunakan "Join" untuk menggabungkan kembali
3. Contoh: Generate QR code untuk multiple tiket secara bersamaan

### Langkah 7: Tambahkan Final Node
1. Drag "Final Node" (lingkaran dengan lingkaran dalam)
2. Letakkan di akhir alur
3. Bisa ada multiple final nodes untuk berbagai ending

### Langkah 8: Hubungkan dengan Control Flow
1. Gunakan arrow untuk menghubungkan nodes
2. Pastikan arah flow jelas (top to bottom)
3. Hindari crossing lines jika memungkinkan

### Tips Styling

#### Warna Swimlanes
- **User/Admin**: Biru muda (#E3F2FD)
- **System**: Hijau muda (#E8F5E9)
- **Database**: Abu-abu muda (#F5F5F5)
- **External**: Kuning muda (#FFF9C4)

#### Warna Activities
- **Normal Activity**: Putih dengan border hitam
- **Important Activity**: Hijau teal (#14B8A6)
- **Error/Reject**: Merah muda (#FFCDD2)
- **Success**: Hijau muda (#C8E6C9)

#### Warna Decision
- **Decision Node**: Kuning (#FFF59D)
- **Merge Node**: Abu-abu (#E0E0E0)

#### Font
- **Activity Label**: Arial, 11pt, Bold
- **Decision Label**: Arial, 10pt, Italic
- **Swimlane Label**: Arial, 12pt, Bold

### Best Practices

1. **Konsistensi**:
   - Gunakan ukuran yang sama untuk semua activity nodes
   - Gunakan spacing yang konsisten
   - Align nodes menggunakan grid

2. **Clarity**:
   - Gunakan label yang jelas dan singkat
   - Hindari terlalu banyak crossing lines
   - Gunakan warna untuk membedakan jenis aktivitas

3. **Flow Direction**:
   - Utamakan top-to-bottom flow
   - Gunakan left-to-right untuk swimlanes
   - Loop back dengan arrow yang jelas

4. **Decision Nodes**:
   - Selalu beri label pada setiap branch
   - Gunakan [YES]/[NO] atau [Valid]/[Invalid]
   - Pastikan semua branch memiliki ending

5. **Swimlanes**:
   - Letakkan aktivitas di swimlane yang tepat
   - Crossing swimlane menunjukkan interaksi
   - Jangan terlalu banyak swimlanes (max 4)

### Contoh Layout

```
┌─────────────┬──────────────┬─────────────┐
│    User     │   System     │    Admin    │
├─────────────┼──────────────┼─────────────┤
│             │              │             │
│   (●)       │              │             │
│    │        │              │             │
│    ▼        │              │             │
│ ┌─────┐    │              │             │
│ │Login│────┼──────────────┼────────────▶│
│ └─────┘    │              │             │
│            │   ┌──────┐   │             │
│            │   │Validasi  │             │
│            │   └──────┘   │             │
│            │      │        │             │
│            │      ▼        │             │
│            │   ◇Valid?    │             │
│            │   /    \      │             │
│            │ NO      YES   │             │
│            │  │       │    │             │
│            │  ▼       ▼    │             │
│            │Error   Success│             │
│            │  │       │    │             │
│            │  ▼       ▼    │             │
│            │  (◎)    (◎)  │             │
└─────────────┴──────────────┴─────────────┘
```

---

## Checklist Sebelum Finalisasi

- [ ] Semua aktivitas memiliki label yang jelas
- [ ] Semua decision nodes memiliki label kondisi
- [ ] Flow direction konsisten (top-to-bottom)
- [ ] Tidak ada aktivitas yang "menggantung" (tanpa input/output)
- [ ] Swimlanes sudah sesuai dengan actor
- [ ] Warna sudah konsisten
- [ ] Initial dan Final nodes sudah ada
- [ ] Spacing dan alignment rapi
- [ ] Tidak terlalu banyak crossing lines
- [ ] Diagram mudah dibaca dan dipahami

---

## Summary

**Total Activity Diagrams**: 5

1. **Proses Pembelian Tiket** - 3 swimlanes, ~25 activities
2. **Proses Verifikasi Pembayaran Tiket** - 3 swimlanes, ~15 activities
3. **Proses Booking Tempat** - 2 swimlanes, ~30 activities
4. **Proses Verifikasi Tiket dengan QR Code** - 3 swimlanes, ~25 activities
5. **Proses Login** - 3 swimlanes, ~15 activities

**Total Activities**: ~110 activities
**Total Decision Points**: ~20 decisions
**Total Swimlanes**: 8 (across all diagrams)

---

**Dibuat**: 25 Februari 2026  
**Versi**: 1.0  
**Sistem**: Banyu Biru Ticketing & Booking System

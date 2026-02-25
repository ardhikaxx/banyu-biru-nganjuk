# Use Case Diagram - Sistem Tiket & Booking Banyu Biru

## Daftar Isi
1. [Actors](#actors)
2. [Use Cases](#use-cases)
3. [Use Case Descriptions](#use-case-descriptions)
4. [Relationships](#relationships)
5. [Panduan Membuat Diagram di Draw.io](#panduan-membuat-diagram-di-drawio)

---

## Actors

### 1. Guest (Pengunjung)
**Deskripsi**: Pengguna yang belum login/register
**Akses**: Terbatas, hanya bisa melihat informasi

### 2. User (Pengguna Terdaftar)
**Deskripsi**: Pengguna yang sudah register dan login
**Akses**: Dapat membeli tiket dan melakukan booking

### 3. Admin
**Deskripsi**: Administrator sistem
**Akses**: Penuh, dapat mengelola semua data dan verifikasi pembayaran

---

## Use Cases

### A. Guest Use Cases

1. **Melihat Halaman Beranda**
   - Melihat informasi umum
   - Melihat harga tiket
   - Melihat fasilitas

2. **Register**
   - Mendaftar akun baru
   - Mengisi data diri

3. **Login**
   - Masuk ke sistem

---

### B. User Use Cases

#### Autentikasi
4. **Login**
   - Masuk ke sistem dengan email dan password

5. **Logout**
   - Keluar dari sistem

6. **Ubah Profil**
   - Mengubah data profil
   - Mengubah password

#### Manajemen Tiket
7. **Lihat Daftar Tiket**
   - Melihat jenis tiket yang tersedia
   - Melihat harga tiket

8. **Beli Tiket**
   - Memilih jenis tiket
   - Memilih tanggal kunjungan
   - Memilih jumlah tiket
   - Mendapatkan kode order

9. **Upload Bukti Pembayaran Tiket**
   - Upload foto/file bukti transfer
   - Menunggu verifikasi admin

10. **Lihat Status Pesanan Tiket**
    - Melihat status: pending/confirmed/rejected
    - Melihat detail pesanan

11. **Download Tiket**
    - Download tiket dalam format PDF
    - Mendapatkan QR code tiket

12. **Lihat Riwayat Tiket**
    - Melihat semua tiket yang pernah dibeli
    - Melihat status tiket

#### Manajemen Booking
13. **Lihat Informasi Tempat**
    - Melihat tempat yang bisa dibooking
    - Melihat harga dan kapasitas

14. **Cek Ketersediaan Tanggal**
    - Mengecek apakah tanggal tersedia
    - Melihat tanggal yang sudah dibooking

15. **Booking Tempat**
    - Memilih tanggal booking
    - Mengisi data pengunjung
    - Mendapatkan kode booking

16. **Upload Bukti Pembayaran Booking**
    - Upload foto/file bukti transfer
    - Menunggu verifikasi admin

17. **Lihat Status Booking**
    - Melihat status: pending/confirmed/rejected
    - Melihat detail booking

18. **Lihat Riwayat Booking**
    - Melihat semua booking yang pernah dibuat
    - Melihat status booking

---

### C. Admin Use Cases

#### Dashboard & Monitoring
19. **Lihat Dashboard**
    - Melihat statistik penjualan
    - Melihat grafik transaksi
    - Melihat total pendapatan

#### Manajemen Tiket
20. **Kelola Jenis Tiket**
    - Tambah jenis tiket baru
    - Edit jenis tiket
    - Hapus jenis tiket
    - Aktifkan/nonaktifkan tiket

21. **Lihat Daftar Pesanan Tiket**
    - Melihat semua pesanan tiket
    - Filter berdasarkan status
    - Cari pesanan

22. **Verifikasi Pembayaran Tiket**
    - Melihat bukti pembayaran
    - Konfirmasi pembayaran
    - Tolak pembayaran dengan alasan

23. **Verifikasi Tiket (Scan QR)**
    - Scan QR code tiket
    - Input kode tiket manual
    - Tandai tiket sebagai dipakai
    - Cek status tiket

#### Manajemen Booking
24. **Lihat Daftar Booking**
    - Melihat semua booking
    - Filter berdasarkan status
    - Cari booking

25. **Verifikasi Pembayaran Booking**
    - Melihat bukti pembayaran
    - Konfirmasi pembayaran
    - Tolak pembayaran dengan alasan

26. **Verifikasi Booking (Cek Kode)**
    - Input kode booking
    - Cek status booking
    - Validasi tanggal booking

#### Manajemen Rekening Bank
27. **Kelola Rekening Bank**
    - Tambah rekening bank
    - Edit rekening bank
    - Hapus rekening bank
    - Aktifkan/nonaktifkan rekening

#### Manajemen Admin
28. **Kelola Admin**
    - Tambah admin baru
    - Edit data admin
    - Hapus admin
    - Lihat daftar admin

#### Profil
29. **Ubah Profil Admin**
    - Mengubah data profil
    - Mengubah password

30. **Logout**
    - Keluar dari sistem

---

## Use Case Descriptions

### UC-01: Beli Tiket (User)

**Actor**: User

**Precondition**: 
- User sudah login
- User bukan admin

**Main Flow**:
1. User mengakses halaman pembelian tiket
2. Sistem menampilkan daftar tiket yang tersedia
3. User memilih tanggal kunjungan
4. User memilih jenis tiket dan jumlah
5. Sistem menghitung total harga
6. User mengkonfirmasi pesanan
7. Sistem membuat order dan generate kode tiket + QR code
8. Sistem menampilkan halaman pembayaran dengan nomor rekening
9. User melakukan transfer
10. User upload bukti pembayaran
11. Sistem menyimpan bukti dan mengubah status menjadi "pending"
12. Sistem menampilkan halaman download tiket

**Postcondition**: 
- Order tiket tersimpan dengan status "pending"
- QR code tiket ter-generate
- User menunggu verifikasi admin

**Alternative Flow**:
- 3a. Tanggal yang dipilih sudah lewat → Sistem menampilkan error
- 4a. Stok tiket habis → Sistem menampilkan peringatan
- 10a. User belum upload bukti → Tiket belum bisa didownload

---

### UC-02: Verifikasi Pembayaran Tiket (Admin)

**Actor**: Admin

**Precondition**: 
- Admin sudah login
- Ada pesanan tiket dengan status "pending"

**Main Flow**:
1. Admin mengakses halaman daftar pesanan tiket
2. Sistem menampilkan daftar pesanan dengan filter status
3. Admin memilih pesanan yang akan diverifikasi
4. Sistem menampilkan detail pesanan dan bukti pembayaran
5. Admin memeriksa bukti pembayaran
6. Admin mengklik tombol "Konfirmasi"
7. Sistem mengubah status menjadi "confirmed"
8. Sistem mencatat waktu konfirmasi dan admin yang mengkonfirmasi
9. Sistem menampilkan notifikasi sukses

**Postcondition**: 
- Status order berubah menjadi "confirmed"
- User dapat download tiket
- Transaksi masuk ke laporan pendapatan

**Alternative Flow**:
- 6a. Admin menolak pembayaran:
  - Admin mengklik tombol "Tolak"
  - Admin mengisi alasan penolakan
  - Sistem mengubah status menjadi "rejected"
  - User perlu upload ulang bukti pembayaran

---

### UC-03: Scan QR Code Tiket (Admin)

**Actor**: Admin

**Precondition**: 
- Admin sudah login
- User membawa tiket dengan QR code

**Main Flow**:
1. Admin mengakses halaman verifikasi tiket
2. Sistem menampilkan scanner QR code
3. Admin mengarahkan kamera ke QR code tiket
4. Sistem membaca QR code dan mendapatkan kode tiket
5. Sistem mencari tiket berdasarkan kode
6. Sistem menampilkan detail tiket dan status
7. Admin memeriksa validitas tiket
8. Admin mengklik "Tandai Sebagai Dipakai"
9. Sistem mengubah status tiket menjadi "used"
10. Sistem mencatat waktu penggunaan

**Postcondition**: 
- Tiket ditandai sebagai sudah dipakai
- Tiket tidak bisa digunakan lagi

**Alternative Flow**:
- 3a. Kamera tidak bisa diakses → Admin input kode manual
- 5a. Kode tiket tidak ditemukan → Sistem menampilkan error
- 7a. Tiket sudah dipakai → Sistem menampilkan peringatan
- 7b. Tiket belum dikonfirmasi → Sistem menampilkan status pending

---

### UC-04: Booking Tempat (User)

**Actor**: User

**Precondition**: 
- User sudah login
- User bukan admin

**Main Flow**:
1. User mengakses halaman booking
2. Sistem menampilkan informasi tempat (Pendopo)
3. User memilih tanggal booking
4. Sistem mengecek ketersediaan tanggal
5. User mengisi data pengunjung (nama, telepon, alamat)
6. User mengisi catatan (opsional)
7. Sistem menghitung total harga
8. User mengkonfirmasi booking
9. Sistem membuat booking dan generate kode booking
10. Sistem menampilkan halaman pembayaran
11. User melakukan transfer
12. User upload bukti pembayaran
13. Sistem menyimpan bukti dan mengubah status menjadi "pending"

**Postcondition**: 
- Booking tersimpan dengan status "pending"
- Tanggal ter-block untuk booking lain
- User menunggu verifikasi admin

**Alternative Flow**:
- 4a. Tanggal sudah dibooking → Sistem menampilkan error, user pilih tanggal lain
- 4b. Tanggal sudah lewat → Sistem menampilkan error

---

### UC-05: Kelola Jenis Tiket (Admin)

**Actor**: Admin

**Precondition**: 
- Admin sudah login

**Main Flow - Tambah Tiket**:
1. Admin mengakses halaman kelola tiket
2. Admin mengklik tombol "Tambah Tiket"
3. Sistem menampilkan form input
4. Admin mengisi data tiket (nama, deskripsi, harga, kuota)
5. Admin mengklik tombol "Simpan"
6. Sistem validasi data
7. Sistem menyimpan tiket baru
8. Sistem menampilkan notifikasi sukses

**Main Flow - Edit Tiket**:
1. Admin mengakses halaman kelola tiket
2. Admin mengklik tombol "Edit" pada tiket yang dipilih
3. Sistem menampilkan form edit dengan data tiket
4. Admin mengubah data tiket
5. Admin mengklik tombol "Update"
6. Sistem validasi data
7. Sistem menyimpan perubahan
8. Sistem menampilkan notifikasi sukses

**Main Flow - Hapus Tiket**:
1. Admin mengakses halaman kelola tiket
2. Admin mengklik tombol "Hapus" pada tiket yang dipilih
3. Sistem menampilkan konfirmasi
4. Admin mengkonfirmasi penghapusan
5. Sistem menghapus tiket
6. Sistem menampilkan notifikasi sukses

**Postcondition**: 
- Data tiket berubah sesuai aksi yang dilakukan

**Alternative Flow**:
- 6a. Validasi gagal → Sistem menampilkan error
- 5a. Tiket masih digunakan di order → Sistem menampilkan peringatan

---

## Relationships

### Include Relationships

1. **Beli Tiket** `<<include>>` **Upload Bukti Pembayaran Tiket**
   - Setelah beli tiket, user harus upload bukti pembayaran

2. **Booking Tempat** `<<include>>` **Upload Bukti Pembayaran Booking**
   - Setelah booking, user harus upload bukti pembayaran

3. **Booking Tempat** `<<include>>` **Cek Ketersediaan Tanggal**
   - Sebelum booking, sistem harus cek ketersediaan

4. **Verifikasi Tiket (Scan QR)** `<<include>>` **Tandai Tiket Sebagai Dipakai**
   - Setelah scan dan validasi, admin bisa tandai tiket dipakai

### Extend Relationships

1. **Beli Tiket** `<<extend>>` **Download Tiket**
   - Download tiket hanya bisa dilakukan jika pembayaran sudah dikonfirmasi

2. **Verifikasi Pembayaran Tiket** `<<extend>>` **Tolak Pembayaran**
   - Admin bisa memilih untuk tolak pembayaran

3. **Verifikasi Pembayaran Booking** `<<extend>>` **Tolak Pembayaran**
   - Admin bisa memilih untuk tolak pembayaran

### Generalization Relationships

1. **User** dan **Admin** adalah spesialisasi dari **Guest**
   - Keduanya inherit kemampuan Guest (melihat halaman beranda)

---

## Panduan Membuat Diagram di Draw.io

### Langkah 1: Setup Canvas
1. Buka draw.io
2. Pilih "Blank Diagram"
3. Aktifkan library "UML" dari menu More Shapes

### Langkah 2: Tambahkan Actors
1. Drag "Actor" dari library UML
2. Buat 3 actors:
   - Guest (kiri atas)
   - User (kiri tengah)
   - Admin (kiri bawah)
3. Beri label pada setiap actor

### Langkah 3: Buat System Boundary
1. Drag "Rectangle" untuk membuat boundary
2. Beri label "Sistem Tiket & Booking Banyu Biru"
3. Posisikan di tengah canvas

### Langkah 4: Tambahkan Use Cases
1. Drag "Use Case" (oval) dari library UML
2. Buat use case untuk setiap fitur:

**Guest Use Cases** (di dalam boundary, bagian atas):
- Melihat Halaman Beranda
- Register
- Login

**User Use Cases** (di dalam boundary, bagian tengah):
- Lihat Daftar Tiket
- Beli Tiket
- Upload Bukti Pembayaran Tiket
- Download Tiket
- Lihat Riwayat Tiket
- Cek Ketersediaan Tanggal
- Booking Tempat
- Upload Bukti Pembayaran Booking
- Lihat Riwayat Booking
- Ubah Profil
- Logout

**Admin Use Cases** (di dalam boundary, bagian bawah):
- Lihat Dashboard
- Kelola Jenis Tiket
- Lihat Daftar Pesanan Tiket
- Verifikasi Pembayaran Tiket
- Verifikasi Tiket (Scan QR)
- Lihat Daftar Booking
- Verifikasi Pembayaran Booking
- Kelola Rekening Bank
- Kelola Admin
- Ubah Profil Admin
- Logout

### Langkah 5: Hubungkan Actors dengan Use Cases
1. Gunakan "Association" (garis solid) untuk menghubungkan:
   - Guest → Melihat Halaman Beranda
   - Guest → Register
   - Guest → Login
   
   - User → Semua User Use Cases
   
   - Admin → Semua Admin Use Cases

### Langkah 6: Tambahkan Include Relationships
1. Gunakan "Dependency" dengan stereotype `<<include>>`
2. Arah panah dari use case utama ke use case yang di-include:
   - Beli Tiket → Upload Bukti Pembayaran Tiket
   - Booking Tempat → Upload Bukti Pembayaran Booking
   - Booking Tempat → Cek Ketersediaan Tanggal

### Langkah 7: Tambahkan Extend Relationships
1. Gunakan "Dependency" dengan stereotype `<<extend>>`
2. Arah panah dari use case extension ke use case utama:
   - Download Tiket → Beli Tiket
   - Tolak Pembayaran → Verifikasi Pembayaran Tiket
   - Tolak Pembayaran → Verifikasi Pembayaran Booking

### Langkah 8: Tambahkan Generalization (Opsional)
1. Gunakan "Generalization" (garis dengan panah segitiga kosong)
2. Hubungkan User dan Admin ke Guest (jika ingin menunjukkan inheritance)

### Tips Styling:
- Gunakan warna berbeda untuk setiap actor
- Gunakan warna berbeda untuk use case berdasarkan kategori:
  - Biru: Autentikasi
  - Hijau: Tiket
  - Kuning: Booking
  - Merah: Admin/Verifikasi
- Atur layout agar tidak terlalu padat
- Gunakan grid untuk alignment yang rapi

---

## Contoh Grouping Use Cases

### Group 1: Autentikasi (Biru)
- Login
- Logout
- Register
- Ubah Profil

### Group 2: Manajemen Tiket User (Hijau Muda)
- Lihat Daftar Tiket
- Beli Tiket
- Upload Bukti Pembayaran Tiket
- Download Tiket
- Lihat Riwayat Tiket

### Group 3: Manajemen Booking User (Kuning)
- Cek Ketersediaan Tanggal
- Booking Tempat
- Upload Bukti Pembayaran Booking
- Lihat Riwayat Booking

### Group 4: Manajemen Tiket Admin (Hijau Tua)
- Kelola Jenis Tiket
- Lihat Daftar Pesanan Tiket
- Verifikasi Pembayaran Tiket
- Verifikasi Tiket (Scan QR)

### Group 5: Manajemen Booking Admin (Oranye)
- Lihat Daftar Booking
- Verifikasi Pembayaran Booking
- Verifikasi Booking (Cek Kode)

### Group 6: Manajemen Sistem Admin (Merah)
- Lihat Dashboard
- Kelola Rekening Bank
- Kelola Admin

---

## Summary

**Total Actors**: 3 (Guest, User, Admin)

**Total Use Cases**: 30

**Breakdown**:
- Guest: 3 use cases
- User: 12 use cases
- Admin: 15 use cases

**Relationships**:
- Include: 4
- Extend: 3
- Association: ~45 (tergantung detail)

---

**Dibuat**: 25 Februari 2026  
**Versi**: 1.0  
**Sistem**: Banyu Biru Ticketing & Booking System

# Flowchart - Fitur Booking Pendopo

## Daftar Isi
1. [Lihat Halaman Booking](#1-lihat-halaman-booking)
2. [Cek Ketersediaan Tanggal](#2-cek-ketersediaan-tanggal)
3. [Buat Booking](#3-buat-booking)
4. [Upload Bukti Pembayaran Booking](#4-upload-bukti-pembayaran-booking)
5. [Lihat Status Booking](#5-lihat-status-booking)

---

## 1. Lihat Halaman Booking

### Deskripsi
Flowchart untuk mengakses halaman booking pendopo.

### Flowchart

```
START
  ↓
{User sudah login?}
  ├─ NO → [Redirect ke halaman login] → END
  └─ YES ↓
       ↓
{User adalah admin?}
  ├─ YES → [Tampilkan SweetAlert: "Admin tidak dapat melakukan booking"]
  │        ↓
  │        [Redirect ke dashboard admin]
  │        ↓
  │        END
  └─ NO ↓
       ↓
[Query database: cari place dengan name = 'pendopo']
  ↓
{Place 'pendopo' ditemukan?}
  ├─ NO → [Query: ambil place aktif pertama]
  │       ↓
  │       [Gunakan place tersebut]
  └─ YES ↓
       ↓
[Ambil data place pendopo]
  ↓
[Tampilkan halaman booking]
  ↓
[Tampilkan informasi pendopo:]
  - Nama tempat
  - Harga per hari
  - Deskripsi
  ↓
[Tampilkan form booking]
  ↓
END
```

---

## 2. Cek Ketersediaan Tanggal

### Deskripsi
Flowchart untuk mengecek apakah tanggal sudah dibooking atau masih tersedia.

### Flowchart

```
START
  ↓
[User memilih tanggal booking]
  ↓
[Trigger event onchange pada input tanggal]
  ↓
[Kirim AJAX request ke server]
  ↓
[Server: validasi format tanggal]
  ↓
{Format tanggal valid?}
  ├─ NO → [Return error: "Format tanggal tidak valid"] → END
  └─ YES ↓
       ↓
[Query database: cari booking dengan tanggal tersebut]
  ↓
[Query: WHERE place_id = pendopo_id]
  ↓
[Query: AND booking_date = tanggal_dipilih]
  ↓
{Booking ditemukan?}
  ├─ YES → [Return JSON: available = false]
  │        ↓
  │        [Tampilkan pesan: "Tanggal sudah dibooking"]
  │        ↓
  │        [Disable tombol submit]
  │        ↓
  │        [Tampilkan alert merah]
  │        ↓
  │        END
  │
  └─ NO → [Return JSON: available = true]
          ↓
          [Tampilkan pesan: "Tanggal tersedia"]
          ↓
          [Enable tombol submit]
          ↓
          [Tampilkan alert hijau]
          ↓
          END
```

---

## 3. Buat Booking

### Deskripsi
Flowchart untuk proses pembuatan booking pendopo.

### Flowchart

```
START
  ↓
[User di halaman booking]
  ↓
[User mengisi form:]
  - Tanggal booking
  - Nama pengunjung
  - Nomor telepon
  - Alamat
  - Catatan (opsional)
  ↓
[User klik tombol "Booking Sekarang"]
  ↓
<Validasi input>
  ↓
{Tanggal >= hari ini?}
  ├─ NO → [Error: "Tanggal harus hari ini atau setelahnya"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Nama pengunjung terisi?}
  ├─ NO → [Error: "Nama wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Nomor telepon terisi?}
  ├─ NO → [Error: "Nomor telepon wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Alamat terisi?}
  ├─ NO → [Error: "Alamat wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Query database: cek tanggal sudah dibooking]
  ↓
{Tanggal sudah dibooking?}
  ├─ YES → [Error: "Tanggal sudah dibooking, pilih tanggal lain"]
  │        ↓
  │        [Kembali ke form dengan input tersimpan]
  │        ↓
  │        END
  └─ NO ↓
       ↓
[Generate kode booking unik (AB-XXXXX)]
  ↓
[Hitung total harga = price_per_day dari place]
  ↓
[Simpan data ke tabel bookings:]
  - user_id = user yang login
  - place_id = pendopo_id
  - booking_code = AB-XXXXX
  - booking_date = tanggal dipilih
  - visitor_name
  - visitor_phone
  - visitor_address
  - num_persons = 1
  - total_price
  - notes
  - status = 'pending'
  ↓
[Tampilkan notifikasi sukses]
  ↓
[Redirect ke halaman pembayaran]
  ↓
END
```

---

## 4. Upload Bukti Pembayaran Booking

### Deskripsi
Flowchart untuk upload bukti transfer pembayaran booking.

### Flowchart

```
START
  ↓
[User di halaman pembayaran booking]
  ↓
[Tampilkan informasi booking:]
  - Kode booking
  - Tanggal booking
  - Nama pengunjung
  - Total harga
  ↓
[Query database: ambil daftar rekening bank aktif]
  ↓
[Tampilkan nomor rekening bank]
  ↓
[User melakukan transfer ke rekening]
  ↓
[User klik "Upload Bukti Pembayaran"]
  ↓
[User pilih file bukti transfer]
  ↓
<Validasi file>
  ↓
{File dipilih?}
  ├─ NO → [Error: "File wajib dipilih"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Format file valid (jpg, jpeg, png, pdf)?}
  ├─ NO → [Error: "Format file tidak valid"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Ukuran file <= 5MB?}
  ├─ NO → [Error: "Ukuran file terlalu besar"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Generate nama file unik:]
  Format: YYYYMMDDHHMMSS_uniqid.ext
  ↓
[Simpan file ke /public/payment-proofs/]
  ↓
[Update tabel bookings:]
  - payment_proof = path file
  - status tetap 'pending'
  ↓
[Tampilkan notifikasi sukses]
  ↓
[Redirect ke halaman status booking]
  ↓
END
```

---

## 5. Lihat Status Booking

### Deskripsi
Flowchart untuk melihat status booking setelah upload bukti pembayaran.

### Flowchart

```
START
  ↓
[User mengakses halaman status booking]
  ↓
[Query database: ambil booking berdasarkan booking_code]
  ↓
{Booking ditemukan?}
  ├─ NO → [Error 404: Booking tidak ditemukan] → END
  └─ YES ↓
       ↓
{Booking milik user yang login?}
  ├─ NO → [Error 403: Unauthorized] → END
  └─ YES ↓
       ↓
[Ambil data booking dengan relasi place]
  ↓
[Cek status booking]
  ↓
{Status = 'confirmed'?}
  ├─ YES → [Tampilkan halaman status]
  │        ↓
  │        [Tampilkan alert sukses:]
  │        "Pembayaran berhasil diverifikasi"
  │        ↓
  │        [Tampilkan informasi booking:]
  │          - Kode booking
  │          - Status: Confirmed
  │          - Tanggal booking
  │          - Nama pengunjung
  │          - Total harga
  │        ↓
  │        [Tampilkan tombol "Kembali ke Beranda"]
  │        ↓
  │        END
  │
  ├─ Status = 'pending' → [Tampilkan halaman status]
  │                       ↓
  │                       [Tampilkan alert warning:]
  │                       "Menunggu verifikasi admin"
  │                       ↓
  │                       [Tampilkan informasi booking]
  │                       ↓
  │                       [Tampilkan pesan:]
  │                       "Bukti pembayaran sedang diverifikasi"
  │                       ↓
  │                       END
  │
  └─ Status = 'rejected' → [Tampilkan halaman status]
                           ↓
                           [Tampilkan alert danger:]
                           "Pembayaran ditolak"
                           ↓
                           [Tampilkan alasan penolakan]
                           ↓
                           [Tampilkan tombol "Upload Ulang Bukti"]
                           ↓
                           END
```

---

## Panduan Membuat di Draw.io

### Simbol Flowchart
1. **Terminator** (Oval) - START/END
2. **Process** (Rectangle) - Proses/aksi
3. **Decision** (Diamond) - Kondisi/percabangan
4. **Data** (Parallelogram) - Input/Output
5. **Database** (Cylinder) - Operasi database
6. **Document** (Rectangle with wavy bottom) - File/dokumen

### Warna yang Disarankan
- **START/END**: Hijau teal (#14B8A6)
- **Process**: Biru muda (#E3F2FD)
- **Decision**: Kuning (#FFF59D)
- **Database Operation**: Ungu muda (#E1BEE7)
- **File Operation**: Oranye muda (#FFE0B2)
- **Error**: Merah muda (#FFCDD2)
- **Success**: Hijau muda (#C8E6C9)
- **Warning**: Kuning muda (#FFF9C4)

### Tips
- Gunakan swimlane untuk memisahkan User, System, dan Database
- Tandai proses AJAX dengan warna berbeda
- Gunakan connector yang jelas untuk decision branch
- Tambahkan notes untuk validasi kompleks

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Booking Pendopo  
**Sistem**: Banyu Biru Ticketing & Booking System

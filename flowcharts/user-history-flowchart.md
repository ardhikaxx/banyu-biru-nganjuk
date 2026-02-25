# Flowchart - Fitur Riwayat User

## Daftar Isi
1. [Lihat Riwayat Tiket](#1-lihat-riwayat-tiket)
2. [Lihat Riwayat Booking](#2-lihat-riwayat-booking)
3. [Lihat Detail Tiket dari Riwayat](#3-lihat-detail-tiket-dari-riwayat)
4. [Lihat Detail Booking dari Riwayat](#4-lihat-detail-booking-dari-riwayat)

---

## 1. Lihat Riwayat Tiket

### Deskripsi
Flowchart untuk user melihat riwayat pembelian tiket.

### Flowchart

```
START
  ↓
{User sudah login?}
  ├─ NO → [Redirect ke halaman login] → END
  └─ YES ↓
       ↓
{User adalah admin?}
  ├─ YES → [Redirect ke dashboard admin] → END
  └─ NO ↓
       ↓
[User klik menu "Tiket Saya" di dropdown navbar]
  ↓
[Query database: ticket_orders]
  ↓
[Filter: user_id = user yang login]
  ↓
[Include relasi: items.ticket]
  ↓
[Urutkan: created_at DESC]
  ↓
[Pagination: 10 data per halaman]
  ↓
{Ada data tiket?}
  ├─ NO → [Tampilkan pesan: "Belum ada riwayat pembelian tiket"]
  │       ↓
  │       [Tampilkan tombol "Beli Tiket Sekarang"]
  │       ↓
  │       END
  └─ YES ↓
       ↓
[Loop untuk setiap order:]
  ↓
  ┌─────────────────────────┐
  │ [Tampilkan card order:]
  │   - Kode Order
  │   - Tanggal Kunjungan
  │   - Total Qty
  │   - Total Harga
  │   - Status (badge warna)
  │   - Tanggal Order
  │   ↓
  │ [Tampilkan daftar tiket dalam order]
  │   ↓
  │ {Status = 'confirmed'?}
  │   ├─ YES → [Tampilkan tombol "Download Tiket"]
  │   │        ↓
  │   │        [Tampilkan tombol "Lihat Detail"]
  │   │
  │   ├─ Status = 'pending' → [Tampilkan badge "Menunggu Verifikasi"]
  │   │                       ↓
  │   │                       [Tampilkan tombol "Lihat Detail"]
  │   │
  │   └─ Status = 'rejected' → [Tampilkan badge "Ditolak"]
  │                            ↓
  │                            [Tampilkan tombol "Upload Ulang"]
  │   ↓
  │ [Ulangi untuk order berikutnya]
  └─────────────────────────┘
  ↓
[Tampilkan pagination]
  ↓
END
```

---

## 2. Lihat Riwayat Booking

### Deskripsi
Flowchart untuk user melihat riwayat booking pendopo.

### Flowchart

```
START
  ↓
{User sudah login?}
  ├─ NO → [Redirect ke halaman login] → END
  └─ YES ↓
       ↓
{User adalah admin?}
  ├─ YES → [Redirect ke dashboard admin] → END
  └─ NO ↓
       ↓
[User klik menu "Booking Saya" di dropdown navbar]
  ↓
[Query database: bookings]
  ↓
[Filter: user_id = user yang login]
  ↓
[Include relasi: place]
  ↓
[Urutkan: created_at DESC]
  ↓
[Pagination: 10 data per halaman]
  ↓
{Ada data booking?}
  ├─ NO → [Tampilkan pesan: "Belum ada riwayat booking"]
  │       ↓
  │       [Tampilkan tombol "Booking Sekarang"]
  │       ↓
  │       END
  └─ YES ↓
       ↓
[Loop untuk setiap booking:]
  ↓
  ┌─────────────────────────┐
  │ [Tampilkan card booking:]
  │   - Kode Booking
  │   - Nama Tempat
  │   - Tanggal Booking
  │   - Nama Pengunjung
  │   - Total Harga
  │   - Status (badge warna)
  │   - Tanggal Order
  │   ↓
  │ {Status = 'confirmed'?}
  │   ├─ YES → [Tampilkan badge "Dikonfirmasi"]
  │   │        ↓
  │   │        [Tampilkan tombol "Lihat Detail"]
  │   │
  │   ├─ Status = 'pending' → [Tampilkan badge "Menunggu Verifikasi"]
  │   │                       ↓
  │   │                       [Tampilkan tombol "Lihat Detail"]
  │   │                       ↓
  │   │                       [Tampilkan tombol "Upload Bukti"]
  │   │
  │   └─ Status = 'rejected' → [Tampilkan badge "Ditolak"]
  │                            ↓
  │                            [Tampilkan alasan penolakan]
  │                            ↓
  │                            [Tampilkan tombol "Upload Ulang"]
  │   ↓
  │ [Ulangi untuk booking berikutnya]
  └─────────────────────────┘
  ↓
[Tampilkan pagination]
  ↓
END
```

---

## 3. Lihat Detail Tiket dari Riwayat

### Deskripsi
Flowchart untuk user melihat detail order tiket dari riwayat.

### Flowchart

```
START
  ↓
[User di halaman riwayat tiket]
  ↓
[User klik tombol "Lihat Detail" atau "Download Tiket"]
  ↓
[Redirect ke halaman download tiket]
  ↓
[Query database: ticket_orders]
  ↓
[Filter: order_code = kode yang diklik]
  ↓
[Filter: user_id = user yang login]
  ↓
[Include relasi: items.ticket]
  ↓
{Order ditemukan?}
  ├─ NO → [Error 404: Order tidak ditemukan] → END
  └─ YES ↓
       ↓
{Order milik user yang login?}
  ├─ NO → [Error 403: Unauthorized] → END
  └─ YES ↓
       ↓
[Tampilkan halaman detail order]
  ↓
[Cek status order]
  ↓
{Status = 'confirmed'?}
  ├─ YES → [Tampilkan pesan sukses]
  │        ↓
  │        [Tampilkan daftar tiket dengan QR code]
  │        ↓
  │        [Enable tombol "Download PDF"]
  │        ↓
  │        [Enable tombol "Print Tiket"]
  │        ↓
  │        END
  │
  ├─ Status = 'pending' → [Tampilkan pesan warning]
  │                       ↓
  │                       [Tampilkan daftar tiket]
  │                       ↓
  │                       [Disable tombol download (abu-abu)]
  │                       ↓
  │                       [Tampilkan: "Menunggu verifikasi admin"]
  │                       ↓
  │                       END
  │
  └─ Status = 'rejected' → [Tampilkan pesan danger]
                           ↓
                           [Tampilkan alasan penolakan]
                           ↓
                           [Tampilkan tombol "Upload Ulang Bukti"]
                           ↓
                           END
```

---

## 4. Lihat Detail Booking dari Riwayat

### Deskripsi
Flowchart untuk user melihat detail booking dari riwayat.

### Flowchart

```
START
  ↓
[User di halaman riwayat booking]
  ↓
[User klik tombol "Lihat Detail"]
  ↓
[Redirect ke halaman status booking]
  ↓
[Query database: bookings]
  ↓
[Filter: booking_code = kode yang diklik]
  ↓
[Filter: user_id = user yang login]
  ↓
[Include relasi: place]
  ↓
{Booking ditemukan?}
  ├─ NO → [Error 404: Booking tidak ditemukan] → END
  └─ YES ↓
       ↓
{Booking milik user yang login?}
  ├─ NO → [Error 403: Unauthorized] → END
  └─ YES ↓
       ↓
[Tampilkan halaman detail booking]
  ↓
[Tampilkan informasi booking:]
  - Kode Booking
  - Nama Tempat
  - Tanggal Booking
  - Nama Pengunjung
  - Nomor Telepon
  - Alamat
  - Total Harga
  - Catatan
  - Bukti Pembayaran
  ↓
[Cek status booking]
  ↓
{Status = 'confirmed'?}
  ├─ YES → [Tampilkan alert sukses:]
  │        "Pembayaran berhasil diverifikasi"
  │        ↓
  │        [Tampilkan badge "Confirmed"]
  │        ↓
  │        [Tampilkan tombol "Kembali"]
  │        ↓
  │        END
  │
  ├─ Status = 'pending' → [Tampilkan alert warning:]
  │                       "Menunggu verifikasi admin"
  │                       ↓
  │                       [Tampilkan badge "Pending"]
  │                       ↓
  │                       {Bukti pembayaran sudah diupload?}
  │                       ├─ YES → [Tampilkan pesan: "Bukti sedang diverifikasi"]
  │                       └─ NO → [Tampilkan tombol "Upload Bukti"]
  │                       ↓
  │                       END
  │
  └─ Status = 'rejected' → [Tampilkan alert danger:]
                           "Pembayaran ditolak"
                           ↓
                           [Tampilkan badge "Rejected"]
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
6. **Loop** (Hexagon) - Perulangan
7. **Display** (Parallelogram with curved sides) - Tampilan UI

### Warna yang Disarankan
- **START/END**: Hijau teal (#14B8A6)
- **Process**: Biru muda (#E3F2FD)
- **Decision**: Kuning (#FFF59D)
- **Database Operation**: Ungu muda (#E1BEE7)
- **Display**: Biru tua muda (#BBDEFB)
- **Confirmed**: Hijau muda (#C8E6C9)
- **Pending**: Kuning muda (#FFF9C4)
- **Rejected**: Merah muda (#FFCDD2)
- **Loop**: Oranye muda (#FFE0B2)

### Tips
- Gunakan swimlane untuk memisahkan User dan System
- Tandai status order dengan warna berbeda
- Gunakan loop symbol untuk iterasi data
- Tambahkan notes untuk pagination
- Highlight perbedaan tampilan berdasarkan status

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Riwayat User (Tiket & Booking)  
**Sistem**: Banyu Biru Ticketing & Booking System

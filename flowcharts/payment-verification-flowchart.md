# Flowchart - Fitur Verifikasi Pembayaran Admin

## Daftar Isi
1. [Lihat Daftar Order Tiket](#1-lihat-daftar-order-tiket)
2. [Lihat Detail Order Tiket](#2-lihat-detail-order-tiket)
3. [Konfirmasi Pembayaran Tiket](#3-konfirmasi-pembayaran-tiket)
4. [Tolak Pembayaran Tiket](#4-tolak-pembayaran-tiket)
5. [Verifikasi Pembayaran Booking](#5-verifikasi-pembayaran-booking)

---

## 1. Lihat Daftar Order Tiket

### Deskripsi
Flowchart untuk admin melihat daftar semua order tiket.

### Flowchart

```
START
  ↓
{User sudah login?}
  ├─ NO → [Redirect ke halaman login] → END
  └─ YES ↓
       ↓
{User adalah admin?}
  ├─ NO → [Error 403: Unauthorized] → END
  └─ YES ↓
       ↓
[Admin mengakses menu "Order Tiket"]
  ↓
[Query database: ambil semua ticket_orders]
  ↓
[Include relasi: user]
  ↓
[Urutkan: terbaru ke terlama (latest)]
  ↓
[Tampilkan tabel order tiket:]
  - Kode Order
  - Nama User
  - Tanggal Kunjungan
  - Total Qty
  - Total Harga
  - Status (pending/confirmed/rejected)
  - Aksi (Detail)
  ↓
[Tampilkan badge warna sesuai status:]
  - Pending: Kuning
  - Confirmed: Hijau
  - Rejected: Merah
  ↓
END
```

---

## 2. Lihat Detail Order Tiket

### Deskripsi
Flowchart untuk admin melihat detail order tiket dan bukti pembayaran.

### Flowchart

```
START
  ↓
[Admin klik tombol "Detail" pada order]
  ↓
[Query database: ambil ticket_order berdasarkan ID]
  ↓
[Include relasi:]
  - user
  - items.ticket
  ↓
{Order ditemukan?}
  ├─ NO → [Error 404: Order tidak ditemukan] → END
  └─ YES ↓
       ↓
[Tampilkan halaman detail order]
  ↓
[Tampilkan informasi order:]
  - Kode Order
  - Nama User
  - Email User
  - Tanggal Kunjungan
  - Total Qty
  - Total Harga
  - Status
  - Tanggal Order
  ↓
[Tampilkan daftar tiket yang dibeli:]
  - Kode Tiket
  - Jenis Tiket
  - Harga
  - QR Code
  - Status Dipakai
  ↓
{Bukti pembayaran ada?}
  ├─ NO → [Tampilkan pesan: "Belum upload bukti"]
  └─ YES ↓
       ↓
[Tampilkan bukti pembayaran (gambar/PDF)]
  ↓
{Status = 'pending'?}
  ├─ YES → [Tampilkan tombol:]
  │        - "Konfirmasi Pembayaran" (hijau)
  │        - "Tolak Pembayaran" (merah)
  │        ↓
  │        END
  │
  ├─ Status = 'confirmed' → [Tampilkan badge: "Sudah Dikonfirmasi"]
  │                         ↓
  │                         [Tampilkan info:]
  │                         - Dikonfirmasi oleh: nama admin
  │                         - Tanggal konfirmasi
  │                         ↓
  │                         END
  │
  └─ Status = 'rejected' → [Tampilkan badge: "Ditolak"]
                           ↓
                           [Tampilkan alasan penolakan]
                           ↓
                           END
```

---

## 3. Konfirmasi Pembayaran Tiket

### Deskripsi
Flowchart untuk admin mengkonfirmasi pembayaran tiket.

### Flowchart

```
START
  ↓
[Admin di halaman detail order]
  ↓
[Admin memeriksa bukti pembayaran]
  ↓
{Bukti pembayaran valid?}
  ├─ NO → [Admin klik "Tolak Pembayaran"] → [Lihat flowchart #4]
  └─ YES ↓
       ↓
[Admin klik tombol "Konfirmasi Pembayaran"]
  ↓
[Tampilkan konfirmasi SweetAlert:]
  "Yakin ingin konfirmasi pembayaran?"
  ↓
{Admin konfirmasi?}
  ├─ NO (Batal) → [Tutup dialog] → END
  └─ YES ↓
       ↓
[Query database: ambil ticket_order berdasarkan ID]
  ↓
{Order ditemukan?}
  ├─ NO → [Error: Order tidak ditemukan] → END
  └─ YES ↓
       ↓
[Update tabel ticket_orders:]
  - status = 'confirmed'
  - confirmed_at = waktu sekarang
  - confirmed_by = admin_id yang login
  - rejection_note = null
  ↓
[Simpan perubahan ke database]
  ↓
[Tampilkan notifikasi sukses:]
  "Order tiket berhasil dikonfirmasi"
  ↓
[Refresh halaman detail order]
  ↓
[Tampilkan badge "Confirmed"]
  ↓
[Hide tombol konfirmasi/tolak]
  ↓
END
```

---

## 4. Tolak Pembayaran Tiket

### Deskripsi
Flowchart untuk admin menolak pembayaran tiket dengan alasan.

### Flowchart

```
START
  ↓
[Admin di halaman detail order]
  ↓
[Admin memeriksa bukti pembayaran]
  ↓
{Bukti pembayaran tidak valid?}
  ├─ NO → [Admin klik "Konfirmasi"] → [Lihat flowchart #3]
  └─ YES ↓
       ↓
[Admin klik tombol "Tolak Pembayaran"]
  ↓
[Tampilkan modal form penolakan]
  ↓
[Tampilkan textarea untuk alasan penolakan]
  ↓
[Admin mengetik alasan penolakan]
  ↓
[Admin klik "Submit"]
  ↓
<Validasi input>
  ↓
{Alasan penolakan terisi?}
  ├─ NO → [Error: "Alasan penolakan wajib diisi"]
  │       ↓
  │       [Kembali ke modal]
  │       ↓
  │       END
  └─ YES ↓
       ↓
[Query database: ambil ticket_order berdasarkan ID]
  ↓
{Order ditemukan?}
  ├─ NO → [Error: Order tidak ditemukan] → END
  └─ YES ↓
       ↓
[Update tabel ticket_orders:]
  - status = 'rejected'
  - confirmed_by = admin_id yang login
  - rejection_note = alasan dari admin
  ↓
[Simpan perubahan ke database]
  ↓
[Tampilkan notifikasi sukses:]
  "Order tiket ditolak"
  ↓
[Refresh halaman detail order]
  ↓
[Tampilkan badge "Rejected"]
  ↓
[Tampilkan alasan penolakan]
  ↓
[Hide tombol konfirmasi/tolak]
  ↓
END
```

---

## 5. Verifikasi Pembayaran Booking

### Deskripsi
Flowchart untuk admin memverifikasi pembayaran booking pendopo.

### Flowchart

```
START
  ↓
[Admin mengakses menu "Booking"]
  ↓
[Query database: ambil semua bookings]
  ↓
[Include relasi: user, place]
  ↓
[Urutkan: terbaru ke terlama]
  ↓
[Tampilkan tabel booking:]
  - Kode Booking
  - Nama User
  - Tempat
  - Tanggal Booking
  - Total Harga
  - Status
  - Aksi (Detail)
  ↓
[Admin klik "Detail" pada booking]
  ↓
[Query database: ambil booking berdasarkan ID]
  ↓
[Tampilkan detail booking:]
  - Kode Booking
  - Nama Pengunjung
  - Nomor Telepon
  - Alamat
  - Tanggal Booking
  - Total Harga
  - Catatan
  - Bukti Pembayaran
  ↓
{Status = 'pending'?}
  ├─ YES → [Tampilkan tombol:]
  │        - "Konfirmasi" (hijau)
  │        - "Tolak" (merah)
  │        ↓
  │        [Admin klik salah satu tombol]
  │        ↓
  │        {Klik Konfirmasi?}
  │        ├─ YES → [Update status = 'confirmed']
  │        │        ↓
  │        │        [Set confirmed_at = now()]
  │        │        ↓
  │        │        [Set confirmed_by = admin_id]
  │        │        ↓
  │        │        [Notifikasi: "Booking dikonfirmasi"]
  │        │        ↓
  │        │        END
  │        │
  │        └─ NO (Tolak) → [Tampilkan form alasan]
  │                        ↓
  │                        [Admin input alasan]
  │                        ↓
  │                        [Update status = 'rejected']
  │                        ↓
  │                        [Set rejection_note]
  │                        ↓
  │                        [Notifikasi: "Booking ditolak"]
  │                        ↓
  │                        END
  │
  └─ NO (confirmed/rejected) → [Tampilkan status saja]
                                ↓
                                [Hide tombol aksi]
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
6. **Manual Input** (Parallelogram with slanted top) - Input manual admin

### Warna yang Disarankan
- **START/END**: Hijau teal (#14B8A6)
- **Process**: Biru muda (#E3F2FD)
- **Decision**: Kuning (#FFF59D)
- **Database Operation**: Ungu muda (#E1BEE7)
- **Admin Action**: Biru tua muda (#BBDEFB)
- **Confirm**: Hijau muda (#C8E6C9)
- **Reject**: Merah muda (#FFCDD2)
- **Pending**: Kuning muda (#FFF9C4)

### Tips
- Gunakan swimlane untuk memisahkan Admin dan System
- Tandai proses verifikasi dengan warna khusus
- Gunakan connector yang jelas untuk decision branch
- Tambahkan notes untuk status order

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Verifikasi Pembayaran Admin  
**Sistem**: Banyu Biru Ticketing & Booking System

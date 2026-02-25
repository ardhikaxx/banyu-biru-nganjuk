# Flowchart - Fitur Pembelian Tiket

## Daftar Isi
1. [Lihat Daftar Tiket](#1-lihat-daftar-tiket)
2. [Beli Tiket](#2-beli-tiket)
3. [Upload Bukti Pembayaran](#3-upload-bukti-pembayaran)
4. [Download Tiket](#4-download-tiket)

---

## 1. Lihat Daftar Tiket

### Deskripsi
Flowchart untuk melihat daftar tiket yang tersedia.

### Flowchart

```
START
  ↓
{User sudah login?}
  ├─ NO → [Redirect ke halaman login] → END
  └─ YES ↓
       ↓
{User adalah admin?}
  ├─ YES → [Tampilkan SweetAlert: "Admin tidak dapat membeli tiket"]
  │        ↓
  │        [Redirect ke dashboard admin]
  │        ↓
  │        END
  └─ NO ↓
       ↓
[Query database: ambil tiket dengan is_active = true]
  ↓
[Filter: name = "Tiket Masuk"]
  ↓
{Tiket ditemukan?}
  ├─ NO → [Query: ambil semua tiket aktif]
  │       ↓
  │       [Tampilkan tiket pertama]
  └─ YES ↓
       ↓
[Tampilkan halaman pembelian tiket]
  ↓
[Tampilkan informasi tiket:]
  - Nama tiket
  - Harga
  - Deskripsi
  ↓
[Tampilkan form pembelian]
  ↓
END
```

---

## 2. Beli Tiket

### Deskripsi
Flowchart untuk proses pembelian tiket lengkap.

### Flowchart

```
START
  ↓
[User di halaman pembelian tiket]
  ↓
[User pilih tanggal kunjungan]
  ↓
<Validasi tanggal>
  ↓
{Tanggal >= hari ini?}
  ├─ NO → [Error: "Tanggal tidak valid"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[User pilih jenis tiket]
  ↓
[User tentukan jumlah tiket (1-20)]
  ↓
{Jumlah valid (1-20)?}
  ├─ NO → [Error: "Jumlah tidak valid"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Hitung total harga = jumlah × harga tiket]
  ↓
[Tampilkan ringkasan pesanan]
  ↓
[User klik "Lanjutkan Pembayaran"]
  ↓
[Mulai database transaction]
  ↓
[Generate kode order unik (AT-XXXXX)]
  ↓
[Simpan data ke tabel ticket_orders:]
  - user_id
  - order_code
  - visit_date
  - total_qty
  - total_price
  - status = 'pending'
  ↓
[Loop untuk setiap tiket yang dibeli]
  ↓
  ┌─────────────────────────┐
  │ [Generate kode tiket unik (AT-XXXXX)]
  │   ↓
  │ [Generate QR code SVG]
  │   ↓
  │ [Simpan QR code ke /public/qrcodes/]
  │   ↓
  │ [Simpan data ke ticket_order_items:]
  │   - ticket_order_id
  │   - ticket_id
  │   - ticket_code
  │   - qr_code_path
  │   - qty = 1
  │   - price
  │   - is_used = false
  │   ↓
  │ [Ulangi untuk tiket berikutnya]
  └─────────────────────────┘
  ↓
[Commit transaction]
  ↓
[Redirect ke halaman pembayaran]
  ↓
END
```

---

## 3. Upload Bukti Pembayaran

### Deskripsi
Flowchart untuk upload bukti transfer pembayaran tiket.

### Flowchart

```
START
  ↓
[User di halaman pembayaran]
  ↓
[Tampilkan informasi order:]
  - Kode order
  - Total harga
  - Daftar tiket
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
  Format: YYYYMMDDHHMMSS_proof_uniqid.ext
  ↓
[Simpan file ke /public/payment-proofs/]
  ↓
[Update tabel ticket_orders:]
  - payment_proof = path file
  - status tetap 'pending'
  ↓
[Tampilkan notifikasi sukses]
  ↓
[Redirect ke halaman download tiket]
  ↓
END
```

---

## 4. Download Tiket

### Deskripsi
Flowchart untuk download tiket setelah pembayaran dikonfirmasi.

### Flowchart

```
START
  ↓
[User mengakses halaman download]
  ↓
[Query database: ambil order berdasarkan order_code]
  ↓
{Order ditemukan?}
  ├─ NO → [Error 404: Order tidak ditemukan] → END
  └─ YES ↓
       ↓
{Order milik user yang login?}
  ├─ NO → [Error 403: Unauthorized] → END
  └─ YES ↓
       ↓
[Ambil semua ticket_order_items untuk order ini]
  ↓
[Cek status order]
  ↓
{Status = 'confirmed'?}
  ├─ YES → [Tampilkan halaman download]
  │        ↓
  │        [Tampilkan pesan: "Pembayaran berhasil diverifikasi"]
  │        ↓
  │        [Tampilkan daftar tiket dengan QR code]
  │        ↓
  │        [Aktifkan tombol "Download PDF"]
  │        ↓
  │        [Aktifkan tombol "Print Tiket"]
  │        ↓
  │        [User klik tombol download]
  │        ↓
  │        [Generate PDF tiket dengan:]
  │          - Kode tiket
  │          - QR code
  │          - Nama pengunjung
  │          - Tanggal kunjungan
  │          - Jenis tiket
  │        ↓
  │        [Download file PDF]
  │        ↓
  │        END
  │
  ├─ Status = 'pending' → [Tampilkan halaman download]
  │                       ↓
  │                       [Tampilkan pesan: "Menunggu verifikasi admin"]
  │                       ↓
  │                       [Tampilkan daftar tiket]
  │                       ↓
  │                       [Disabled tombol "Download PDF" (abu-abu)]
  │                       ↓
  │                       [Disabled tombol "Print Tiket" (abu-abu)]
  │                       ↓
  │                       [Tampilkan alert: "Menunggu verifikasi admin"]
  │                       ↓
  │                       END
  │
  └─ Status = 'rejected' → [Tampilkan halaman download]
                           ↓
                           [Tampilkan pesan: "Pembayaran ditolak"]
                           ↓
                           [Tampilkan alasan penolakan]
                           ↓
                           [Disabled tombol download]
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
5. **Predefined Process** (Rectangle with double lines) - Subprocess
6. **Loop** (Hexagon) - Perulangan

### Warna yang Disarankan
- **START/END**: Hijau teal (#14B8A6)
- **Process**: Biru muda (#E3F2FD)
- **Decision**: Kuning (#FFF59D)
- **Database Operation**: Ungu muda (#E1BEE7)
- **Error**: Merah muda (#FFCDD2)
- **Success**: Hijau muda (#C8E6C9)
- **Loop**: Oranye muda (#FFE0B2)

### Tips
- Gunakan swimlane untuk memisahkan User dan System
- Tandai proses database dengan warna berbeda
- Gunakan connector yang jelas untuk decision branch
- Tambahkan notes untuk penjelasan kompleks

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Pembelian Tiket  
**Sistem**: Banyu Biru Ticketing & Booking System

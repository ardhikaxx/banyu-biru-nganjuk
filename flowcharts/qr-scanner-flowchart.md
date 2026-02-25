# Flowchart - Fitur QR Scanner Verifikasi Tiket

## Daftar Isi
1. [Scan QR Code Tiket](#1-scan-qr-code-tiket)
2. [Input Manual Kode Tiket](#2-input-manual-kode-tiket)
3. [Verifikasi Tiket](#3-verifikasi-tiket)
4. [Tandai Tiket Sebagai Dipakai](#4-tandai-tiket-sebagai-dipakai)

---

## 1. Scan QR Code Tiket

### Deskripsi
Flowchart untuk scan QR code tiket menggunakan kamera.

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
[Admin mengakses halaman "Verifikasi Tiket"]
  ↓
[Tampilkan 2 metode verifikasi:]
  - Scan QR Code (aktif)
  - Input Manual
  ↓
[Initialize html5-qrcode library]
  ↓
[Request akses kamera]
  ↓
{Izin kamera diberikan?}
  ├─ NO → [Tampilkan error: "Tidak dapat mengakses kamera"]
  │       ↓
  │       [Sarankan gunakan Input Manual]
  │       ↓
  │       END
  └─ YES ↓
       ↓
[Tampilkan preview kamera]
  ↓
[Tampilkan frame scanner dengan overlay]
  ↓
[Mulai scanning dengan fps: 10]
  ↓
[Loop: Deteksi QR code]
  ↓
  ┌─────────────────────────┐
  │ [Scan frame kamera]
  │   ↓
  │ {QR code terdeteksi?}
  │   ├─ NO → [Lanjut scan frame berikutnya]
  │   │       ↓
  │   │       [Ulangi loop]
  │   │
  │   └─ YES ↓
  │        ↓
  │        [Decode QR code]
  │        ↓
  │        [Ambil kode tiket dari QR]
  │        ↓
  │        [Stop scanner]
  │        ↓
  │        [Hide kamera]
  │        ↓
  │        [Tampilkan: "Memproses QR Code..."]
  │        ↓
  │        [Submit form dengan kode tiket]
  │        ↓
  │        [Lihat flowchart #3: Verifikasi Tiket]
  └─────────────────────────┘
  ↓
END
```


---

## 2. Input Manual Kode Tiket

### Deskripsi
Flowchart untuk input kode tiket secara manual tanpa scan QR.

### Flowchart

```
START
  ↓
[Admin di halaman "Verifikasi Tiket"]
  ↓
[Admin klik metode "Input Manual"]
  ↓
[Stop scanner QR (jika aktif)]
  ↓
[Hide section QR scanner]
  ↓
[Tampilkan section input manual]
  ↓
[Tampilkan form input:]
  - Input text untuk kode tiket
  - Placeholder: "AT-XXXXX"
  - Tombol "Cek Tiket"
  ↓
[Admin mengetik kode tiket]
  ↓
[Admin klik tombol "Cek Tiket"]
  ↓
<Validasi input>
  ↓
{Kode tiket terisi?}
  ├─ NO → [Error: "Kode tiket wajib diisi"]
  │       ↓
  │       [Focus ke input]
  │       ↓
  │       END
  └─ YES ↓
       ↓
[Submit form dengan kode tiket]
  ↓
[Lihat flowchart #3: Verifikasi Tiket]
  ↓
END
```

---

## 3. Verifikasi Tiket

### Deskripsi
Flowchart untuk memverifikasi kode tiket dan menampilkan hasilnya.

### Flowchart

```
START
  ↓
[Terima kode tiket dari QR scan atau input manual]
  ↓
[Query database: cari ticket_order_items]
  ↓
[WHERE ticket_code = kode yang diinput]
  ↓
[Include relasi:]
  - order.user
  - ticket
  ↓
{Tiket ditemukan?}
  ├─ NO → [Tampilkan error: "Tiket tidak ditemukan"]
  │       ↓
  │       [Tampilkan tombol "Scan Lagi"]
  │       ↓
  │       END
  └─ YES ↓
       ↓
[Ambil data tiket lengkap]
  ↓
[Cek status tiket]
  ↓
{Tiket sudah dipakai (is_used = true)?}
  ├─ YES → [Tampilkan card hasil dengan border merah]
  │        ↓
  │        [Tampilkan informasi:]
  │          - Kode Tiket
  │          - Nama Pemesan
  │          - Jenis Tiket
  │          - Tanggal Kunjungan
  │          - Status: "Sudah Dipakai" (badge merah)
  │        ↓
  │        [Hide tombol "Tandai Sebagai Dipakai"]
  │        ↓
  │        [Tampilkan tombol "Scan Lagi"]
  │        ↓
  │        END
  │
  └─ NO (is_used = false) → [Tampilkan card hasil dengan border hijau]
                            ↓
                            [Tampilkan informasi:]
                              - Kode Tiket
                              - Nama Pemesan
                              - Jenis Tiket
                              - Tanggal Kunjungan
                              - Status: "Valid" (badge hijau)
                            ↓
                            [Tampilkan tombol "Tandai Sebagai Dipakai"]
                            ↓
                            [Tampilkan tombol "Scan Lagi"]
                            ↓
                            END
```

---

## 4. Tandai Tiket Sebagai Dipakai

### Deskripsi
Flowchart untuk menandai tiket yang sudah digunakan.

### Flowchart

```
START
  ↓
[Admin melihat hasil verifikasi tiket valid]
  ↓
[Admin klik tombol "Tandai Sebagai Dipakai"]
  ↓
[Submit form dengan:]
  - ticket_code
  - mark_used = 1
  ↓
[Query database: cari ticket_order_items]
  ↓
[WHERE ticket_code = kode tiket]
  ↓
{Tiket ditemukan?}
  ├─ NO → [Error: "Tiket tidak ditemukan"] → END
  └─ YES ↓
       ↓
{Tiket sudah dipakai?}
  ├─ YES → [Error: "Tiket sudah ditandai dipakai sebelumnya"]
  │        ↓
  │        [Kembali ke halaman verifikasi]
  │        ↓
  │        END
  └─ NO ↓
       ↓
[Update tabel ticket_order_items:]
  - is_used = true
  - used_at = waktu sekarang
  ↓
[Simpan perubahan ke database]
  ↓
[Tampilkan notifikasi sukses:]
  "Tiket berhasil ditandai sebagai dipakai"
  ↓
[Refresh halaman verifikasi]
  ↓
[Tampilkan hasil dengan status "Sudah Dipakai"]
  ↓
[Hide tombol "Tandai Sebagai Dipakai"]
  ↓
[Tampilkan tombol "Scan Lagi"]
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
6. **Manual Operation** (Trapezoid) - Operasi manual admin
7. **Loop** (Hexagon) - Perulangan

### Warna yang Disarankan
- **START/END**: Hijau teal (#14B8A6)
- **Process**: Biru muda (#E3F2FD)
- **Decision**: Kuning (#FFF59D)
- **Database Operation**: Ungu muda (#E1BEE7)
- **Camera/Scanner**: Biru tua muda (#BBDEFB)
- **Valid**: Hijau muda (#C8E6C9)
- **Used/Invalid**: Merah muda (#FFCDD2)
- **Loop**: Oranye muda (#FFE0B2)

### Tips
- Gunakan swimlane untuk memisahkan Admin, Camera, dan System
- Tandai proses scanning dengan warna khusus
- Gunakan loop symbol untuk proses scanning berulang
- Tambahkan notes untuk library yang digunakan (html5-qrcode)

---

**Dibuat**: 25 Februari 2026  
**Fitur**: QR Scanner Verifikasi Tiket  
**Sistem**: Banyu Biru Ticketing & Booking System

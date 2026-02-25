# Flowchart - Fitur Manajemen Rekening Bank

## Daftar Isi
1. [Lihat Daftar Rekening Bank](#1-lihat-daftar-rekening-bank)
2. [Tambah Rekening Bank](#2-tambah-rekening-bank)
3. [Edit Rekening Bank](#3-edit-rekening-bank)
4. [Hapus Rekening Bank](#4-hapus-rekening-bank)
5. [Toggle Status Aktif Rekening](#5-toggle-status-aktif-rekening)

---

## 1. Lihat Daftar Rekening Bank

### Deskripsi
Flowchart untuk admin melihat daftar rekening bank.

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
[Admin mengakses menu "Rekening Bank"]
  ↓
[Query database: ambil semua bank_accounts]
  ↓
[Urutkan berdasarkan ID]
  ↓
[Tampilkan tabel rekening:]
  - Nama Bank
  - Nomor Rekening
  - Atas Nama
  - Status (Aktif/Nonaktif)
  - Aksi (Edit, Hapus)
  ↓
[Tampilkan tombol "Tambah Rekening"]
  ↓
END
```

---

## 2. Tambah Rekening Bank

### Deskripsi
Flowchart untuk admin menambah rekening bank baru.

### Flowchart

```
START
  ↓
[Admin di halaman daftar rekening]
  ↓
[Admin klik tombol "Tambah Rekening"]
  ↓
[Redirect ke halaman form tambah rekening]
  ↓
[Tampilkan form:]
  - Nama Bank
  - Nomor Rekening
  - Atas Nama
  - Status Aktif (checkbox)
  ↓
[Admin mengisi form]
  ↓
[Admin klik tombol "Simpan"]
  ↓
<Validasi input>
  ↓
{Nama bank terisi?}
  ├─ NO → [Error: "Nama bank wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Nomor rekening terisi?}
  ├─ NO → [Error: "Nomor rekening wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Nomor rekening hanya angka?}
  ├─ NO → [Error: "Nomor rekening harus angka"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Atas nama terisi?}
  ├─ NO → [Error: "Atas nama wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Simpan data ke tabel bank_accounts:]
  - bank_name
  - account_number
  - account_holder
  - is_active (default: true)
  ↓
[Tampilkan notifikasi sukses:]
  "Rekening bank berhasil ditambahkan"
  ↓
[Redirect ke halaman daftar rekening]
  ↓
END
```

---

## 3. Edit Rekening Bank

### Deskripsi
Flowchart untuk admin mengedit data rekening bank.

### Flowchart

```
START
  ↓
[Admin di halaman daftar rekening]
  ↓
[Admin klik tombol "Edit" pada rekening]
  ↓
[Query database: ambil bank_account berdasarkan ID]
  ↓
{Rekening ditemukan?}
  ├─ NO → [Error 404: Rekening tidak ditemukan] → END
  └─ YES ↓
       ↓
[Redirect ke halaman form edit rekening]
  ↓
[Tampilkan form dengan data rekening:]
  - Nama Bank (terisi)
  - Nomor Rekening (terisi)
  - Atas Nama (terisi)
  - Status Aktif (checked/unchecked)
  ↓
[Admin mengubah data]
  ↓
[Admin klik tombol "Update"]
  ↓
<Validasi input>
  ↓
{Nama bank terisi?}
  ├─ NO → [Error: "Nama bank wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Nomor rekening terisi?}
  ├─ NO → [Error: "Nomor rekening wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Nomor rekening hanya angka?}
  ├─ NO → [Error: "Nomor rekening harus angka"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Atas nama terisi?}
  ├─ NO → [Error: "Atas nama wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Update tabel bank_accounts:]
  - bank_name
  - account_number
  - account_holder
  - is_active
  ↓
[Simpan perubahan ke database]
  ↓
[Tampilkan notifikasi sukses:]
  "Rekening bank berhasil diupdate"
  ↓
[Redirect ke halaman daftar rekening]
  ↓
END
```

---

## 4. Hapus Rekening Bank

### Deskripsi
Flowchart untuk admin menghapus rekening bank.

### Flowchart

```
START
  ↓
[Admin di halaman daftar rekening]
  ↓
[Admin klik tombol "Hapus" pada rekening]
  ↓
[Tampilkan konfirmasi SweetAlert:]
  "Yakin ingin menghapus rekening ini?"
  ↓
{Admin konfirmasi?}
  ├─ NO (Batal) → [Tutup dialog] → END
  └─ YES ↓
       ↓
[Query database: ambil bank_account berdasarkan ID]
  ↓
{Rekening ditemukan?}
  ├─ NO → [Error: "Rekening tidak ditemukan"] → END
  └─ YES ↓
       ↓
[Hapus rekening dari database]
  ↓
[Tampilkan notifikasi sukses:]
  "Rekening bank berhasil dihapus"
  ↓
[Refresh halaman daftar rekening]
  ↓
END
```

---

## 5. Toggle Status Aktif Rekening

### Deskripsi
Flowchart untuk mengaktifkan/menonaktifkan rekening bank.

### Flowchart

```
START
  ↓
[Admin di halaman edit rekening]
  ↓
[Tampilkan checkbox "Status Aktif"]
  ↓
{Rekening saat ini aktif?}
  ├─ YES → [Checkbox checked]
  └─ NO → [Checkbox unchecked]
  ↓
[Admin toggle checkbox]
  ↓
[Admin klik tombol "Update"]
  ↓
[Update tabel bank_accounts:]
  - is_active = nilai checkbox (true/false)
  ↓
{is_active = true?}
  ├─ YES → [Rekening muncul di halaman pembayaran user]
  │        ↓
  │        [User dapat transfer ke rekening ini]
  │        ↓
  │        [Notifikasi: "Rekening diaktifkan"]
  │
  └─ NO → [Rekening tidak muncul di halaman pembayaran]
          ↓
          [User tidak dapat transfer ke rekening ini]
          ↓
          [Notifikasi: "Rekening dinonaktifkan"]
  ↓
[Redirect ke halaman daftar rekening]
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
6. **Document** (Rectangle with wavy bottom) - Form

### Warna yang Disarankan
- **START/END**: Hijau teal (#14B8A6)
- **Process**: Biru muda (#E3F2FD)
- **Decision**: Kuning (#FFF59D)
- **Database Operation**: Ungu muda (#E1BEE7)
- **Form**: Biru tua muda (#BBDEFB)
- **Create**: Hijau muda (#C8E6C9)
- **Update**: Biru muda (#B3E5FC)
- **Delete**: Merah muda (#FFCDD2)
- **Toggle**: Oranye muda (#FFE0B2)

### Tips
- Gunakan swimlane untuk memisahkan Admin dan System
- Tandai operasi CRUD dengan warna berbeda
- Gunakan connector yang jelas untuk decision branch
- Tambahkan notes untuk validasi nomor rekening

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Manajemen Rekening Bank  
**Sistem**: Banyu Biru Ticketing & Booking System

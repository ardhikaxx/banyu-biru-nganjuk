# Flowchart - Fitur Manajemen Tiket Admin

## Daftar Isi
1. [Lihat Daftar Tiket](#1-lihat-daftar-tiket)
2. [Tambah Tiket Baru](#2-tambah-tiket-baru)
3. [Edit Tiket](#3-edit-tiket)
4. [Hapus Tiket](#4-hapus-tiket)
5. [Toggle Status Aktif Tiket](#5-toggle-status-aktif-tiket)

---

## 1. Lihat Daftar Tiket

### Deskripsi
Flowchart untuk admin melihat daftar semua tiket.

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
[Admin mengakses menu "Tiket"]
  ↓
[Query database: ambil semua tickets]
  ↓
[Urutkan berdasarkan ID]
  ↓
[Tampilkan tabel tiket:]
  - Nama Tiket
  - Harga
  - Deskripsi
  - Status (Aktif/Nonaktif)
  - Aksi (Edit, Hapus)
  ↓
[Tampilkan tombol "Tambah Tiket"]
  ↓
END
```

---

## 2. Tambah Tiket Baru

### Deskripsi
Flowchart untuk admin menambah tiket baru.

### Flowchart

```
START
  ↓
[Admin di halaman daftar tiket]
  ↓
[Admin klik tombol "Tambah Tiket"]
  ↓
[Redirect ke halaman form tambah tiket]
  ↓
[Tampilkan form:]
  - Nama Tiket
  - Harga
  - Deskripsi
  - Status Aktif (checkbox)
  ↓
[Admin mengisi form]
  ↓
[Admin klik tombol "Simpan"]
  ↓
<Validasi input>
  ↓
{Nama tiket terisi?}
  ├─ NO → [Error: "Nama tiket wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Harga terisi dan valid?}
  ├─ NO → [Error: "Harga wajib diisi dan harus angka"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Harga >= 0?}
  ├─ NO → [Error: "Harga tidak boleh negatif"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Simpan data ke tabel tickets:]
  - name
  - price
  - description
  - is_active (default: true)
  ↓
[Tampilkan notifikasi sukses:]
  "Tiket berhasil ditambahkan"
  ↓
[Redirect ke halaman daftar tiket]
  ↓
END
```


---

## 3. Edit Tiket

### Deskripsi
Flowchart untuk admin mengedit data tiket.

### Flowchart

```
START
  ↓
[Admin di halaman daftar tiket]
  ↓
[Admin klik tombol "Edit" pada tiket]
  ↓
[Query database: ambil tiket berdasarkan ID]
  ↓
{Tiket ditemukan?}
  ├─ NO → [Error 404: Tiket tidak ditemukan] → END
  └─ YES ↓
       ↓
[Redirect ke halaman form edit tiket]
  ↓
[Tampilkan form dengan data tiket:]
  - Nama Tiket (terisi)
  - Harga (terisi)
  - Deskripsi (terisi)
  - Status Aktif (checked/unchecked)
  ↓
[Admin mengubah data]
  ↓
[Admin klik tombol "Update"]
  ↓
<Validasi input>
  ↓
{Nama tiket terisi?}
  ├─ NO → [Error: "Nama tiket wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Harga terisi dan valid?}
  ├─ NO → [Error: "Harga wajib diisi dan harus angka"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Harga >= 0?}
  ├─ NO → [Error: "Harga tidak boleh negatif"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Update tabel tickets:]
  - name
  - price
  - description
  - is_active
  ↓
[Simpan perubahan ke database]
  ↓
[Tampilkan notifikasi sukses:]
  "Tiket berhasil diupdate"
  ↓
[Redirect ke halaman daftar tiket]
  ↓
END
```

---

## 4. Hapus Tiket

### Deskripsi
Flowchart untuk admin menghapus tiket.

### Flowchart

```
START
  ↓
[Admin di halaman daftar tiket]
  ↓
[Admin klik tombol "Hapus" pada tiket]
  ↓
[Tampilkan konfirmasi SweetAlert:]
  "Yakin ingin menghapus tiket ini?"
  ↓
{Admin konfirmasi?}
  ├─ NO (Batal) → [Tutup dialog] → END
  └─ YES ↓
       ↓
[Query database: ambil tiket berdasarkan ID]
  ↓
{Tiket ditemukan?}
  ├─ NO → [Error: "Tiket tidak ditemukan"] → END
  └─ YES ↓
       ↓
[Cek apakah tiket pernah digunakan]
  ↓
[Query: cek ticket_order_items dengan ticket_id ini]
  ↓
{Tiket pernah digunakan?}
  ├─ YES → [Error: "Tiket tidak dapat dihapus karena sudah pernah digunakan"]
  │        ↓
  │        [Sarankan: nonaktifkan tiket saja]
  │        ↓
  │        END
  └─ NO ↓
       ↓
[Hapus tiket dari database]
  ↓
[Tampilkan notifikasi sukses:]
  "Tiket berhasil dihapus"
  ↓
[Refresh halaman daftar tiket]
  ↓
END
```

---

## 5. Toggle Status Aktif Tiket

### Deskripsi
Flowchart untuk mengaktifkan/menonaktifkan tiket.

### Flowchart

```
START
  ↓
[Admin di halaman edit tiket]
  ↓
[Tampilkan checkbox "Status Aktif"]
  ↓
{Tiket saat ini aktif?}
  ├─ YES → [Checkbox checked]
  └─ NO → [Checkbox unchecked]
  ↓
[Admin toggle checkbox]
  ↓
[Admin klik tombol "Update"]
  ↓
[Update tabel tickets:]
  - is_active = nilai checkbox (true/false)
  ↓
{is_active = true?}
  ├─ YES → [Tiket akan muncul di halaman user]
  │        ↓
  │        [Tiket dapat dibeli]
  │        ↓
  │        [Notifikasi: "Tiket diaktifkan"]
  │
  └─ NO → [Tiket tidak muncul di halaman user]
          ↓
          [Tiket tidak dapat dibeli]
          ↓
          [Notifikasi: "Tiket dinonaktifkan"]
  ↓
[Redirect ke halaman daftar tiket]
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
- Tambahkan notes untuk validasi penting

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Manajemen Tiket Admin  
**Sistem**: Banyu Biru Ticketing & Booking System

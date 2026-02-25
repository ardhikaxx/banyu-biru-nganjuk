# Flowchart - Fitur Manajemen Admin

## Daftar Isi
1. [Lihat Daftar Admin](#1-lihat-daftar-admin)
2. [Tambah Admin Baru](#2-tambah-admin-baru)
3. [Edit Admin](#3-edit-admin)
4. [Hapus Admin](#4-hapus-admin)
5. [Edit Profil Admin](#5-edit-profil-admin)

---

## 1. Lihat Daftar Admin

### Deskripsi
Flowchart untuk admin melihat daftar semua admin.

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
[Admin mengakses menu "Admin"]
  ↓
[Query database: ambil users dengan role 'admin']
  ↓
[Urutkan berdasarkan nama]
  ↓
[Tampilkan tabel admin:]
  - Nama
  - Email
  - Tanggal Dibuat
  - Aksi (Edit, Hapus)
  ↓
[Tampilkan tombol "Tambah Admin"]
  ↓
END
```

---

## 2. Tambah Admin Baru

### Deskripsi
Flowchart untuk menambah admin baru ke sistem.

### Flowchart

```
START
  ↓
[Admin di halaman daftar admin]
  ↓
[Admin klik tombol "Tambah Admin"]
  ↓
[Redirect ke halaman form tambah admin]
  ↓
[Tampilkan form:]
  - Nama
  - Email
  - Password
  - Konfirmasi Password
  ↓
[Admin mengisi form]
  ↓
[Admin klik tombol "Simpan"]
  ↓
<Validasi input>
  ↓
{Nama terisi?}
  ├─ NO → [Error: "Nama wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Format email valid?}
  ├─ NO → [Error: "Format email tidak valid"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Query database: cek email sudah terdaftar]
  ↓
{Email sudah ada?}
  ├─ YES → [Error: "Email sudah terdaftar"] → [Kembali ke form] → END
  └─ NO ↓
       ↓
{Password minimal 8 karakter?}
  ├─ NO → [Error: "Password minimal 8 karakter"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Password = Konfirmasi Password?}
  ├─ NO → [Error: "Konfirmasi password tidak cocok"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Hash password menggunakan bcrypt]
  ↓
[Simpan data ke tabel users:]
  - name
  - email
  - password (hashed)
  ↓
[Assign role 'admin' ke user baru]
  ↓
[Tampilkan notifikasi sukses:]
  "Admin berhasil ditambahkan"
  ↓
[Redirect ke halaman daftar admin]
  ↓
END
```


---

## 3. Edit Admin

### Deskripsi
Flowchart untuk mengedit data admin.

### Flowchart

```
START
  ↓
[Admin di halaman daftar admin]
  ↓
[Admin klik tombol "Edit" pada admin]
  ↓
[Query database: ambil user berdasarkan ID]
  ↓
{User ditemukan?}
  ├─ NO → [Error 404: Admin tidak ditemukan] → END
  └─ YES ↓
       ↓
{User memiliki role 'admin'?}
  ├─ NO → [Error: "User bukan admin"] → END
  └─ YES ↓
       ↓
[Redirect ke halaman form edit admin]
  ↓
[Tampilkan form dengan data admin:]
  - Nama (terisi)
  - Email (terisi)
  - Password (kosong, opsional)
  - Konfirmasi Password (kosong, opsional)
  ↓
[Admin mengubah data]
  ↓
[Admin klik tombol "Update"]
  ↓
<Validasi input>
  ↓
{Nama terisi?}
  ├─ NO → [Error: "Nama wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Format email valid?}
  ├─ NO → [Error: "Format email tidak valid"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Query: cek email sudah digunakan user lain]
  ↓
{Email digunakan user lain?}
  ├─ YES → [Error: "Email sudah terdaftar"] → [Kembali ke form] → END
  └─ NO ↓
       ↓
{Password diisi?}
  ├─ YES → {Password minimal 8 karakter?}
  │        ├─ NO → [Error: "Password minimal 8 karakter"] → [Kembali ke form] → END
  │        └─ YES ↓
  │             ↓
  │             {Password = Konfirmasi Password?}
  │             ├─ NO → [Error: "Konfirmasi password tidak cocok"] → [Kembali ke form] → END
  │             └─ YES ↓
  │                  ↓
  │                  [Hash password baru]
  │                  ↓
  │                  [Update dengan password baru]
  │
  └─ NO → [Update tanpa mengubah password]
  ↓
[Update tabel users:]
  - name
  - email
  - password (jika diisi)
  ↓
[Simpan perubahan ke database]
  ↓
[Tampilkan notifikasi sukses:]
  "Admin berhasil diupdate"
  ↓
[Redirect ke halaman daftar admin]
  ↓
END
```

---

## 4. Hapus Admin

### Deskripsi
Flowchart untuk menghapus admin dari sistem.

### Flowchart

```
START
  ↓
[Admin di halaman daftar admin]
  ↓
[Admin klik tombol "Hapus" pada admin]
  ↓
[Tampilkan konfirmasi SweetAlert:]
  "Yakin ingin menghapus admin ini?"
  ↓
{Admin konfirmasi?}
  ├─ NO (Batal) → [Tutup dialog] → END
  └─ YES ↓
       ↓
[Query database: ambil user berdasarkan ID]
  ↓
{User ditemukan?}
  ├─ NO → [Error: "Admin tidak ditemukan"] → END
  └─ YES ↓
       ↓
{User adalah admin yang sedang login?}
  ├─ YES → [Error: "Tidak dapat menghapus akun sendiri"]
  │        ↓
  │        END
  └─ NO ↓
       ↓
[Cek apakah admin pernah melakukan verifikasi]
  ↓
[Query: cek ticket_orders dengan confirmed_by = admin_id]
  ↓
[Query: cek bookings dengan confirmed_by = admin_id]
  ↓
{Admin pernah verifikasi transaksi?}
  ├─ YES → [Error: "Admin tidak dapat dihapus karena ada riwayat verifikasi"]
  │        ↓
  │        [Sarankan: nonaktifkan akun saja]
  │        ↓
  │        END
  └─ NO ↓
       ↓
[Hapus role 'admin' dari user]
  ↓
[Hapus user dari database]
  ↓
[Tampilkan notifikasi sukses:]
  "Admin berhasil dihapus"
  ↓
[Refresh halaman daftar admin]
  ↓
END
```

---

## 5. Edit Profil Admin

### Deskripsi
Flowchart untuk admin mengedit profil sendiri.

### Flowchart

```
START
  ↓
[Admin mengakses menu "Profil"]
  ↓
[Query database: ambil data admin yang login]
  ↓
[Tampilkan halaman profil]
  ↓
[Tampilkan form dengan data admin:]
  - Nama (terisi)
  - Email (terisi)
  - Nomor Telepon (terisi/kosong)
  - Alamat (terisi/kosong)
  - Password Baru (kosong, opsional)
  - Konfirmasi Password (kosong, opsional)
  ↓
[Admin mengubah data]
  ↓
[Admin klik tombol "Update Profil"]
  ↓
<Validasi input>
  ↓
{Nama terisi?}
  ├─ NO → [Error: "Nama wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Format email valid?}
  ├─ NO → [Error: "Format email tidak valid"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Query: cek email sudah digunakan user lain]
  ↓
{Email digunakan user lain?}
  ├─ YES → [Error: "Email sudah terdaftar"] → [Kembali ke form] → END
  └─ NO ↓
       ↓
{Password baru diisi?}
  ├─ YES → {Password minimal 8 karakter?}
  │        ├─ NO → [Error: "Password minimal 8 karakter"] → [Kembali ke form] → END
  │        └─ YES ↓
  │             ↓
  │             {Password = Konfirmasi Password?}
  │             ├─ NO → [Error: "Konfirmasi password tidak cocok"] → [Kembali ke form] → END
  │             └─ YES ↓
  │                  ↓
  │                  [Hash password baru]
  │                  ↓
  │                  [Update dengan password baru]
  │
  └─ NO → [Update tanpa mengubah password]
  ↓
[Update tabel users:]
  - name
  - email
  - phone (jika diisi)
  - address (jika diisi)
  - password (jika diisi)
  ↓
[Simpan perubahan ke database]
  ↓
[Update session dengan data baru]
  ↓
[Tampilkan notifikasi sukses:]
  "Profil berhasil diupdate"
  ↓
[Refresh halaman profil]
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
- **Security Check**: Oranye muda (#FFE0B2)

### Tips
- Gunakan swimlane untuk memisahkan Admin dan System
- Tandai operasi CRUD dengan warna berbeda
- Gunakan connector yang jelas untuk decision branch
- Tambahkan notes untuk security checks penting
- Highlight proses hashing password

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Manajemen Admin  
**Sistem**: Banyu Biru Ticketing & Booking System

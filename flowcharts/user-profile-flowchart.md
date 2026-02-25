# Flowchart - Fitur Profil User

## Daftar Isi
1. [Lihat Profil User](#1-lihat-profil-user)
2. [Edit Profil User](#2-edit-profil-user)
3. [Ubah Password User](#3-ubah-password-user)

---

## 1. Lihat Profil User

### Deskripsi
Flowchart untuk user melihat profil sendiri.

### Flowchart

```
START
  ↓
{User sudah login?}
  ├─ NO → [Redirect ke halaman login] → END
  └─ YES ↓
       ↓
{User adalah admin?}
  ├─ YES → [Redirect ke profil admin] → END
  └─ NO ↓
       ↓
[User klik menu "Profil Saya" di dropdown navbar]
  ↓
[Query database: users]
  ↓
[Filter: id = user yang login]
  ↓
{User ditemukan?}
  ├─ NO → [Error: User tidak ditemukan] → [Logout] → END
  └─ YES ↓
       ↓
[Tampilkan halaman profil]
  ↓
[Tampilkan informasi user:]
  - Nama
  - Email
  - Nomor Telepon
  - Alamat
  - Tanggal Bergabung
  ↓
[Tampilkan tombol "Edit Profil"]
  ↓
END
```

---

## 2. Edit Profil User

### Deskripsi
Flowchart untuk user mengedit profil sendiri.

### Flowchart

```
START
  ↓
[User di halaman profil]
  ↓
[User klik tombol "Edit Profil"]
  ↓
[Tampilkan form edit profil dengan data user:]
  - Nama (terisi)
  - Email (terisi)
  - Nomor Telepon (terisi/kosong)
  - Alamat (terisi/kosong)
  ↓
[User mengubah data]
  ↓
[User klik tombol "Update Profil"]
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
[Query database: cek email sudah digunakan user lain]
  ↓
{Email digunakan user lain?}
  ├─ YES → [Error: "Email sudah terdaftar"] → [Kembali ke form] → END
  └─ NO ↓
       ↓
{Nomor telepon diisi?}
  ├─ YES → {Format nomor telepon valid?}
  │        ├─ NO → [Error: "Format nomor telepon tidak valid"] → [Kembali ke form] → END
  │        └─ YES → [Lanjut]
  └─ NO → [Lanjut]
  ↓
[Update tabel users:]
  - name
  - email
  - phone (jika diisi)
  - address (jika diisi)
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

## 3. Ubah Password User

### Deskripsi
Flowchart untuk user mengubah password sendiri.

### Flowchart

```
START
  ↓
[User di halaman profil]
  ↓
[User klik tombol "Ubah Password"]
  ↓
[Tampilkan form ubah password:]
  - Password Lama
  - Password Baru
  - Konfirmasi Password Baru
  ↓
[User mengisi form]
  ↓
[User klik tombol "Update Password"]
  ↓
<Validasi input>
  ↓
{Password lama terisi?}
  ├─ NO → [Error: "Password lama wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Query database: ambil user yang login]
  ↓
[Verifikasi password lama dengan hash]
  ↓
{Password lama cocok?}
  ├─ NO → [Error: "Password lama salah"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Password baru terisi?}
  ├─ NO → [Error: "Password baru wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Password baru minimal 8 karakter?}
  ├─ NO → [Error: "Password minimal 8 karakter"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Password baru = Konfirmasi Password?}
  ├─ NO → [Error: "Konfirmasi password tidak cocok"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Password baru berbeda dari password lama?}
  ├─ NO → [Error: "Password baru harus berbeda dari password lama"]
  │       ↓
  │       [Kembali ke form]
  │       ↓
  │       END
  └─ YES ↓
       ↓
[Hash password baru menggunakan bcrypt]
  ↓
[Update tabel users:]
  - password = password baru (hashed)
  ↓
[Simpan perubahan ke database]
  ↓
[Tampilkan notifikasi sukses:]
  "Password berhasil diubah"
  ↓
[Redirect ke halaman profil]
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
7. **Manual Input** (Parallelogram with slanted top) - Input user

### Warna yang Disarankan
- **START/END**: Hijau teal (#14B8A6)
- **Process**: Biru muda (#E3F2FD)
- **Decision**: Kuning (#FFF59D)
- **Database Operation**: Ungu muda (#E1BEE7)
- **Form**: Biru tua muda (#BBDEFB)
- **Update**: Biru muda (#B3E5FC)
- **Security Check**: Oranye muda (#FFE0B2)
- **Success**: Hijau muda (#C8E6C9)
- **Error**: Merah muda (#FFCDD2)

### Tips
- Gunakan swimlane untuk memisahkan User dan System
- Tandai proses security check (password verification) dengan warna khusus
- Gunakan connector yang jelas untuk decision branch
- Tambahkan notes untuk validasi password
- Highlight proses hashing password

### Security Notes
- Password lama harus diverifikasi sebelum mengubah password
- Password baru harus di-hash menggunakan bcrypt
- Password baru harus berbeda dari password lama
- Session harus diupdate setelah perubahan data

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Profil User  
**Sistem**: Banyu Biru Ticketing & Booking System

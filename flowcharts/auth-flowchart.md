# Flowchart - Fitur Autentikasi

## Daftar Isi
1. [Login](#1-login)
2. [Register](#2-register)
3. [Logout](#3-logout)

---

## 1. Login

### Deskripsi
Flowchart untuk proses login user dan admin ke sistem.

### Flowchart

```
START
  ↓
[User mengakses halaman login]
  ↓
[Tampilkan form login]
  ↓
[User input email dan password]
  ↓
[User klik tombol Login]
  ↓
<Validasi format email>
  ↓
{Email valid?}
  ├─ NO → [Tampilkan error: "Format email salah"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
<Validasi password tidak kosong>
  ↓
{Password terisi?}
  ├─ NO → [Tampilkan error: "Password wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Query database: cari user berdasarkan email]
  ↓
{User ditemukan?}
  ├─ NO → [Tampilkan error: "Email tidak terdaftar"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Ambil data user dari database]
  ↓
[Verifikasi password dengan hash]
  ↓
{Password cocok?}
  ├─ NO → [Tampilkan error: "Password salah"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Buat session untuk user]
  ↓
[Simpan data user ke session]
  ↓
[Cek role user]
  ↓
{Role = Admin?}
  ├─ YES → [Redirect ke /admin/dashboard]
  │        ↓
  │        [Tampilkan dashboard admin]
  │        ↓
  │        END
  │
  └─ NO (User) → [Redirect ke /]
                 ↓
                 [Tampilkan halaman beranda]
                 ↓
                 END
```

### Simbol yang Digunakan
- `[ ]` = Proses/Action
- `{ }` = Decision/Kondisi
- `< >` = Subprocess
- `→` = Flow direction
- `↓` = Flow continuation

---

## 2. Register

### Deskripsi
Flowchart untuk proses registrasi user baru.

### Flowchart

```
START
  ↓
[User mengakses halaman register]
  ↓
[Tampilkan form registrasi]
  ↓
[User input: nama, email, password, password confirmation]
  ↓
[User klik tombol Register]
  ↓
<Validasi input>
  ↓
{Nama terisi?}
  ├─ NO → [Error: "Nama wajib diisi"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
{Format email valid?}
  ├─ NO → [Error: "Format email salah"] → [Kembali ke form] → END
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
{Password = Password Confirmation?}
  ├─ NO → [Error: "Konfirmasi password tidak cocok"] → [Kembali ke form] → END
  └─ YES ↓
       ↓
[Hash password menggunakan bcrypt]
  ↓
[Simpan data user ke database]
  ↓
[Assign role "user" ke user baru]
  ↓
[Buat session untuk user]
  ↓
[Tampilkan notifikasi sukses]
  ↓
[Redirect ke halaman beranda]
  ↓
END
```

---

## 3. Logout

### Deskripsi
Flowchart untuk proses logout user/admin dari sistem.

### Flowchart

```
START
  ↓
[User klik tombol Logout]
  ↓
[Tampilkan konfirmasi SweetAlert]
  ↓
{User konfirmasi logout?}
  ├─ NO (Batal) → [Tutup dialog] → END
  └─ YES ↓
       ↓
[Tampilkan loading "Logging out..."]
  ↓
[Hapus session user]
  ↓
[Hapus remember token]
  ↓
[Clear authentication]
  ↓
[Redirect ke halaman login]
  ↓
[Tampilkan pesan "Berhasil logout"]
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
5. **Arrow** - Alur/flow

### Warna yang Disarankan
- **START/END**: Hijau teal (#14B8A6)
- **Process**: Biru muda (#E3F2FD)
- **Decision**: Kuning (#FFF59D)
- **Error**: Merah muda (#FFCDD2)
- **Success**: Hijau muda (#C8E6C9)

### Layout
- Gunakan vertical flow (top to bottom)
- Spacing konsisten antar simbol
- Label jelas pada setiap decision branch
- Gunakan connector yang rapi

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Autentikasi (Login, Register, Logout)  
**Sistem**: Banyu Biru Ticketing & Booking System

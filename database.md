# Dokumentasi Database - Sistem Tiket & Booking Banyu Biru

## Daftar Isi
1. [Overview](#overview)
2. [Diagram Relasi](#diagram-relasi)
3. [Tabel Users](#tabel-users)
4. [Tabel Tickets](#tabel-tickets)
5. [Tabel Ticket Orders](#tabel-ticket-orders)
6. [Tabel Ticket Order Items](#tabel-ticket-order-items)
7. [Tabel Places](#tabel-places)
8. [Tabel Bookings](#tabel-bookings)
9. [Tabel Bank Accounts](#tabel-bank-accounts)
10. [Tabel Settings](#tabel-settings)
11. [Tabel Permission (Spatie)](#tabel-permission-spatie)

---

## Overview

Database ini digunakan untuk sistem manajemen tiket masuk dan booking pendopo pada Pemandian Air Panas Banyu Biru Nganjuk. Sistem ini mendukung:
- Manajemen user dengan role (admin/user)
- Penjualan tiket masuk dengan QR code
- Booking tempat (pendopo)
- Verifikasi pembayaran
- Manajemen rekening bank

---

## Diagram Relasi

```
users (1) ----< (N) ticket_orders
users (1) ----< (N) bookings
users (1) ----< (N) ticket_orders (confirmed_by)
users (1) ----< (N) bookings (confirmed_by)

tickets (1) ----< (N) ticket_order_items
ticket_orders (1) ----< (N) ticket_order_items

places (1) ----< (N) bookings
```

---

## Tabel: users

**Deskripsi**: Menyimpan data pengguna sistem (admin dan user biasa)

### Struktur Kolom

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary Key |
| name | VARCHAR(100) | NO | - | Nama lengkap user |
| email | VARCHAR(150) | NO | - | Email (unique) |
| phone | VARCHAR(20) | YES | NULL | Nomor telepon |
| address | TEXT | YES | NULL | Alamat lengkap |
| avatar | VARCHAR(255) | YES | NULL | Path foto profil |
| email_verified_at | TIMESTAMP | YES | NULL | Waktu verifikasi email |
| password | VARCHAR(255) | NO | - | Password (hashed) |
| remember_token | VARCHAR(100) | YES | NULL | Token remember me |
| created_at | TIMESTAMP | YES | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | NULL | Waktu diupdate |

### Relasi

- **Has Many**: `ticket_orders` (sebagai pembeli)
- **Has Many**: `bookings` (sebagai pembooking)
- **Has Many**: `ticket_orders` (sebagai confirmer via `confirmed_by`)
- **Has Many**: `bookings` (sebagai confirmer via `confirmed_by`)
- **Has Many Through Spatie**: `roles` dan `permissions`

### Index

- PRIMARY KEY: `id`
- UNIQUE: `email`

---

## Tabel: tickets

**Deskripsi**: Menyimpan jenis-jenis tiket yang tersedia

### Struktur Kolom

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary Key |
| name | VARCHAR(100) | NO | - | Nama tiket (contoh: Tiket Masuk) |
| description | TEXT | YES | NULL | Deskripsi tiket |
| price | DECIMAL(10,2) | NO | - | Harga tiket |
| quota_per_day | INT | NO | 100 | Kuota per hari |
| is_active | BOOLEAN | NO | TRUE | Status aktif/nonaktif |
| created_at | TIMESTAMP | YES | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | NULL | Waktu diupdate |

### Relasi

- **Has Many**: `ticket_order_items`

### Index

- PRIMARY KEY: `id`

---

## Tabel: ticket_orders

**Deskripsi**: Menyimpan data pesanan tiket dari user

### Struktur Kolom

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary Key |
| user_id | BIGINT UNSIGNED | NO | - | Foreign Key ke users |
| order_code | VARCHAR(20) | NO | - | Kode order unik (AT-XXXXX) |
| visit_date | DATE | NO | - | Tanggal kunjungan |
| total_qty | INT | NO | - | Total jumlah tiket |
| total_price | DECIMAL(10,2) | NO | - | Total harga |
| payment_proof | VARCHAR(255) | YES | NULL | Path bukti pembayaran |
| status | ENUM | NO | 'pending' | Status: pending/confirmed/rejected |
| confirmed_at | TIMESTAMP | YES | NULL | Waktu dikonfirmasi |
| confirmed_by | BIGINT UNSIGNED | YES | NULL | Foreign Key ke users (admin) |
| rejection_note | TEXT | YES | NULL | Catatan penolakan |
| created_at | TIMESTAMP | YES | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | NULL | Waktu diupdate |

### Relasi

- **Belongs To**: `users` (via `user_id`)
- **Belongs To**: `users` (via `confirmed_by`)
- **Has Many**: `ticket_order_items`

### Index

- PRIMARY KEY: `id`
- UNIQUE: `order_code`
- FOREIGN KEY: `user_id` REFERENCES `users(id)` ON DELETE CASCADE
- FOREIGN KEY: `confirmed_by` REFERENCES `users(id)` ON DELETE SET NULL

---

## Tabel: ticket_order_items

**Deskripsi**: Menyimpan detail item tiket dalam setiap pesanan (1 item = 1 tiket fisik)

### Struktur Kolom

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary Key |
| ticket_order_id | BIGINT UNSIGNED | NO | - | Foreign Key ke ticket_orders |
| ticket_id | BIGINT UNSIGNED | NO | - | Foreign Key ke tickets |
| ticket_code | VARCHAR(20) | NO | - | Kode tiket unik (AT-XXXXX) |
| qr_code_path | VARCHAR(255) | NO | - | Path file QR code |
| qty | INT | NO | 1 | Quantity (selalu 1) |
| price | DECIMAL(10,2) | NO | - | Harga tiket saat dibeli |
| is_used | BOOLEAN | NO | FALSE | Status sudah dipakai/belum |
| used_at | TIMESTAMP | YES | NULL | Waktu digunakan |
| created_at | TIMESTAMP | YES | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | NULL | Waktu diupdate |

### Relasi

- **Belongs To**: `ticket_orders` (via `ticket_order_id`)
- **Belongs To**: `tickets` (via `ticket_id`)

### Index

- PRIMARY KEY: `id`
- UNIQUE: `ticket_code`
- FOREIGN KEY: `ticket_order_id` REFERENCES `ticket_orders(id)` ON DELETE CASCADE
- FOREIGN KEY: `ticket_id` REFERENCES `tickets(id)` ON DELETE CASCADE

---

## Tabel: places

**Deskripsi**: Menyimpan data tempat yang bisa dibooking (contoh: Pendopo)

### Struktur Kolom

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary Key |
| name | VARCHAR(100) | NO | - | Nama tempat |
| description | TEXT | YES | NULL | Deskripsi tempat |
| capacity | INT | NO | - | Kapasitas orang |
| price_per_day | DECIMAL(10,2) | NO | - | Harga per hari |
| image | VARCHAR(255) | YES | NULL | Path gambar tempat |
| is_active | BOOLEAN | NO | TRUE | Status aktif/nonaktif |
| created_at | TIMESTAMP | YES | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | NULL | Waktu diupdate |

### Relasi

- **Has Many**: `bookings`

### Index

- PRIMARY KEY: `id`

---

## Tabel: bookings

**Deskripsi**: Menyimpan data booking tempat dari user

### Struktur Kolom

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary Key |
| user_id | BIGINT UNSIGNED | NO | - | Foreign Key ke users |
| place_id | BIGINT UNSIGNED | NO | - | Foreign Key ke places |
| booking_code | VARCHAR(20) | NO | - | Kode booking unik (AB-XXXXX) |
| booking_date | DATE | NO | - | Tanggal booking |
| visitor_name | VARCHAR(100) | NO | - | Nama pengunjung |
| visitor_phone | VARCHAR(20) | NO | - | Nomor telepon pengunjung |
| visitor_address | TEXT | NO | - | Alamat pengunjung |
| num_persons | INT | NO | - | Jumlah orang |
| total_price | DECIMAL(10,2) | NO | - | Total harga |
| payment_proof | VARCHAR(255) | YES | NULL | Path bukti pembayaran |
| status | ENUM | NO | 'pending' | Status: pending/confirmed/rejected |
| confirmed_at | TIMESTAMP | YES | NULL | Waktu dikonfirmasi |
| confirmed_by | BIGINT UNSIGNED | YES | NULL | Foreign Key ke users (admin) |
| rejection_note | TEXT | YES | NULL | Catatan penolakan |
| notes | TEXT | YES | NULL | Catatan tambahan |
| created_at | TIMESTAMP | YES | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | NULL | Waktu diupdate |

### Relasi

- **Belongs To**: `users` (via `user_id`)
- **Belongs To**: `places` (via `place_id`)
- **Belongs To**: `users` (via `confirmed_by`)

### Index

- PRIMARY KEY: `id`
- UNIQUE: `booking_code`
- UNIQUE: `place_id, booking_date` (composite - 1 tempat hanya bisa dibooking 1x per hari)
- FOREIGN KEY: `user_id` REFERENCES `users(id)` ON DELETE CASCADE
- FOREIGN KEY: `place_id` REFERENCES `places(id)` ON DELETE CASCADE
- FOREIGN KEY: `confirmed_by` REFERENCES `users(id)` ON DELETE SET NULL

---

## Tabel: bank_accounts

**Deskripsi**: Menyimpan data rekening bank untuk pembayaran

### Struktur Kolom

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary Key |
| bank_name | VARCHAR(100) | NO | - | Nama bank |
| account_number | VARCHAR(50) | NO | - | Nomor rekening |
| account_name | VARCHAR(100) | NO | - | Nama pemilik rekening |
| is_active | BOOLEAN | NO | TRUE | Status aktif/nonaktif |
| created_at | TIMESTAMP | YES | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | NULL | Waktu diupdate |

### Relasi

- Tidak ada relasi langsung (standalone table)

### Index

- PRIMARY KEY: `id`

---

## Tabel: settings

**Deskripsi**: Menyimpan pengaturan sistem (key-value pairs)

### Struktur Kolom

| Kolom | Tipe | Nullable | Default | Keterangan |
|-------|------|----------|---------|------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary Key |
| key | VARCHAR(100) | NO | - | Key pengaturan (unique) |
| value | TEXT | YES | NULL | Value pengaturan |
| created_at | TIMESTAMP | YES | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | NULL | Waktu diupdate |

### Relasi

- Tidak ada relasi langsung (standalone table)

### Index

- PRIMARY KEY: `id`
- UNIQUE: `key`

---

## Tabel Permission (Spatie)

**Deskripsi**: Tabel dari package Spatie Laravel Permission untuk manajemen role dan permission

### Tabel yang Digunakan

1. **roles** - Menyimpan role (admin, user)
2. **permissions** - Menyimpan permission
3. **model_has_roles** - Relasi many-to-many antara model (users) dan roles
4. **model_has_permissions** - Relasi many-to-many antara model dan permissions
5. **role_has_permissions** - Relasi many-to-many antara roles dan permissions

### Relasi dengan Users

- User dapat memiliki banyak roles (many-to-many via `model_has_roles`)
- User dapat memiliki banyak permissions langsung (many-to-many via `model_has_permissions`)
- Role dapat memiliki banyak permissions (many-to-many via `role_has_permissions`)

---

## Status Enum Values

### ticket_orders.status & bookings.status

- `pending` - Menunggu verifikasi pembayaran
- `confirmed` - Pembayaran sudah dikonfirmasi admin
- `rejected` - Pembayaran ditolak admin

---

## Kode Unik

### Format Kode

- **Ticket Order**: `AT-XXXXX` (AT = Admission Ticket)
- **Ticket Item**: `AT-XXXXX` (setiap item punya kode unik)
- **Booking**: `AB-XXXXX` (AB = Admission Booking)

Kode dihasilkan menggunakan helper function `generateUniqueCode()` yang memastikan keunikan.

---

## Catatan Penting

1. **Cascade Delete**: 
   - Jika user dihapus, semua ticket_orders dan bookings miliknya ikut terhapus
   - Jika ticket_order dihapus, semua ticket_order_items ikut terhapus

2. **Set Null on Delete**:
   - Jika admin yang mengkonfirmasi dihapus, field `confirmed_by` di-set NULL

3. **Unique Constraints**:
   - 1 tempat hanya bisa dibooking 1x per tanggal (`place_id, booking_date`)
   - Setiap kode order/booking/tiket harus unik

4. **QR Code**:
   - Setiap ticket_order_item memiliki QR code unik
   - QR code disimpan sebagai file SVG di folder `public/qrcodes/`
   - QR code berisi `ticket_code` untuk verifikasi

5. **Payment Proof**:
   - Bukti pembayaran disimpan di folder `public/payment-proofs/`
   - Format: `YYYYMMDDHHMMSS_proof_uniqid.ext`

---

## Query Contoh

### Mendapatkan semua tiket yang sudah dikonfirmasi bulan ini

```sql
SELECT * FROM ticket_orders 
WHERE status = 'confirmed' 
AND YEAR(created_at) = YEAR(CURDATE())
AND MONTH(created_at) = MONTH(CURDATE());
```

### Mendapatkan total pendapatan bulan ini

```sql
SELECT 
    (SELECT COALESCE(SUM(total_price), 0) FROM ticket_orders 
     WHERE status = 'confirmed' 
     AND YEAR(created_at) = YEAR(CURDATE())
     AND MONTH(created_at) = MONTH(CURDATE()))
    +
    (SELECT COALESCE(SUM(total_price), 0) FROM bookings 
     WHERE status = 'confirmed' 
     AND YEAR(created_at) = YEAR(CURDATE())
     AND MONTH(created_at) = MONTH(CURDATE()))
AS total_revenue;
```

### Cek ketersediaan booking untuk tanggal tertentu

```sql
SELECT * FROM bookings 
WHERE place_id = ? 
AND booking_date = '2026-02-25';
```

---

**Dibuat**: 25 Februari 2026  
**Versi**: 1.0  
**Sistem**: Banyu Biru Ticketing & Booking System

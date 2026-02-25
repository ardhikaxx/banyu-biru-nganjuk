# Flowchart - Fitur Dashboard & Statistik

## Daftar Isi
1. [Tampilkan Dashboard Admin](#1-tampilkan-dashboard-admin)
2. [Hitung Total Tiket Terjual](#2-hitung-total-tiket-terjual)
3. [Hitung Penjualan Bulan Ini](#3-hitung-penjualan-bulan-ini)
4. [Hitung Total Pendapatan](#4-hitung-total-pendapatan)
5. [Generate Chart Penjualan](#5-generate-chart-penjualan)

---

## 1. Tampilkan Dashboard Admin

### Deskripsi
Flowchart untuk menampilkan dashboard admin dengan statistik.

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
[Admin mengakses dashboard]
  ↓
[Inisialisasi variabel:]
  - confirmedStatus = ['confirmed']
  - currentMonth = bulan ini
  - currentYear = tahun ini
  ↓
[Hitung Total Tiket Terjual]
  [Lihat flowchart #2]
  ↓
[Hitung Penjualan Bulan Ini]
  [Lihat flowchart #3]
  ↓
[Hitung Total Pendapatan]
  [Lihat flowchart #4]
  ↓
[Generate Chart Penjualan]
  [Lihat flowchart #5]
  ↓
[Query: ambil 5 order tiket terbaru]
  ↓
[Query: ambil 5 booking terbaru]
  ↓
[Tampilkan dashboard dengan:]
  - 4 Card statistik
  - Chart penjualan
  - Tabel order terbaru
  - Tabel booking terbaru
  ↓
END
```

---

## 2. Hitung Total Tiket Terjual

### Deskripsi
Flowchart untuk menghitung total tiket yang sudah dikonfirmasi.

### Flowchart

```
START
  ↓
[Query database: ticket_orders]
  ↓
[Filter: status = 'confirmed']
  ↓
[Sum: total_qty dari semua order confirmed]
  ↓
[Simpan hasil ke variabel: totalTicketsSold]
  ↓
[Tampilkan di card:]
  - Judul: "Total Tiket Terjual"
  - Nilai: totalTicketsSold
  - Icon: fas fa-ticket-alt
  - Warna: Teal
  - Keterangan: "Sudah dikonfirmasi"
  ↓
END
```

---

## 3. Hitung Penjualan Bulan Ini

### Deskripsi
Flowchart untuk menghitung penjualan tiket dan booking bulan ini.

### Flowchart

```
START
  ↓
[Ambil bulan dan tahun saat ini]
  ↓
[Query database: ticket_orders]
  ↓
[Filter: status = 'confirmed']
  ↓
[Filter: MONTH(created_at) = bulan ini]
  ↓
[Filter: YEAR(created_at) = tahun ini]
  ↓
[Sum: total_qty dari hasil filter]
  ↓
[Simpan ke: monthlyTicketSales]
  ↓
[Query database: bookings]
  ↓
[Filter: status = 'confirmed']
  ↓
[Filter: MONTH(created_at) = bulan ini]
  ↓
[Filter: YEAR(created_at) = tahun ini]
  ↓
[Count: jumlah booking]
  ↓
[Simpan ke: monthlyBookings]
  ↓
[Tampilkan di card:]
  - Judul: "Penjualan Bulan Ini"
  - Nilai: monthlyTicketSales + " tiket, " + monthlyBookings + " booking"
  - Icon: fas fa-chart-line
  - Warna: Biru
  - Keterangan: "Hanya yang terkonfirmasi"
  ↓
END
```


---

## 4. Hitung Total Pendapatan

### Deskripsi
Flowchart untuk menghitung total pendapatan dari tiket dan booking yang dikonfirmasi.

### Flowchart

```
START
  ↓
[Query database: ticket_orders]
  ↓
[Filter: status = 'confirmed']
  ↓
[Sum: total_price dari semua order confirmed]
  ↓
[Simpan ke: ticketRevenue]
  ↓
[Query database: bookings]
  ↓
[Filter: status = 'confirmed']
  ↓
[Sum: total_price dari semua booking confirmed]
  ↓
[Simpan ke: bookingRevenue]
  ↓
[Hitung: monthlyRevenue = ticketRevenue + bookingRevenue]
  ↓
[Format: Rp X.XXX.XXX]
  ↓
[Tampilkan di card:]
  - Judul: "Total Pendapatan"
  - Nilai: monthlyRevenue (formatted)
  - Icon: fas fa-money-bill-wave
  - Warna: Hijau
  - Keterangan: "Tiket + Booking terkonfirmasi"
  ↓
END
```

---

## 5. Generate Chart Penjualan

### Deskripsi
Flowchart untuk membuat chart penjualan 6 bulan terakhir.

### Flowchart

```
START
  ↓
[Inisialisasi array kosong:]
  - labels = []
  - ticketData = []
  - bookingData = []
  ↓
[Loop: untuk 6 bulan terakhir]
  ↓
  ┌─────────────────────────┐
  │ [Hitung bulan dan tahun untuk iterasi ke-i]
  │   ↓
  │ [Format nama bulan: "Jan 2026"]
  │   ↓
  │ [Tambahkan ke labels array]
  │   ↓
  │ [Query: ticket_orders confirmed untuk bulan ini]
  │   ↓
  │ [Sum: total_qty]
  │   ↓
  │ [Tambahkan ke ticketData array]
  │   ↓
  │ [Query: bookings confirmed untuk bulan ini]
  │   ↓
  │ [Count: jumlah booking]
  │   ↓
  │ [Tambahkan ke bookingData array]
  │   ↓
  │ [Ulangi untuk bulan berikutnya]
  └─────────────────────────┘
  ↓
[Kirim data ke view:]
  - chartLabels = labels (JSON)
  - chartTicketData = ticketData (JSON)
  - chartBookingData = bookingData (JSON)
  ↓
[Render chart menggunakan Chart.js]
  ↓
[Tampilkan line chart dengan:]
  - X-axis: Bulan
  - Y-axis: Jumlah
  - Line 1: Penjualan Tiket (Teal)
  - Line 2: Booking (Biru)
  - Legend: Aktif
  - Tooltip: Aktif
  ↓
END
```

---

## 6. Tampilkan Order Terbaru

### Deskripsi
Flowchart untuk menampilkan 5 order tiket terbaru.

### Flowchart

```
START
  ↓
[Query database: ticket_orders]
  ↓
[Include relasi: user]
  ↓
[Urutkan: created_at DESC]
  ↓
[Limit: 5 data]
  ↓
[Loop untuk setiap order:]
  ↓
  ┌─────────────────────────┐
  │ [Ambil data order:]
  │   - Kode order
  │   - Nama user
  │   - Total qty
  │   - Total harga
  │   - Status
  │   - Tanggal order
  │   ↓
  │ [Format tanggal: d M Y]
  │   ↓
  │ [Format harga: Rp X.XXX]
  │   ↓
  │ [Tentukan warna badge status:]
  │   - pending: kuning
  │   - confirmed: hijau
  │   - rejected: merah
  │   ↓
  │ [Tampilkan row di tabel]
  └─────────────────────────┘
  ↓
[Tampilkan tabel di dashboard]
  ↓
[Tampilkan link "Lihat Semua"]
  ↓
END
```

---

## 7. Tampilkan Booking Terbaru

### Deskripsi
Flowchart untuk menampilkan 5 booking terbaru.

### Flowchart

```
START
  ↓
[Query database: bookings]
  ↓
[Include relasi: user, place]
  ↓
[Urutkan: created_at DESC]
  ↓
[Limit: 5 data]
  ↓
[Loop untuk setiap booking:]
  ↓
  ┌─────────────────────────┐
  │ [Ambil data booking:]
  │   - Kode booking
  │   - Nama user
  │   - Nama tempat
  │   - Tanggal booking
  │   - Total harga
  │   - Status
  │   ↓
  │ [Format tanggal: d M Y]
  │   ↓
  │ [Format harga: Rp X.XXX]
  │   ↓
  │ [Tentukan warna badge status:]
  │   - pending: kuning
  │   - confirmed: hijau
  │   - rejected: merah
  │   ↓
  │ [Tampilkan row di tabel]
  └─────────────────────────┘
  ↓
[Tampilkan tabel di dashboard]
  ↓
[Tampilkan link "Lihat Semua"]
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
7. **Predefined Process** (Rectangle with double lines) - Subprocess

### Warna yang Disarankan
- **START/END**: Hijau teal (#14B8A6)
- **Process**: Biru muda (#E3F2FD)
- **Decision**: Kuning (#FFF59D)
- **Database Operation**: Ungu muda (#E1BEE7)
- **Calculation**: Hijau muda (#C8E6C9)
- **Chart/Display**: Biru tua muda (#BBDEFB)
- **Loop**: Oranye muda (#FFE0B2)
- **Aggregate**: Kuning muda (#FFF9C4)

### Tips
- Gunakan swimlane untuk memisahkan Data Processing dan Display
- Tandai proses agregasi (SUM, COUNT) dengan warna khusus
- Gunakan loop symbol untuk iterasi 6 bulan
- Tambahkan notes untuk formula perhitungan
- Highlight filter status 'confirmed' yang penting

### Layout Suggestion
```
┌─────────────────────────────────────────┐
│         Dashboard Controller            │
├─────────────────────────────────────────┤
│  ┌──────────┐  ┌──────────┐            │
│  │ Tiket    │  │ Booking  │            │
│  │ Terjual  │  │ Bulan    │            │
│  └──────────┘  └──────────┘            │
│  ┌──────────┐  ┌──────────┐            │
│  │ Penjualan│  │ Total    │            │
│  │ Bulan    │  │ Pendapatan│           │
│  └──────────┘  └──────────┘            │
│                                         │
│  ┌─────────────────────────────────┐   │
│  │     Chart Penjualan 6 Bulan     │   │
│  └─────────────────────────────────┘   │
│                                         │
│  ┌─────────────┐  ┌─────────────┐     │
│  │ Order       │  │ Booking     │     │
│  │ Terbaru     │  │ Terbaru     │     │
│  └─────────────┘  └─────────────┘     │
└─────────────────────────────────────────┘
```

---

**Dibuat**: 25 Februari 2026  
**Fitur**: Dashboard & Statistik  
**Sistem**: Banyu Biru Ticketing & Booking System

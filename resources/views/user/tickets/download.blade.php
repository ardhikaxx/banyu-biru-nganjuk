@extends('layouts.app')

@section('title', 'Download Tiket')

@section('content')
<div class="page-hero mb-4" data-aos="fade-down">
    <h3 class="mb-1"><i class="fas fa-download me-2"></i>
        @if($order->status === 'confirmed')
            Tiket Anda Siap Digunakan
        @else
            Status Pesanan Tiket
        @endif
    </h3>
    <p class="mb-0">Order: <strong>{{ $order->order_code }}</strong></p>
</div>

@if($order->status === 'confirmed')
    <div class="alert alert-success" data-aos="fade-up">
        <i class="fas fa-check-circle me-2"></i>Pembayaran berhasil diverifikasi. Silakan download tiket Anda.
    </div>
@elseif($order->status === 'pending')
    <div class="alert alert-warning" data-aos="fade-up">
        <i class="fas fa-clock me-2"></i>Pembayaran Anda sedang diverifikasi oleh admin. Mohon tunggu konfirmasi.
    </div>
@elseif($order->status === 'rejected')
    <div class="alert alert-danger" data-aos="fade-up">
        <i class="fas fa-times-circle me-2"></i>Pembayaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
    </div>
@endif

<div class="row g-3">
    @foreach($order->items as $item)
    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 90 }}">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="user-avatar mx-auto mb-2" style="width:68px; height:68px;"><i class="fas fa-ticket-alt"></i></div>
                    <h5 class="mb-1">{{ $item->ticket->name }}</h5>
                    <small class="text-muted">{{ $order->visit_date->format('d F Y') }}</small>
                </div>

                <div class="border rounded-3 p-3 mb-3 bg-light-subtle">
                    <div class="d-flex justify-content-between mb-1"><small>Kode</small><strong>{{ $item->ticket_code }}</strong></div>
                    <div class="d-flex justify-content-between"><small>Harga</small><strong>Rp {{ number_format($item->price, 0, ',', '.') }}</strong></div>
                </div>

                <div class="d-grid gap-2">
                    @if($order->status === 'confirmed')
                        <a href="{{ route('user.tickets.pdf', $item->id) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i>Download PDF
                        </a>
                        <a href="{{ route('user.tickets.pdf', $item->id) }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-print me-1"></i>Print Tiket
                        </a>
                    @else
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class="fas fa-file-pdf me-1"></i>Download PDF
                        </button>
                        <button type="button" class="btn btn-outline-secondary" disabled>
                            <i class="fas fa-print me-1"></i>Print Tiket
                        </button>
                        <div class="alert alert-warning mb-0 mt-2 text-center py-2">
                            <small><i class="fas fa-clock me-1"></i>Menunggu verifikasi admin</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card mt-4" data-aos="fade-up">
    <div class="card-body">
        <h5 class="mb-3"><i class="fas fa-circle-info me-2"></i>
            @if($order->status === 'confirmed')
                Informasi Penggunaan
            @else
                Informasi Pesanan
            @endif
        </h5>
        @if($order->status === 'confirmed')
            <ul class="mb-0">
                <li>Simpan tiket digital sampai waktu kunjungan selesai.</li>
                <li>Tunjukkan kode tiket atau QR kepada petugas di pintu masuk.</li>
                <li>Tiket berlaku sesuai tanggal kunjungan yang dipilih.</li>
            </ul>
        @elseif($order->status === 'pending')
            <ul class="mb-0">
                <li>Bukti pembayaran Anda telah diterima dan sedang diverifikasi.</li>
                <li>Proses verifikasi biasanya memakan waktu 1x24 jam.</li>
                <li>Anda akan menerima notifikasi setelah pembayaran dikonfirmasi.</li>
                <li>Tiket dapat didownload setelah pembayaran dikonfirmasi oleh admin.</li>
            </ul>
        @elseif($order->status === 'rejected')
            <ul class="mb-0">
                <li>Pembayaran Anda tidak dapat diverifikasi.</li>
                <li>Silakan hubungi admin untuk informasi lebih lanjut.</li>
                <li>Anda dapat mengupload ulang bukti pembayaran yang benar.</li>
            </ul>
        @endif
    </div>
</div>

@if($order->status === 'rejected')
    <div class="text-center mt-4">
        <a href="{{ route('user.tickets.payment', $order->order_code) }}" class="btn btn-warning">
            <i class="fas fa-upload me-2"></i>Upload Ulang Bukti Pembayaran
        </a>
    </div>
@endif
@endsection

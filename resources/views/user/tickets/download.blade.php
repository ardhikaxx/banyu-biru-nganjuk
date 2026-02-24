@extends('layouts.app')

@section('title', 'Download Tiket')

@section('content')
<div class="page-hero mb-4" data-aos="fade-down">
    <h3 class="mb-1"><i class="fas fa-download me-2"></i>Tiket Anda Siap Digunakan</h3>
    <p class="mb-0">Order: <strong>{{ $order->order_code }}</strong></p>
</div>

<div class="alert alert-success" data-aos="fade-up">
    Pembayaran berhasil diverifikasi. Silakan download tiket Anda.
</div>

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
                    <a href="{{ route('user.tickets.pdf', $item->id) }}" class="btn btn-primary" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i>Download PDF
                    </a>
                    <a href="{{ route('user.tickets.pdf', $item->id) }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-print me-1"></i>Print Tiket
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card mt-4" data-aos="fade-up">
    <div class="card-body">
        <h5 class="mb-3"><i class="fas fa-circle-info me-2"></i>Informasi Penggunaan</h5>
        <ul class="mb-0">
            <li>Simpan tiket digital sampai waktu kunjungan selesai.</li>
            <li>Tunjukkan kode tiket atau QR kepada petugas di pintu masuk.</li>
            <li>Tiket berlaku sesuai tanggal kunjungan yang dipilih.</li>
        </ul>
    </div>
</div>
@endsection

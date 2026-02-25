@extends('layouts.app')

@section('title', 'Download Tiket')

@push('styles')
<style>
    .ticket-preview {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
        border-radius: 24px;
        padding: 35px 30px;
        box-shadow: 0 15px 40px rgba(15, 118, 110, 0.12);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .ticket-preview:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(15, 118, 110, 0.2);
    }
    
    /* Header Section */
    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
    }
    
    .header-left {
        flex: 1;
    }
    
    .header-right {
        text-align: right;
    }
    
    .brand-name {
        font-size: 26px;
        font-weight: 900;
        color: #0f766e;
        letter-spacing: 1.5px;
        margin-bottom: 3px;
    }
    
    .brand-subtitle {
        font-size: 12px;
        color: #0f766e;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    
    .ticket-type {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 2px;
    }
    
    .ticket-name {
        font-size: 14px;
        color: #0f766e;
        font-weight: 800;
    }
    
    /* Destination Section */
    .destination-section {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .destination-code {
        font-size: 40px;
        font-weight: 900;
        color: #0f766e;
        letter-spacing: 6px;
        margin-bottom: 6px;
    }
    
    .destination-detail {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }
    
    /* QR Section */
    .ticket-qr-section {
        text-align: center;
        margin-bottom: 30px;
        padding: 22px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(15, 118, 110, 0.08);
    }
    
    .qr-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 12px;
    }
    
    .qr-wrapper {
        display: inline-block;
        padding: 12px;
        background: white;
        border: 3px solid #e0f2fe;
        border-radius: 12px;
    }
    
    .ticket-code-display {
        font-size: 15px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 2.5px;
        margin-top: 12px;
    }
    
    /* Info Grid */
    .ticket-info-box {
        margin-bottom: 15px;
    }
    
    .ticket-info-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 2px solid #e0f2fe;
    }
    
    .ticket-info-row:last-child {
        border-bottom: none;
    }
    
    .info-column {
        flex: 1;
    }
    
    .info-column:last-child {
        text-align: right;
    }
    
    .ticket-info-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 4px;
        display: block;
    }
    
    .ticket-info-value {
        font-size: 16px;
        color: #0f766e;
        font-weight: 800;
    }
    
    .ticket-info-value-large {
        font-size: 20px;
        color: #0f766e;
        font-weight: 900;
    }
    
    /* Footer Note */
    .footer-note-simple {
        text-align: center;
        font-size: 10px;
        color: #64748b;
        line-height: 1.5;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 2px dashed #cbd5e1;
    }
    
    .footer-note-simple strong {
        color: #0f766e;
        font-weight: 800;
    }
    
    /* Decorative Corners */
    .ticket-corners {
        position: absolute;
        width: 18px;
        height: 18px;
        border: 3px solid #0f766e;
        z-index: 2;
    }
    
    .corner-tl { top: 12px; left: 12px; border-right: none; border-bottom: none; }
    .corner-tr { top: 12px; right: 12px; border-left: none; border-bottom: none; }
    .corner-bl { bottom: 12px; left: 12px; border-right: none; border-top: none; }
    .corner-br { bottom: 12px; right: 12px; border-left: none; border-top: none; }
</style>
@endpush

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

<div class="d-flex justify-content-center align-item-center">
    @foreach($order->items as $item)
    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 90 }}">
        <div class="ticket-preview h-100">
            <!-- Decorative Corners -->
            <div class="ticket-corners corner-tl"></div>
            <div class="ticket-corners corner-tr"></div>
            <div class="ticket-corners corner-bl"></div>
            <div class="ticket-corners corner-br"></div>
            
            <!-- Header -->
            <div class="ticket-header">
                <div class="header-left">
                    <div class="brand-name">BANYU BIRU</div>
                    <div class="brand-subtitle">Pemandian Air Panas Nganjuk</div>
                </div>
                <div class="header-right">
                    <div class="ticket-type">Tiket</div>
                    <div class="ticket-name">{{ $item->ticket->name }}</div>
                </div>
            </div>
            
            <!-- Destination Code -->
            <div class="destination-section">
                <div class="destination-code">WISATA</div>
                <div class="destination-detail">{{ $order->visit_date->format('d F Y') }}</div>
            </div>
            
            <!-- QR Section -->
            <div class="ticket-qr-section">
                <div class="qr-label">Scan untuk verifikasi</div>
                <div class="qr-wrapper">
                    @if(file_exists(public_path($item->qr_code_path)))
                        <img src="{{ asset($item->qr_code_path) }}" style="width: 130px; height: 130px; display: block;" alt="QR Code">
                    @else
                        <div style="width: 130px; height: 130px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                            <i class="fas fa-qrcode" style="font-size: 50px; color: #9ca3af;"></i>
                        </div>
                    @endif
                </div>
                <div class="ticket-code-display">{{ $item->ticket_code }}</div>
            </div>
            
            <!-- Info Grid -->
            <div class="ticket-info-box">
                <div class="ticket-info-row">
                    <div class="info-column">
                        <span class="ticket-info-label">Nama Pemesan</span>
                        <div class="ticket-info-value">{{ $order->user->name }}</div>
                    </div>
                    <div class="info-column">
                        <span class="ticket-info-label">Harga</span>
                        <div class="ticket-info-value-large">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer-note-simple">
                <strong>Tunjukkan tiket ini kepada petugas.</strong><br>
                Tiket berlaku 1x kunjungan sesuai tanggal tertera.
            </div>

            <!-- Actions -->
            <div class="p-3">
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

@extends('layouts.app')

@section('title', 'Download Tiket')

@push('styles')
<style>
    .ticket-preview {
        border: 4px solid #0f766e;
        border-radius: 20px;
        overflow: hidden;
        background: white;
        box-shadow: 0 15px 40px rgba(15, 118, 110, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }
    
    .ticket-preview:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(15, 118, 110, 0.35);
    }
    
    .ticket-preview::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('/images/background.jpg') center/cover;
        opacity: 0.04;
        z-index: 0;
    }
    
    .ticket-header {
        background: #0f766e;
        color: white;
        text-align: center;
        padding: 25px 20px;
        position: relative;
        border-bottom: 5px solid #14b8a6;
    }
    
    .ticket-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(20, 184, 166, 0.2) 0%, transparent 100%);
        z-index: 0;
    }
    
    .ticket-header-content {
        position: relative;
        z-index: 1;
    }
    
    .ticket-header h5 {
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 8px 0;
        letter-spacing: 3px;
        text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
        color: #ffffff;
    }
    
    .ticket-header small {
        font-size: 13px;
        font-weight: 600;
        color: #ccfbf1;
        letter-spacing: 0.5px;
    }
    
    .ticket-qr-section {
        text-align: center;
        padding: 25px 20px;
        background: #f0fdfa;
        border-radius: 16px;
        border: 3px solid #14b8a6;
        margin: 20px;
        position: relative;
    }
    
    .ticket-qr-section::before {
        content: '';
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-radius: 16px;
        z-index: -1;
        opacity: 0.1;
    }
    
    .qr-wrapper {
        background: white;
        padding: 15px;
        border-radius: 12px;
        display: inline-block;
        box-shadow: 0 6px 20px rgba(15, 118, 110, 0.25);
        margin-bottom: 12px;
        border: 3px solid #0f766e;
    }
    
    .ticket-code-display {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: 3px;
        color: #0f766e;
        padding: 8px 16px;
        background: white;
        border-radius: 10px;
        display: inline-block;
        margin-top: 8px;
        border: 2px solid #14b8a6;
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.15);
    }
    
    .ticket-info-box {
        background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
        border-radius: 16px;
        padding: 20px;
        margin: 20px;
        position: relative;
        z-index: 1;
        border: 2px solid #ccfbf1;
    }
    
    .ticket-info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 2px solid #e0f2fe;
    }
    
    .ticket-info-row:last-child {
        border-bottom: none;
    }
    
    .ticket-info-label {
        font-size: 13px;
        color: #0f766e;
        font-weight: 700;
    }
    
    .ticket-info-value {
        font-size: 14px;
        color: #111827;
        font-weight: 700;
        text-align: right;
    }
    
    .price-highlight {
        color: #0f766e;
        font-size: 16px;
        background: #ccfbf1;
        padding: 4px 10px;
        border-radius: 6px;
    }
    
    .ticket-corners {
        position: absolute;
        width: 30px;
        height: 30px;
        border: 4px solid #14b8a6;
        z-index: 2;
    }
    
    .corner-tl { top: 0; left: 0; border-right: none; border-bottom: none; border-radius: 20px 0 0 0; }
    .corner-tr { top: 0; right: 0; border-left: none; border-bottom: none; border-radius: 0 20px 0 0; }
    .corner-bl { bottom: 0; left: 0; border-right: none; border-top: none; border-radius: 0 0 0 20px; }
    .corner-br { bottom: 0; right: 0; border-left: none; border-top: none; border-radius: 0 0 20px 0; }
    
    .divider-line {
        height: 3px;
        background: linear-gradient(90deg, transparent 0%, #14b8a6 50%, transparent 100%);
        margin: 15px 20px;
    }
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

<div class="row g-3">
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
                <div class="ticket-header-content">
                    <h5>BANYU BIRU</h5>
                    <small>Pemandian Air Panas Nganjuk</small>
                </div>
            </div>
            
            <!-- QR Section -->
            <div class="ticket-qr-section">
                <div class="qr-wrapper">
                    @if(file_exists(public_path($item->qr_code_path)))
                        <img src="{{ asset($item->qr_code_path) }}" style="width: 110px; height: 110px;" alt="QR Code">
                    @else
                        <div style="width: 110px; height: 110px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                            <i class="fas fa-qrcode" style="font-size: 45px; color: #9ca3af;"></i>
                        </div>
                    @endif
                </div>
                <div class="ticket-code-display">{{ $item->ticket_code }}</div>
            </div>
            
            <div class="divider-line"></div>
            
            <!-- Info -->
            <div class="ticket-info-box">
                <div class="ticket-info-row">
                    <span class="ticket-info-label">Jenis Tiket</span>
                    <span class="ticket-info-value">{{ $item->ticket->name }}</span>
                </div>
                <div class="ticket-info-row">
                    <span class="ticket-info-label">Tanggal Kunjungan</span>
                    <span class="ticket-info-value">{{ $order->visit_date->format('d M Y') }}</span>
                </div>
                <div class="ticket-info-row">
                    <span class="ticket-info-label">Harga</span>
                    <span class="ticket-info-value price-highlight">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </div>
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

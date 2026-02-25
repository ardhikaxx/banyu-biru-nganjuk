@extends('layouts.app')

@section('title', 'Download Tiket')

@push('styles')
<style>
    .ticket-preview {
        border: 5px solid #0f766e;
        border-radius: 24px;
        overflow: hidden;
        background: white;
        box-shadow: 0 20px 60px rgba(15, 118, 110, 0.25);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .ticket-preview:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 30px 80px rgba(15, 118, 110, 0.4);
    }
    
    .ticket-preview::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('/images/background.jpg') center/cover;
        opacity: 0.03;
        z-index: 0;
    }
    
    /* Header dengan wave animation */
    .ticket-header {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #115e59 100%);
        color: white;
        text-align: center;
        padding: 35px 25px 45px 25px;
        position: relative;
        overflow: hidden;
    }
    
    .ticket-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -50%;
        width: 200%;
        height: 100%;
        background: radial-gradient(circle at 30% 50%, rgba(20, 184, 166, 0.3) 0%, transparent 50%);
        animation: wave 15s ease-in-out infinite;
    }
    
    .ticket-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 35px;
        background: white;
        border-radius: 50% 50% 0 0 / 100% 100% 0 0;
    }
    
    @keyframes wave {
        0%, 100% { transform: translateX(0) translateY(0); }
        50% { transform: translateX(10%) translateY(-5%); }
    }
    
    .ticket-header-content {
        position: relative;
        z-index: 1;
    }
    
    .header-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }
    
    .header-icon-inner {
        width: 28px;
        height: 28px;
        background: white;
        border-radius: 50%;
    }
    
    .ticket-header h5 {
        font-size: 28px;
        font-weight: 900;
        margin: 0 0 8px 0;
        letter-spacing: 4px;
        text-shadow: 4px 4px 8px rgba(0,0,0,0.4);
        color: #ffffff;
        text-transform: uppercase;
    }
    
    .ticket-header small {
        font-size: 14px;
        font-weight: 600;
        color: #ccfbf1;
        letter-spacing: 1.5px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    /* QR Section horizontal layout */
    .ticket-qr-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 25px;
        background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%);
        border-radius: 20px;
        border: 4px dashed #14b8a6;
        margin: 25px;
        position: relative;
        gap: 20px;
    }
    
    .ticket-qr-section::before {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-radius: 20px;
        z-index: -1;
        opacity: 0.08;
    }
    
    .qr-left {
        flex: 1;
        text-align: center;
        padding-right: 15px;
    }
    
    .qr-right {
        flex: 1;
        text-align: center;
        padding-left: 15px;
        border-left: 3px solid #14b8a6;
    }
    
    .qr-label {
        font-size: 11px;
        color: #0f766e;
        font-weight: 700;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .qr-wrapper {
        background: white;
        padding: 15px;
        border-radius: 12px;
        display: inline-block;
        box-shadow: 0 6px 20px rgba(15, 118, 110, 0.25);
        border: 4px solid #0f766e;
    }
    
    .ticket-code-display {
        font-size: 18px;
        font-weight: 900;
        letter-spacing: 3px;
        color: #0f766e;
        padding: 10px 15px;
        background: white;
        border-radius: 10px;
        display: inline-block;
        margin-top: 10px;
        border: 3px solid #14b8a6;
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.15);
    }
    
    .divider-line {
        height: 4px;
        background: linear-gradient(90deg, transparent 0%, #14b8a6 20%, #0f766e 50%, #14b8a6 80%, transparent 100%);
        margin: 20px 25px;
        border-radius: 2px;
    }
    
    .ticket-info-box {
        background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
        border-radius: 20px;
        padding: 25px;
        margin: 25px;
        position: relative;
        z-index: 1;
        border: 3px solid #ccfbf1;
        box-shadow: 0 4px 15px rgba(15, 118, 110, 0.08);
    }
    
    .ticket-info-row {
        display: flex;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 3px solid #e0f2fe;
    }
    
    .ticket-info-row:last-child {
        border-bottom: none;
    }
    
    .ticket-info-label {
        font-size: 13px;
        color: #0f766e;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 900;
        border: 2px solid #14b8a6;
    }
    
    .ticket-corners {
        position: absolute;
        width: 40px;
        height: 40px;
        border: 5px solid #14b8a6;
        z-index: 2;
    }
    
    .corner-tl { top: 0; left: 0; border-right: none; border-bottom: none; border-radius: 24px 0 0 0; }
    .corner-tr { top: 0; right: 0; border-left: none; border-bottom: none; border-radius: 0 24px 0 0; }
    .corner-bl { bottom: 0; left: 0; border-right: none; border-top: none; border-radius: 0 0 0 24px; }
    .corner-br { bottom: 0; right: 0; border-left: none; border-top: none; border-radius: 0 0 24px 0; }
    
    /* Responsive untuk mobile */
    @media (max-width: 576px) {
        .ticket-qr-section {
            flex-direction: column;
            gap: 15px;
        }
        
        .qr-left, .qr-right {
            padding: 0;
            border-left: none;
        }
        
        .qr-right {
            border-top: 3px solid #14b8a6;
            padding-top: 15px;
        }
        
        .ticket-code-display {
            font-size: 16px;
            letter-spacing: 2px;
        }
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
                    <div class="header-icon">
                        <div class="header-icon-inner"></div>
                    </div>
                    <h5>BANYU BIRU</h5>
                    <small>Pemandian Air Panas Nganjuk</small>
                </div>
            </div>
            
            <!-- QR Section dengan layout horizontal -->
            <div class="ticket-qr-section">
                <div class="qr-left">
                    <div class="qr-label">Scan QR Code</div>
                    <div class="qr-wrapper">
                        @if(file_exists(public_path($item->qr_code_path)))
                            <img src="{{ asset($item->qr_code_path) }}" style="width: 100px; height: 100px; display: block;" alt="QR Code">
                        @else
                            <div style="width: 100px; height: 100px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                <i class="fas fa-qrcode" style="font-size: 45px; color: #9ca3af;"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="qr-right">
                    <div class="qr-label">Kode Tiket</div>
                    <div class="ticket-code-display">{{ $item->ticket_code }}</div>
                </div>
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

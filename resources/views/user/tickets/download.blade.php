@extends('layouts.app')

@section('title', 'Download Tiket')

@push('styles')
<style>
    .ticket-preview {
        border: 3px solid #0f766e;
        border-radius: 16px;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 30px rgba(15, 118, 110, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }
    
    .ticket-preview:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(15, 118, 110, 0.25);
    }
    
    .ticket-preview::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('/images/background.jpg') center/cover;
        opacity: 0.05;
        z-index: 0;
    }
    
    .ticket-header {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        color: white;
        text-align: center;
        padding: 20px;
        position: relative;
    }
    
    .ticket-header::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 100%;
        height: 16px;
        background: white;
        border-radius: 50% 50% 0 0 / 100% 100% 0 0;
    }
    
    .ticket-header h5 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 5px 0;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    
    .ticket-header small {
        opacity: 0.95;
        font-size: 12px;
    }
    
    .ticket-qr-section {
        text-align: center;
        padding: 20px;
        background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
        border-radius: 12px;
        border: 2px dashed #14b8a6;
        margin: 15px;
    }
    
    .qr-wrapper {
        background: white;
        padding: 12px;
        border-radius: 8px;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.15);
        margin-bottom: 10px;
    }
    
    .ticket-code-display {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #0f766e;
        padding: 6px 12px;
        background: white;
        border-radius: 6px;
        display: inline-block;
        margin-top: 5px;
    }
    
    .ticket-info-box {
        background: #f9fafb;
        border-radius: 12px;
        padding: 15px;
        margin: 15px;
        position: relative;
        z-index: 1;
    }
    
    .ticket-info-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .ticket-info-row:last-child {
        border-bottom: none;
    }
    
    .ticket-info-label {
        font-size: 12px;
        color: #6b7280;
        font-weight: 600;
    }
    
    .ticket-info-value {
        font-size: 13px;
        color: #111827;
        font-weight: 700;
        text-align: right;
    }
    
    .price-highlight {
        color: #0f766e;
        font-size: 14px;
    }
    
    .ticket-corners {
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid #14b8a6;
        z-index: 2;
    }
    
    .corner-tl { top: 0; left: 0; border-right: none; border-bottom: none; border-radius: 16px 0 0 0; }
    .corner-tr { top: 0; right: 0; border-left: none; border-bottom: none; border-radius: 0 16px 0 0; }
    .corner-bl { bottom: 0; left: 0; border-right: none; border-top: none; border-radius: 0 0 0 16px; }
    .corner-br { bottom: 0; right: 0; border-left: none; border-top: none; border-radius: 0 0 16px 0; }
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
                <h5>BANYU BIRU</h5>
                <small>Pemandian Air Panas Nganjuk</small>
            </div>
            
            <!-- QR Section -->
            <div class="ticket-qr-section">
                <div class="qr-wrapper">
                    @if(file_exists(public_path($item->qr_code_path)))
                        <img src="{{ asset($item->qr_code_path) }}" style="width: 100px; height: 100px;" alt="QR Code">
                    @else
                        <div style="width: 100px; height: 100px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                            <i class="fas fa-qrcode" style="font-size: 40px; color: #9ca3af;"></i>
                        </div>
                    @endif
                </div>
                <div class="ticket-code-display">{{ $item->ticket_code }}</div>
            </div>
            
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

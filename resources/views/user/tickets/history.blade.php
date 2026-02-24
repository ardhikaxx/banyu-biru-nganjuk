@extends('layouts.app')

@section('title', 'Riwayat Tiket Saya')

@section('content')
<div class="container py-4">
    <div class="page-hero mb-4">
        <h3 class="mb-2"><i class="fas fa-ticket-alt me-2"></i>Riwayat Tiket Saya</h3>
        <p class="mb-0">Lihat semua tiket yang pernah Anda beli</p>
    </div>

    @if($orders->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Riwayat Tiket</h5>
                <p class="text-muted mb-4">Anda belum pernah membeli tiket</p>
                <a href="{{ route('user.tickets.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-2"></i>Beli Tiket Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($orders as $order)
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="flex-shrink-0">
                                            <div class="bg-gradient-primary text-white rounded-3 p-3">
                                                <i class="fas fa-ticket-alt fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1">{{ $order->order_code }}</h5>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-calendar me-1"></i>
                                                Tanggal Kunjungan: {{ \Carbon\Carbon::parse($order->visit_date)->format('d F Y') }}
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-clock me-1"></i>
                                                Dipesan: {{ $order->created_at->format('d F Y, H:i') }}
                                            </p>
                                            <div class="mb-2">
                                                <strong>Total: {{ $order->total_qty }} tiket</strong>
                                                <span class="mx-2">•</span>
                                                <strong class="text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                                            </div>
                                            <div>
                                                @if($order->status === 'pending')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                                                    </span>
                                                @elseif($order->status === 'confirmed')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>Dikonfirmasi
                                                    </span>
                                                @elseif($order->status === 'rejected')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    @if($order->status === 'confirmed')
                                        <a href="{{ route('user.tickets.download', $order->order_code) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-download me-1"></i>Download Tiket
                                        </a>
                                    @elseif($order->status === 'pending' && !$order->payment_proof)
                                        <a href="{{ route('user.tickets.payment', $order->order_code) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-upload me-1"></i>Upload Bukti
                                        </a>
                                    @elseif($order->status === 'pending' && $order->payment_proof)
                                        <a href="{{ route('user.tickets.download', $order->order_code) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye me-1"></i>Lihat Detail
                                        </a>
                                    @endif
                                </div>
                            </div>

                            @if($order->items->isNotEmpty())
                                <hr class="my-3">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <small class="text-muted fw-bold">Detail Tiket:</small>
                                    </div>
                                    @foreach($order->items as $item)
                                        <div class="col-md-6">
                                            <div class="border rounded-3 p-2 bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="fw-bold">{{ $item->ticket->name }}</small>
                                                        <br>
                                                        <small class="text-muted">{{ $item->ticket_code }}</small>
                                                    </div>
                                                    @if($order->status === 'confirmed')
                                                        <a href="{{ route('user.tickets.pdf', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Download PDF">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

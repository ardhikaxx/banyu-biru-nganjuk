@extends('layouts.app')

@section('title', 'Riwayat Booking Saya')

@section('content')
<div class="container py-4">
    <div class="page-hero mb-4">
        <h3 class="mb-2"><i class="fas fa-calendar-check me-2"></i>Riwayat Booking Saya</h3>
        <p class="mb-0">Lihat semua booking yang pernah Anda buat</p>
    </div>

    @if($bookings->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Riwayat Booking</h5>
                <p class="text-muted mb-4">Anda belum pernah melakukan booking</p>
                <a href="{{ route('user.bookings.index') }}" class="btn btn-primary">
                    <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($bookings as $booking)
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="flex-shrink-0">
                                            <div class="bg-gradient-primary text-white rounded-3 p-3">
                                                <i class="fas fa-calendar-check fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1">{{ $booking->booking_code }}</h5>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $booking->place->name }}
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-calendar me-1"></i>
                                                Tanggal Booking: {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-clock me-1"></i>
                                                Dibuat: {{ $booking->created_at->format('d F Y, H:i') }}
                                            </p>
                                            <div class="mb-2">
                                                <strong>Nama Pengunjung:</strong> {{ $booking->visitor_name }}
                                                <br>
                                                <strong>No. Telepon:</strong> {{ $booking->visitor_phone }}
                                            </div>
                                            <div class="mb-2">
                                                <strong class="text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                            </div>
                                            <div>
                                                @if($booking->status === 'pending')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                                                    </span>
                                                @elseif($booking->status === 'confirmed')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>Dikonfirmasi
                                                    </span>
                                                @elseif($booking->status === 'rejected')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    @if($booking->status === 'pending' && !$booking->payment_proof)
                                        <a href="{{ route('user.bookings.payment', $booking->booking_code) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-upload me-1"></i>Upload Bukti
                                        </a>
                                    @else
                                        <a href="{{ route('user.bookings.status', $booking->booking_code) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye me-1"></i>Lihat Detail
                                        </a>
                                    @endif
                                </div>
                            </div>

                            @if($booking->notes)
                                <hr class="my-3">
                                <div>
                                    <small class="text-muted fw-bold">Catatan:</small>
                                    <p class="mb-0 mt-1">{{ $booking->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection

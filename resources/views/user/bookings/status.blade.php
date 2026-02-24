@extends('layouts.app')

@section('title', 'Status Booking')

@section('content')
<div class="page-hero mb-4" data-aos="fade-down">
    <h3 class="mb-1"><i class="fas fa-clipboard-check me-2"></i>Status Booking</h3>
    <p class="mb-0">Kode Booking: <strong>{{ $booking->booking_code }}</strong></p>
</div>

<div class="card" data-aos="fade-up">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <small class="text-muted d-block">Tempat</small>
                <strong>{{ $booking->place->name }}</strong>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Tanggal</small>
                <strong>{{ $booking->booking_date->format('d-m-Y') }}</strong>
            </div>
            <div class="col-12">
                <small class="text-muted d-block">Status</small>
                @switch($booking->status)
                    @case('pending')
                        <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Menunggu</span>
                        @break
                    @case('confirmed')
                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Dikonfirmasi</span>
                        @break
                    @case('rejected')
                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                        @break
                    @default
                        <span class="badge bg-secondary">{{ $booking->status }}</span>
                @endswitch
            </div>
            @if($booking->status === 'rejected' && $booking->rejection_note)
                <div class="col-12">
                    <div class="alert alert-danger mb-0">Alasan penolakan: {{ $booking->rejection_note }}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

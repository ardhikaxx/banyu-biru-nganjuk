@extends('layouts.admin')
@section('title', 'Detail Booking')

@section('content')
<div class="container-fluid page-shell">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Booking</a></li>
            <li class="breadcrumb-item active">Detail Booking</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-1" style="font-weight: 700; font-size: 1.75rem; color: var(--teal-900);">
                        <i class="fas fa-calendar-check me-2" style="color: var(--teal-600);"></i>Detail Booking
                    </h3>
                    <p class="text-muted mb-0" style="font-size: 0.9375rem;">Verifikasi data pengunjung dan ambil keputusan</p>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    @php
        $statusBadge = match($booking->status) {
            'confirmed' => 'success',
            'rejected' => 'danger',
            default => 'warning',
        };
    @endphp

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Booking Info Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-info-circle me-2"></i>Informasi Booking
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: var(--teal-50); border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Kode Booking</small>
                                <strong style="font-size: 1.125rem; color: var(--teal-900);">{{ $booking->booking_code }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: var(--teal-50); border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Status</small>
                                <span class="badge bg-{{ $statusBadge }}" style="font-size: 0.875rem;">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Nama Pengunjung</small>
                                <strong style="font-size: 1rem; color: var(--teal-900);">{{ $booking->visitor_name }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">No. Telepon</small>
                                <strong style="font-size: 1rem; color: var(--teal-900);">
                                    <i class="fas fa-phone me-2" style="color: var(--teal-600);"></i>{{ $booking->visitor_phone }}
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Tempat</small>
                                <strong style="font-size: 1rem; color: var(--teal-900);">
                                    <i class="fas fa-map-marker-alt me-2" style="color: var(--teal-600);"></i>{{ $booking->place->name }}
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Tanggal Booking</small>
                                <strong style="font-size: 1rem; color: var(--teal-900);">
                                    <i class="fas fa-calendar-day me-2" style="color: var(--teal-600);"></i>{{ $booking->booking_date->format('d F Y') }}
                                </strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Alamat</small>
                                <p class="mb-0" style="font-size: 0.9375rem; color: var(--teal-900);">{{ $booking->visitor_address }}</p>
                            </div>
                        </div>
                        @if($booking->notes)
                        <div class="col-12">
                            <div class="p-3 rounded" style="background: var(--teal-50); border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Catatan</small>
                                <p class="mb-0" style="font-size: 0.9375rem; color: var(--teal-900);">{{ $booking->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($booking->payment_proof)
                        @php($proofPath = str_starts_with($booking->payment_proof, 'payment-proofs/') ? $booking->payment_proof : 'payment-proofs/'.$booking->payment_proof)
                        <hr class="my-4" style="border-color: var(--teal-100);">
                        <a href="{{ asset($proofPath) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-image me-2"></i>Lihat Bukti Pembayaran
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="col-lg-4">
            @if($booking->status === 'pending')
            <div class="card mb-4" style="border-color: var(--teal-200);">
                <div class="card-header" style="background: linear-gradient(135deg, var(--teal-50), white);">
                    <h6 class="mb-0" style="font-weight: 700; color: var(--teal-900);">
                        <i class="fas fa-check-circle me-2"></i>Konfirmasi Booking
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3" style="font-size: 0.875rem;">Setujui booking ini jika semua data sudah sesuai</p>
                    <form action="{{ route('admin.bookings.confirm',$booking->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success w-100" type="submit">
                            <i class="fas fa-check-circle me-2"></i>Konfirmasi Booking
                        </button>
                    </form>
                </div>
            </div>

            <div class="card" style="border-color: #fecaca;">
                <div class="card-header" style="background: linear-gradient(135deg, #fef2f2, white);">
                    <h6 class="mb-0" style="font-weight: 700; color: #991b1b;">
                        <i class="fas fa-times-circle me-2"></i>Tolak Booking
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bookings.reject',$booking->id) }}" method="POST">
                        @csrf
                        <label class="form-label" style="font-weight: 600;">Alasan Penolakan</label>
                        <textarea class="form-control mb-3" name="rejection_note" rows="3" placeholder="Masukkan alasan penolakan" required></textarea>
                        <button class="btn btn-danger w-100" type="submit">
                            <i class="fas fa-times-circle me-2"></i>Tolak Booking
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="card" style="border-color: var(--teal-200);">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        @if($booking->status === 'confirmed')
                            <i class="fas fa-check-circle" style="font-size: 3rem; color: var(--success);"></i>
                        @else
                            <i class="fas fa-times-circle" style="font-size: 3rem; color: var(--danger);"></i>
                        @endif
                    </div>
                    <h5 style="font-weight: 700; color: var(--teal-900);">Booking {{ ucfirst($booking->status) }}</h5>
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">Status booking sudah diproses</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

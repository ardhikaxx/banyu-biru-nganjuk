@extends('layouts.admin')
@section('title', 'Check Booking')

@section('content')
<div class="container-fluid page-shell admin-page-shell">
    <div class="admin-page-head">
        <div>
            <h4 class="mb-1"><i class="fas fa-clipboard-check me-2 text-primary"></i>Verifikasi Booking</h4>
            <p class="mb-0 text-muted">Cari kode booking untuk meninjau status dan memutuskan konfirmasi atau penolakan.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.check.booking.check') }}">
                @csrf
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                    <input class="form-control" name="booking_code" placeholder="AB-XXXXX" required>
                    <button class="btn btn-primary" type="submit"><i class="fas fa-magnifying-glass me-2"></i>Cek Booking</button>
                </div>
            </form>
        </div>
    </div>

    @if(session('booking'))
        @php($booking = session('booking'))
        <div class="card">
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-4"><small class="text-muted d-block">Kode</small><strong>{{ $booking->booking_code }}</strong></div>
                    <div class="col-md-4"><small class="text-muted d-block">Pengunjung</small><strong>{{ $booking->visitor_name }}</strong></div>
                    <div class="col-md-4"><small class="text-muted d-block">Status</small><span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span></div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('admin.check.booking.check') }}">
                            @csrf
                            <input type="hidden" name="booking_code" value="{{ $booking->booking_code }}">
                            <input type="hidden" name="action" value="confirm">
                            <button class="btn btn-success w-100" type="submit"><i class="fas fa-check-circle me-2"></i>Konfirmasi</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('admin.check.booking.check') }}">
                            @csrf
                            <input type="hidden" name="booking_code" value="{{ $booking->booking_code }}">
                            <input type="hidden" name="action" value="reject">
                            <input class="form-control mb-2" name="rejection_note" placeholder="Alasan penolakan" required>
                            <button class="btn btn-danger w-100" type="submit"><i class="fas fa-times-circle me-2"></i>Tolak</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection



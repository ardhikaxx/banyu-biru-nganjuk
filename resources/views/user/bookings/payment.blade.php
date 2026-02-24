@extends('layouts.app')

@section('title', 'Pembayaran Booking')

@section('content')
<div class="page-hero mb-4" data-aos="fade-down">
    <h3 class="mb-1"><i class="fas fa-wallet me-2"></i>Pembayaran Booking</h3>
    <p class="mb-0">Kode Booking: <strong>{{ $booking->booking_code }}</strong> | Total: <strong>Rp {{ number_format($booking->total_price,0,',','.') }}</strong></p>
</div>

<div class="row g-4">
    <div class="col-lg-7" data-aos="fade-right">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-building-columns me-2"></i>Rekening Tujuan</h5>
            </div>
            <div class="card-body">
                @foreach($banks as $bank)
                    <div class="border rounded-3 p-3 mb-3 bg-light-subtle">
                        <small class="text-muted">{{ $bank->bank_name }} - a/n {{ $bank->account_name }}</small>
                        <div class="fw-bold fs-5">{{ $bank->account_number }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-5" data-aos="fade-left">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Bukti Transfer</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.bookings.upload',$booking->booking_code) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="border rounded-3 p-4 text-center mb-3" onclick="document.getElementById('proof').click()" style="cursor:pointer; border-style:dashed !important;">
                        <i class="fas fa-cloud-arrow-up fa-2x text-muted mb-2"></i>
                        <p class="mb-0">Klik untuk memilih file bukti transfer</p>
                        <input type="file" class="d-none" id="proof" name="payment_proof" accept="image/*,.pdf" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Kirim Bukti</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

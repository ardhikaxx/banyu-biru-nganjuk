@extends('layouts.app')

@section('title', 'Pembayaran Booking')

@section('content')
<div class="page-hero mb-4" data-aos="fade-down">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h3 class="mb-1"><i class="fas fa-wallet me-2"></i>Pembayaran Booking</h3>
            <p class="mb-0">Kode Booking: <strong>{{ $booking->booking_code }}</strong></p>
        </div>
        <div class="text-lg-end">
            <small class="d-block">Total Pembayaran</small>
            <h3 class="mb-0">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<div class="card mb-4" data-aos="fade-up">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-building-columns me-2"></i>Transfer ke Rekening Berikut</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($banks as $bank)
            <div class="col-md-6">
                <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <h6 class="mb-1">{{ $bank->bank_name }}</h6>
                            <small class="text-muted">a/n {{ $bank->account_name }}</small>
                            <div class="h5 mt-2 mb-0 font-monospace">{{ $bank->account_number }}</div>
                        </div>
                        <button class="btn btn-outline-primary btn-sm copy-btn" type="button" data-no="{{ $bank->account_number }}">
                            <i class="fas fa-copy me-1"></i>Salin
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card" data-aos="fade-up" data-aos-delay="120">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('user.bookings.upload', $booking->booking_code) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="border rounded-3 p-4 text-center" id="dropZone" style="cursor:pointer; border-style:dashed !important;">
                <i class="fas fa-cloud-arrow-up fa-3x mb-2 text-primary"></i>
                <h6 class="mb-1">Klik atau drag file ke sini</h6>
                <p class="text-muted mb-2">Format JPG, PNG, PDF (maks 5MB)</p>
                <input type="file" id="proofFile" name="payment_proof" class="d-none" accept="image/*,.pdf" required>
                <img id="previewImg" class="mt-3 rounded shadow d-none" style="max-height: 260px; max-width: 100%;">
            </div>

            <div class="alert alert-info mt-3 mb-0">
                Verifikasi pembayaran dilakukan maksimal 1x24 jam.
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Kirim Bukti Pembayaran</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const dropZone = document.getElementById('dropZone');
const proofFile = document.getElementById('proofFile');
const previewImg = document.getElementById('previewImg');

dropZone.addEventListener('click', () => proofFile.click());

['dragenter', 'dragover'].forEach((eventName) => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropZone.classList.add('bg-light');
    });
});

['dragleave', 'drop'].forEach((eventName) => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropZone.classList.remove('bg-light');
    });
});

dropZone.addEventListener('drop', (e) => {
    if (e.dataTransfer.files.length) {
        proofFile.files = e.dataTransfer.files;
        showPreview();
    }
});

proofFile.addEventListener('change', showPreview);

function showPreview() {
    const file = proofFile.files[0];
    if (!file) return;

    if (file.type.startsWith('image/')) {
        previewImg.src = URL.createObjectURL(file);
        previewImg.classList.remove('d-none');
    } else {
        previewImg.classList.add('d-none');
    }
}

document.querySelectorAll('.copy-btn').forEach((btn) => {
    btn.addEventListener('click', async () => {
        const text = btn.dataset.no;
        try {
            await navigator.clipboard.writeText(text);
        } catch (e) {
            const tmp = document.createElement('input');
            tmp.value = text;
            document.body.appendChild(tmp);
            tmp.select();
            document.execCommand('copy');
            tmp.remove();
        }
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Nomor rekening disalin', showConfirmButton: false, timer: 1800 });
    });
});
</script>
@endpush

@extends('layouts.app')

@section('title', 'Beli Tiket')

@section('content')
<div class="page-hero mb-4" data-aos="fade-down">
    <h3 class="mb-1"><i class="fas fa-ticket-alt me-2"></i>Pembelian Tiket</h3>
    <p class="mb-0">Satu jenis tiket resmi tersedia dengan harga Rp 5.000 per orang.</p>
</div>

<div class="card" data-aos="fade-up">
    <div class="card-body">
        <form method="POST" action="{{ route('user.tickets.order') }}" id="ticketForm">
            @csrf

            <div class="row g-4">
                <div class="col-lg-4">
                    <label class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="visit_date" min="{{ now()->toDateString() }}" required>
                    <small class="text-muted">Pilih tanggal kunjungan.</small>
                </div>
                <div class="col-lg-8">
                    @foreach($tickets as $ticket)
                        <div class="card border-2 mb-3" style="border-color: rgba(36, 128, 111, 0.2) !important;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-wrap gap-3 align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $ticket->name }}</h5>
                                        <small class="text-muted">Tiket masuk resmi Banyu Biru</small>
                                        <div class="h4 mb-0 mt-2 text-success">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="text-end">
                                        <label class="form-label mb-1">Jumlah Tiket</label>
                                        <input type="hidden" name="items[{{ $loop->index }}][ticket_id]" value="{{ $ticket->id }}">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-outline-primary qty-minus" type="button"><i class="fas fa-minus"></i></button>
                                            <input type="number" class="form-control text-center qty-input" name="items[{{ $loop->index }}][qty]" value="1" min="1" max="20" style="width: 85px;">
                                            <button class="btn btn-outline-primary qty-plus" type="button"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <small class="text-muted d-block">Total Pembayaran</small>
                    <h4 class="mb-0 text-gradient" id="totalPrice">Rp 0</h4>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-cart-shopping me-1"></i>Lanjutkan Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const prices = @json($tickets->pluck('price', 'id'));

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.qty-input').forEach((input) => {
        const ticketId = input.closest('.card').querySelector('input[name*="[ticket_id]"]').value;
        const qty = parseInt(input.value) || 0;
        total += prices[ticketId] * qty;
    });
    document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

document.querySelectorAll('.qty-minus').forEach((btn) => {
    btn.addEventListener('click', () => {
        const input = btn.parentElement.querySelector('.qty-input');
        input.value = Math.max(1, Number(input.value) - 1);
        updateTotal();
    });
});

document.querySelectorAll('.qty-plus').forEach((btn) => {
    btn.addEventListener('click', () => {
        const input = btn.parentElement.querySelector('.qty-input');
        input.value = Math.min(20, Number(input.value) + 1);
        updateTotal();
    });
});

document.querySelectorAll('.qty-input').forEach((input) => {
    input.addEventListener('change', updateTotal);
});

updateTotal();
</script>
@endpush

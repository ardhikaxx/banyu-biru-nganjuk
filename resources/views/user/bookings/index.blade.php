@extends('layouts.app')

@section('title', 'Booking Pendopo')

@section('content')
<div class="page-hero mb-4" data-aos="fade-down">
    <h3 class="mb-1"><i class="fas fa-calendar-check me-2"></i>Booking Pendopo</h3>
    <p class="mb-0">Isi data pengunjung dan pilih tanggal booking yang tersedia.</p>
</div>

<div class="card" data-aos="fade-up">
    <div class="card-body">
        <div class="alert alert-info mb-4">
            Tempat booking: <strong>{{ $place->name }}</strong> | Harga: <strong>Rp {{ number_format($place->price_per_day, 0, ',', '.') }}</strong>
        </div>

        <form method="POST" action="{{ route('user.bookings.store') }}" id="bookingForm">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input class="form-control" type="text" name="visitor_name" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No HP</label>
                    <input class="form-control" type="text" name="visitor_phone" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="visitor_address" rows="2" required></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Booking</label>
                    <input class="form-control" type="date" name="booking_date" id="booking_date" min="{{ now()->toDateString() }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Catatan</label>
                    <input class="form-control" type="text" name="notes" placeholder="Opsional">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-paper-plane me-1"></i>Booking Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('booking_date').addEventListener('change', async function() {
    const date = this.value;
    if (!date) return;

    const url = `{{ route('user.bookings.checkDate') }}?booking_date=${date}`;
    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    const data = await res.json();
    if (!data.available) {
        Swal.fire({ icon: 'warning', title: 'Tanggal Tidak Tersedia', text: data.message });
        this.value = '';
    }
});
</script>
@endpush

@extends('layouts.app')

@section('title', 'Banyu Biru - Tiket & Booking')

@push('styles')
<style>
    .hero-showcase {
        position: relative;
        overflow: hidden;
        border-radius: 36px;
        padding: 7rem 0 5rem;
        margin-bottom: 3rem;
        background: linear-gradient(130deg, #083446 0%, #0f766e 52%, #14b8a6 100%);
        box-shadow: 0 32px 56px rgba(8, 52, 70, 0.24);
    }

    .hero-showcase::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, rgba(8, 52, 70, 0.82), rgba(8, 52, 70, 0.42)), url('{{ asset('images/background.jpg') }}') center/cover no-repeat;
        opacity: 0.52;
    }

    .hero-showcase::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(380px 240px at 84% 14%, rgba(255, 255, 255, 0.2), transparent 72%),
            radial-gradient(330px 220px at 10% 90%, rgba(251, 146, 60, 0.22), transparent 74%);
    }

    .hero-inner {
        padding: 3rem;
        position: relative;
        z-index: 2;
    }

    .hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.34);
        padding: 0.56rem 1rem;
        color: #fff;
        font-size: 0.8rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(8px);
    }

    .hero-title {
        color: #fff;
        font-size: clamp(2.1rem, 5vw, 4rem);
        line-height: 1.08;
        margin: 1.2rem 0 1rem;
        letter-spacing: -0.03em;
    }

    .hero-subtitle {
        color: rgba(241, 253, 255, 0.95);
        font-size: 1.06rem;
        max-width: 640px;
        margin-bottom: 1.8rem;
        line-height: 1.66;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1.75rem;
    }

    .hero-actions .btn {
        border-radius: 12px;
        padding-inline: 1.3rem;
    }

    .hero-stats {
        margin-top: 0.45rem;
    }

    .hero-stat-card {
        height: 100%;
        border: 1px solid rgba(255, 255, 255, 0.26);
        border-radius: 16px;
        padding: 1rem 1.05rem;
        background: rgba(255, 255, 255, 0.13);
        backdrop-filter: blur(8px);
        box-shadow: 0 12px 24px rgba(6, 31, 41, 0.18);
    }

    .hero-stat-value {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.16rem;
    }

    .hero-stat-label {
        color: rgba(241, 253, 255, 0.85);
        font-size: 0.82rem;
        font-weight: 600;
    }

    .hero-side-card {
        border: 1px solid rgba(255, 255, 255, 0.28);
        border-radius: 22px;
        padding: 1.35rem;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(12px);
        box-shadow: 0 24px 36px rgba(6, 31, 41, 0.22);
    }

    .hero-side-card h5 {
        color: #fff;
        font-size: 1.15rem;
    }

    .hero-side-list {
        margin: 0;
        padding: 0;
        list-style: none;
        color: #fff;
    }

    .hero-side-list li {
        display: flex;
        gap: 0.65rem;
        align-items: flex-start;
        color: #fff !important;
        margin-bottom: 0.82rem;
        font-size: 0.92rem;
        line-height: 1.5;
    }

    .hero-side-list li i {
        color: #ebfdff;
        margin-top: 0.2rem;
    }
    
    .hero-side-list li span {
        color: #fff !important;
    }

    .hero-side-price {
        margin: 1rem 0 1.1rem;
        border: 1px solid rgba(255, 255, 255, 0.24);
        border-radius: 14px;
        padding: 0.82rem 0.95rem;
        background: rgba(255, 255, 255, 0.1);
    }

    .hero-side-price small {
        display: block;
        color: rgba(241, 253, 255, 0.86);
        font-size: 0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    .hero-side-price strong {
        color: #fff;
        font-size: 1.45rem;
        line-height: 1.2;
    }

    .section-block {
        padding: 5rem 0;
    }

    .section-head {
        text-align: center;
        margin-bottom: 2.6rem;
    }

    .section-head h2 {
        color: #0f172a;
        font-size: clamp(1.9rem, 4vw, 2.9rem);
        margin-bottom: 0.7rem;
    }

    .section-head p {
        max-width: 640px;
        margin: 0 auto;
        color: #516b7d;
    }

    .facility-card-pro {
        height: 100%;
        border: 1px solid rgba(16, 38, 50, 0.1);
        border-radius: 20px;
        padding: 1.6rem;
        background: linear-gradient(180deg, #ffffff, #f5fbff);
        box-shadow: 0 12px 26px rgba(10, 34, 46, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .facility-card-pro:hover {
        transform: translateY(-4px);
        box-shadow: 0 22px 34px rgba(10, 34, 46, 0.14);
    }

    .facility-icon-pro {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: linear-gradient(130deg, #0f766e, #14b8a6);
        box-shadow: 0 14px 24px rgba(15, 118, 110, 0.2);
        margin-bottom: 1rem;
    }

    .facility-card-pro h5 {
        margin-bottom: 0.56rem;
    }

    .facility-card-pro p {
        margin-bottom: 0;
        color: #597385;
    }

    .ticket-panel {
        border: 1px solid rgba(16, 38, 50, 0.11);
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(10, 34, 46, 0.12);
        background: #fff;
    }

    .ticket-head {
        padding: 1.9rem 2rem 1.7rem;
        background: linear-gradient(132deg, #093443 0%, #0f766e 62%, #14b8a6 100%);
        color: #fff;
    }

    .ticket-head h4,
    .ticket-head p,
    .ticket-head small {
        color: #effdff;
        margin-bottom: 0;
    }

    .ticket-head-price {
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 800;
        line-height: 1.08;
        color: #fff;
    }

    .ticket-body {
        padding: 1.7rem 2rem;
    }

    .ticket-point-pro {
        display: flex;
        gap: 0.72rem;
        margin-bottom: 0.75rem;
        color: #365161;
    }

    .ticket-point-pro i {
        margin-top: 0.2rem;
        color: #0f766e;
    }

    .ticket-cta-box {
        border: 1px solid rgba(16, 38, 50, 0.1);
        border-radius: 16px;
        padding: 0.9rem;
        background: #f4fbfb;
    }

    .ticket-cta-box small {
        color: #5f7889;
    }

    .booking-shell {
        border: 1px solid rgba(16, 38, 50, 0.1);
        border-radius: 26px;
        background: linear-gradient(180deg, #ffffff, #f6fbff);
        box-shadow: 0 20px 40px rgba(10, 34, 46, 0.1);
        overflow: hidden;
    }

    .booking-side {
        height: 100%;
        background: linear-gradient(150deg, #0b3d4a, #0f766e);
        color: #fff;
        padding: 1.5rem;
    }

    .booking-side h5,
    .booking-side p {
        color: #ebfdff;
    }

    .booking-step {
        display: flex;
        gap: 0.7rem;
        margin-bottom: 1rem;
        align-items: flex-start;
    }

    .booking-step span {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.28);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.74rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .booking-step p {
        margin: 0;
        color: rgba(235, 253, 255, 0.9);
        font-size: 0.91rem;
    }

    .booking-form-wrap {
        padding: 1.6rem;
    }

    .booking-note-pro {
        border: 1px solid #b7ddf4;
        border-radius: 14px;
        background: linear-gradient(135deg, #e3f5ff, #eef8ff);
        padding: 0.9rem 1rem;
    }

    .home-modal .modal-header {
        background: linear-gradient(130deg, #0b3d4a, #0f766e 62%, #14b8a6);
        color: #fff;
    }

    .home-modal .btn-close {
        filter: invert(1);
    }

    .order-summary-pro {
        border: 1px solid #b4d7f8;
        border-radius: 18px;
        background: linear-gradient(130deg, #e2f3ff, #f0f9ff);
    }

    @media (max-width: 991.98px) {
        .hero-showcase {
            padding: 5.8rem 0 3.7rem;
            border-radius: 26px;
        }

        .section-block {
            padding: 4rem 0;
        }

        .ticket-head,
        .ticket-body,
        .booking-form-wrap {
            padding: 1.2rem;
        }
    }

    @media (max-width: 767.98px) {
        .hero-actions {
            flex-direction: column;
        }

        .hero-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('body_classes')
home-shell
@endpush

@section('content')
<section id="home" class="hero-showcase">
    <div class="container hero-inner">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="hero-kicker" data-aos="fade-right">
                    <i class="fas fa-circle-check"></i>Tiket online resmi Banyu Biru
                </span>

                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="80">
                    Pusat Tiket dan Booking
                    <br>
                    Pemandian Air Panas Banyu Biru Nganjuk
                </h1>

                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="140">
                    Satu halaman untuk pemesanan tiket masuk dan booking pendopo. Proses singkat, verifikasi jelas, dan siap dipakai untuk operasional harian wisata.
                </p>

                <div class="hero-actions" data-aos="fade-up" data-aos-delay="200">
                    <a href="#tiket" class="btn btn-primary btn-lg">
                        <i class="fas fa-ticket-alt me-2"></i>Beli Tiket
                    </a>
                    <a href="#booking" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-calendar-check me-2"></i>Booking Pendopo
                    </a>
                </div>

                <div class="row g-3 hero-stats" data-aos="fade-up" data-aos-delay="260">
                    <div class="col-sm-4">
                        <div class="hero-stat-card">
                            <div class="hero-stat-value">Rp 5.000</div>
                            <div class="hero-stat-label">Harga tiket per orang</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="hero-stat-card">
                            <div class="hero-stat-value">Pendopo</div>
                            <div class="hero-stat-label">Tempat booking aktif</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="hero-stat-card">
                            <div class="hero-stat-value">Digital</div>
                            <div class="hero-stat-label">Validasi lebih cepat</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5" data-aos="fade-left" data-aos-delay="180">
                <div class="hero-side-card">
                    <h5 class="mb-3">Kenapa pakai sistem ini?</h5>
                    <ul class="hero-side-list">
                        <li class="text-white"><i class="fas fa-shield-alt"></i><span>Pembayaran lebih aman dengan upload bukti transfer.</span></li>
                        <li class="text-white"><i class="fas fa-bolt"></i><span>Konfirmasi pesanan lebih cepat lewat panel admin.</span></li>
                        <li class="text-white"><i class="fas fa-qrcode"></i><span>Tiket punya kode unik untuk proses scan di pintu masuk.</span></li>
                    </ul>
                    <div class="hero-side-price">
                        <small>Harga dasar tiket</small>
                        <strong>Rp 5.000 / orang</strong>
                    </div>
                    <a href="#tiket" class="btn btn-primary w-100 fw-bold text-white">
                        <i class="fas fa-arrow-right me-2"></i>Mulai Pemesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="fasilitas" class="section-block">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <h2>Fasilitas Utama</h2>
            <p>Pengalaman wisata Banyu Biru dirancang nyaman untuk pengunjung keluarga, rombongan, dan acara komunitas.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="80">
                <div class="facility-card-pro">
                    <div class="facility-icon-pro"><i class="fas fa-water-ladder"></i></div>
                    <h5>Kolam Air Panas</h5>
                    <p>Kolam utama dengan suhu hangat alami untuk relaksasi dan aktivitas wisata harian.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="160">
                <div class="facility-card-pro">
                    <div class="facility-icon-pro"><i class="fas fa-umbrella-beach"></i></div>
                    <h5>Area Santai</h5>
                    <p>Zona duduk dan tunggu yang nyaman sebelum masuk kolam atau saat istirahat.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="240">
                <div class="facility-card-pro">
                    <div class="facility-icon-pro"><i class="fas fa-store"></i></div>
                    <h5>Tenant Kuliner</h5>
                    <p>Pilihan makanan dan minuman yang membantu kunjungan lebih praktis untuk rombongan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="tiket" class="section-block">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <h2>Tiket Masuk</h2>
            <p>Pembelian tiket dilakukan per orang dengan harga tetap dan proses lanjut pembayaran melalui bukti transfer.</p>
        </div>

        <div class="ticket-panel" data-aos="zoom-in">
            @forelse($tickets as $ticket)
                <div class="ticket-head d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="mb-1">{{ $ticket->name }}</h4>
                        <p>Tiket berlaku satu kali masuk sesuai tanggal kunjungan.</p>
                    </div>
                    <div class="text-lg-end">
                        <div class="ticket-head-price">{{ 'Rp ' . number_format($ticket->price, 0, ',', '.') }}</div>
                        <small>Harga tetap per pengunjung</small>
                    </div>
                </div>
                <div class="ticket-body">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <div class="ticket-point-pro"><i class="fas fa-circle-check"></i><span>Akses area kolam utama Banyu Biru.</span></div>
                            <div class="ticket-point-pro"><i class="fas fa-circle-check"></i><span>Termasuk fasilitas area bilas dan area umum.</span></div>
                            <div class="ticket-point-pro mb-0"><i class="fas fa-circle-check"></i><span>Tiket digital dilengkapi kode unik untuk verifikasi.</span></div>
                        </div>
                        <div class="col-lg-4">
                            <div class="ticket-cta-box">
                                <small class="d-block mb-2">Lanjutkan ke modal ringkasan sebelum checkout.</small>
                                <button class="btn btn-primary btn-lg w-100 buy-ticket-btn" type="button" data-ticket-id="{{ $ticket->id }}" data-ticket-name="{{ $ticket->name }}" data-price="{{ (int) $ticket->price }}">
                                    Beli Tiket Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4">
                    <div class="alert alert-warning mb-0">Tiket belum tersedia saat ini.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section id="booking" class="section-block">
    <div class="container">
        <div class="section-head" data-aos="fade-up">
            <h2>Booking Tempat</h2>
            <p>Booking online saat ini hanya untuk tempat <strong>Pendopo</strong>. Pilih tanggal, isi data pengunjung, lalu lanjutkan pembayaran.</p>
        </div>

        <div class="booking-shell" data-aos="fade-up">
            <div class="row g-0">
                <div class="col-lg-4">
                    <div class="booking-side h-100">
                        <h5 class="mb-2">Alur Booking</h5>
                        <p class="mb-4">Ikuti langkah berikut untuk memastikan booking diproses lebih cepat.</p>

                        <div class="booking-step">
                            <span>1</span>
                            <p>Isi data lengkap pengunjung dan tanggal booking.</p>
                        </div>
                        <div class="booking-step">
                            <span>2</span>
                            <p>Sistem cek ketersediaan tanggal secara otomatis.</p>
                        </div>
                        <div class="booking-step">
                            <span>3</span>
                            <p>Lakukan pembayaran dan upload bukti transfer.</p>
                        </div>
                        <div class="booking-step mb-0">
                            <span>4</span>
                            <p>Admin melakukan konfirmasi status booking Anda.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="booking-form-wrap">
                        <div class="booking-note-pro d-flex align-items-start gap-2 mb-4">
                            <i class="fas fa-circle-info mt-1 text-info"></i>
                            <div>
                                <strong class="d-block text-info-emphasis">Informasi Penting</strong>
                                <span class="text-info-emphasis">Tempat booking otomatis adalah <strong>Pendopo</strong> dengan validasi tanggal aktif.</span>
                            </div>
                        </div>

                        <form id="bookingForm" method="POST" action="{{ route('user.bookings.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-2">Nama Lengkap *</label>
                                    <input type="text" class="form-control form-control-lg" name="visitor_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-2">No. Telepon *</label>
                                    <input type="tel" class="form-control form-control-lg" id="phone" name="visitor_phone" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold mb-2">Alamat *</label>
                                    <textarea class="form-control form-control-lg" name="visitor_address" rows="3" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-2">Tanggal Booking *</label>
                                    <input type="date" class="form-control form-control-lg" id="booking_date" name="booking_date" min="{{ now()->toDateString() }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-2">Catatan (Opsional)</label>
                                    <input type="text" class="form-control form-control-lg" name="notes" placeholder="Contoh: Rombongan sekolah, agenda keluarga, dll.">
                                </div>
                                <div class="col-12 d-grid mt-2">
                                    <button type="submit" class="btn btn-primary btn-lg py-3">
                                        Booking Sekarang
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade home-modal" id="ticketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header text-white p-4">
                <h5 class="modal-title fw-bold fs-4 text-white">Beli Tiket</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 p-md-5">
                <form id="ticketPurchaseForm">
                    <input type="hidden" id="selectedTicketId">
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2">Jumlah Tiket</label>
                        <input type="number" class="form-control form-control-lg" id="modalQuantity" min="1" max="20" value="1">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2">Tanggal Kunjungan</label>
                        <input type="date" class="form-control form-control-lg" id="modalDate" min="{{ now()->toDateString() }}">
                    </div>
                    <div class="order-summary-pro p-4 mb-4">
                        <h6 class="fw-bold fs-5 text-info mb-3">Ringkasan Pesanan</h6>
                        <p class="mb-2">Tiket: <span id="modalTicketName" class="fw-semibold">-</span></p>
                        <p class="mb-2">Harga Satuan: Rp <span id="modalPrice" class="fw-semibold">0</span></p>
                        <p class="mb-3">Jumlah: <span id="modalQtyDisplay" class="fw-semibold">1</span> tiket</p>
                        <hr class="my-3 border-info-subtle">
                        <h5 class="mb-0 fw-bold text-info">Total: Rp <span id="modalTotal">0</span></h5>
                    </div>
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-primary btn-lg">Lanjutkan Pembayaran</button>
                        <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="ticketOrderSubmitForm" method="POST" action="{{ route('user.tickets.order') }}" class="d-none">
    @csrf
    <input type="hidden" name="visit_date" id="submitVisitDate">
    <input type="hidden" name="items[0][ticket_id]" id="submitTicketId">
    <input type="hidden" name="items[0][qty]" id="submitTicketQty">
</form>
@endsection

@push('scripts')
<script>
    const isGuest = {{ auth()->check() ? 'false' : 'true' }};
    const isAdmin = {{ auth()->check() && auth()->user()->hasRole('admin') ? 'true' : 'false' }};
    let selectedPrice = 0;

    function showNeedLogin() {
        Swal.fire({
            icon: 'warning',
            title: 'Login Diperlukan',
            text: 'Silakan login melalui menu Login di navbar.',
            confirmButtonColor: '#0f766e'
        });
    }
    
    function showAdminRestriction() {
        Swal.fire({
            icon: 'info',
            title: 'Akses Terbatas',
            html: '<p class="mb-2">Akun admin tidak dapat melakukan booking atau pembelian tiket.</p><p class="mb-0 text-muted small">Gunakan akun user biasa untuk melakukan transaksi.</p>',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#0f766e',
            customClass: {
                popup: 'swal-teal-popup',
                confirmButton: 'swal-teal-confirm'
            },
            backdrop: 'rgba(15, 118, 110, 0.1)'
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('ticketModal');
        const bookingForm = document.getElementById('bookingForm');
        const bookingDateInput = document.getElementById('booking_date');
        const phoneInput = document.getElementById('phone');
        const modalDate = document.getElementById('modalDate');

        if (!modalElement || !bookingForm || !bookingDateInput || !phoneInput || !modalDate) {
            return;
        }

        const modal = new bootstrap.Modal(modalElement);
        modalDate.value = new Date().toISOString().split('T')[0];

        document.querySelectorAll('.buy-ticket-btn').forEach((button) => {
            button.addEventListener('click', function () {
                if (isAdmin) {
                    showAdminRestriction();
                    return;
                }
                
                const ticketId = this.dataset.ticketId;
                const ticketName = this.dataset.ticketName;
                selectedPrice = Number(this.dataset.price || 0);

                document.getElementById('selectedTicketId').value = ticketId;
                document.getElementById('modalTicketName').textContent = ticketName;
                document.getElementById('modalPrice').textContent = selectedPrice.toLocaleString('id-ID');
                document.getElementById('modalQuantity').value = 1;
                document.getElementById('modalQtyDisplay').textContent = '1';
                document.getElementById('modalTotal').textContent = selectedPrice.toLocaleString('id-ID');
                modal.show();
            });
        });

        document.getElementById('modalQuantity').addEventListener('input', function () {
            const qty = Math.max(1, Number(this.value || 1));
            const total = selectedPrice * qty;
            document.getElementById('modalQtyDisplay').textContent = qty;
            document.getElementById('modalTotal').textContent = total.toLocaleString('id-ID');
        });

        document.getElementById('ticketPurchaseForm').addEventListener('submit', function (e) {
            e.preventDefault();
            if (isGuest) {
                modal.hide();
                showNeedLogin();
                return;
            }
            
            if (isAdmin) {
                modal.hide();
                showAdminRestriction();
                return;
            }

            const visitDate = modalDate.value;
            const ticketId = document.getElementById('selectedTicketId').value;
            const qty = document.getElementById('modalQuantity').value;

            if (!visitDate || !ticketId || !qty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data belum lengkap',
                    text: 'Tanggal dan jumlah tiket wajib diisi.'
                });
                return;
            }

            document.getElementById('submitVisitDate').value = visitDate;
            document.getElementById('submitTicketId').value = ticketId;
            document.getElementById('submitTicketQty').value = qty;
            document.getElementById('ticketOrderSubmitForm').submit();
        });

        bookingForm.addEventListener('submit', function (e) {
            if (isGuest) {
                e.preventDefault();
                showNeedLogin();
                return;
            }
            
            if (isAdmin) {
                e.preventDefault();
                showAdminRestriction();
                return;
            }
        });

        bookingDateInput.addEventListener('change', async function () {
            if (isGuest) {
                this.value = '';
                showNeedLogin();
                return;
            }
            
            if (isAdmin) {
                this.value = '';
                showAdminRestriction();
                return;
            }

            const bookingDate = this.value;
            if (!bookingDate) return;

            try {
                const url = `{{ route('user.bookings.checkDate') }}?booking_date=${bookingDate}`;
                const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                if (!response.ok) return;

                const data = await response.json();
                if (!data.available) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal Tidak Tersedia',
                        text: data.message
                    });
                    this.value = '';
                }
            } catch (error) {
                console.error(error);
            }
        });

        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });

        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 88,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endpush

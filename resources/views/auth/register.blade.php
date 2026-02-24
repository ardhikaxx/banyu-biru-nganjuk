@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="row min-vh-100 align-items-center justify-content-center">
        <div class="col-xl-10">
            <div class="row g-0 auth-panel">
                <div class="col-lg-7 bg-white p-4 p-lg-5">
                    <h3 class="mb-2">Buat Akun Baru</h3>
                    <p class="text-muted mb-4">Lengkapi data untuk mulai pembelian tiket dan booking.</p>

                    <form method="POST" action="{{ url('/register') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" placeholder="Nama Anda" required autofocus>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. Handphone</label>
                                <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label class="form-check-label" for="terms">Saya setuju dengan syarat dan ketentuan</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4 mb-3">
                            <i class="fas fa-user-plus me-1"></i>Daftar
                        </button>

                        <p class="text-center mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Login di sini</a></p>
                    </form>
                </div>

                <div class="col-lg-5 d-none d-lg-block auth-side p-4 p-lg-5 d-flex align-items-center">
                    <div>
                        <h4 class="mb-3">Kenapa daftar?</h4>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Akses pembelian tiket online</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Booking pendopo dari rumah</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Histori transaksi lebih rapi</li>
                            <li><i class="fas fa-check-circle me-2"></i>Verifikasi pembayaran lebih cepat</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

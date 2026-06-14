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
                                <input type="tel" name="phone" class="form-control" placeholder="08xxxxxxxxxx" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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

                        <p class="text-center mb-3">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Login di sini</a></p>
                        
                        <div class="text-center d-lg-none">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </form>
                </div>

                <div class="col-lg-5 d-none d-lg-block auth-side p-4 p-lg-5 d-flex align-items-center">
                    <div class="w-100">
                        <h4 class="mb-3">Kenapa daftar?</h4>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Akses pembelian tiket online</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Booking pendopo dari rumah</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Histori transaksi lebih rapi</li>
                            <li><i class="fas fa-check-circle me-2"></i>Verifikasi pembayaran lebih cepat</li>
                        </ul>
                        
                        <a href="{{ route('home') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="{{ url('/register') }}"]');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = form.querySelector('input[name="name"]').value.trim();
            const email = form.querySelector('input[name="email"]').value.trim();
            const phone = form.querySelector('input[name="phone"]').value.trim();
            const password = form.querySelector('input[name="password"]').value;
            const passwordConfirmation = form.querySelector('input[name="password_confirmation"]').value;
            const terms = form.querySelector('#terms').checked;
            
            if (!name) {
                return showError('Validasi Gagal', 'Nama lengkap tidak boleh kosong.');
            }
            
            if (!email) {
                return showError('Validasi Gagal', 'Email tidak boleh kosong.');
            }
            
            // Simple email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                return showError('Validasi Gagal', 'Format email tidak valid.');
            }
            
            if (!password) {
                return showError('Validasi Gagal', 'Password tidak boleh kosong.');
            }
            
            if (password.length < 6) {
                return showError('Validasi Gagal', 'Password minimal 6 karakter.');
            }
            
            if (!passwordConfirmation) {
                return showError('Validasi Gagal', 'Konfirmasi password tidak boleh kosong.');
            }
            
            if (password !== passwordConfirmation) {
                return showError('Validasi Gagal', 'Password dan Konfirmasi Password tidak sama.');
            }
            
            if (!terms) {
                return showError('Validasi Gagal', 'Anda harus menyetujui syarat dan ketentuan.');
            }
            
            // Instead of standard submit, do AJAX fetch
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        willClose: () => {
                            window.location.href = data.redirect_url;
                        }
                    });
                } else {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                    showError('Registrasi Gagal', data.message || 'Silakan periksa kembali data Anda.');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
                showError('Error', 'Terjadi kesalahan pada sistem.');
            });
        });
    }
    
    function showError(title, text) {
        Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonColor: '#0f766e',
            confirmButtonText: 'OK'
        });
    }
});
</script>
@endpush
@endsection

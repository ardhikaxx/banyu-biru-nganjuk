@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="row min-vh-100 align-items-center justify-content-center">
        <div class="col-xl-10">
            <div class="row g-0 auth-panel">
                <div class="col-lg-6 d-none d-lg-block auth-side p-5 d-flex align-items-center">
                    <div class="w-100">
                        <h2 class="mb-3"><i class="fas fa-water me-2"></i>Selamat Datang</h2>
                        <p class="mb-4">Masuk untuk membeli tiket dan booking pendopo dengan proses yang cepat.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Transaksi aman</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i>Tiket digital otomatis</li>
                            <li><i class="fas fa-check-circle me-2"></i>Status pesanan real-time</li>
                        </ul>
                        
                        <a href="{{ route('home') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 bg-white p-4 p-lg-5">
                    <h3 class="mb-2">Login Akun</h3>
                    <p class="text-muted mb-4">Masukkan email dan password Anda.</p>

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-right-to-bracket me-1"></i>Masuk
                        </button>

                        <p class="text-center mb-3">Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold">Daftar sekarang</a></p>
                        
                        <div class="text-center d-lg-none">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="{{ url('/login') }}"]');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = form.querySelector('input[name="email"]').value.trim();
            const password = form.querySelector('input[name="password"]').value;
            
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
                    showError('Login Gagal', data.message || 'Kredensial tidak valid.');
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

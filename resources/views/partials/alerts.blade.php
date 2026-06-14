@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
            confirmButtonColor: '#0f766e',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: @json(session('info')),
            confirmButtonColor: '#0f766e',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: @json(session('warning')),
            confirmButtonColor: '#0f766e',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('swal_login_required'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Login Diperlukan',
            text: 'Silakan login terlebih dahulu untuk melanjutkan.',
            confirmButtonText: 'Login Sekarang',
            confirmButtonColor: '#0f766e',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('login') }}';
            }
        });
    </script>
@endif

@if (session('swal_admin_restriction'))
    <script>
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
    </script>
@endif

@if (session('error') || $errors->any())
    <script>
        let errorHtml = '';
        let errorText = '';
        
        @if($errors->any())
            errorHtml = `<div class="text-start">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>`;
        @elseif(session('error'))
            errorText = @json(session('error'));
        @endif

        Swal.fire({
            icon: 'error',
            title: @json(session('error_title') ?? (session('error') ? 'Gagal!' : 'Validasi Gagal')),
            html: errorHtml || undefined,
            text: errorText || undefined,
            confirmButtonColor: '#0f766e',
            confirmButtonText: 'OK'
        });
    </script>
@endif

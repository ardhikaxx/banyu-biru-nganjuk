@extends('layouts.admin')
@section('title', 'Manajemen Admin')

@section('content')
<div class="container-fluid page-shell">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-2"><i class="fas fa-user-shield me-2 text-primary"></i>Manajemen Admin</h3>
                    <p class="text-muted mb-0">Kelola akun administrator sistem dan hak akses</p>
                </div>
                <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Admin Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $admins->count() }}</div>
                <div class="stat-label">Total Administrator</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-user-shield me-1"></i>Semua akun admin
                </small>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <div class="stat-value">{{ $admins->count() }}</div>
                <div class="stat-label">Admin Aktif</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-check-circle me-1"></i>Dapat mengakses sistem
                </small>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon secondary">
                    <i class="fas fa-key"></i>
                </div>
                <div class="stat-value">Full</div>
                <div class="stat-label">Hak Akses</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-unlock me-1"></i>Akses penuh sistem
                </small>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Administrator</h5>
            <span class="badge bg-primary">{{ $admins->count() }} Admin</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableAdmins">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th>Nama Admin</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td><span class="badge bg-primary">#{{ $admin->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle" style="width: 44px; height: 44px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong class="d-block">{{ $admin->name }}</strong>
                                        <span class="badge bg-primary-subtle text-primary">
                                            <i class="fas fa-shield-halved me-1"></i>Administrator
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-envelope text-primary"></i>
                                    <span>{{ $admin->email }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-phone text-primary"></i>
                                    <span>{{ $admin->phone ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tableAdmins').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
        },
        order: [[0, 'desc']],
        pageLength: 10,
        responsive: true
    });

    // Delete confirmation
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus admin ini? Data yang sudah dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush

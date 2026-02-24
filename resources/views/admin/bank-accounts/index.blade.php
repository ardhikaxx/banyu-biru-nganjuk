@extends('layouts.admin')
@section('title', 'Rekening Bank')

@section('content')
<div class="container-fluid page-shell">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-2"><i class="fas fa-building-columns me-2 text-primary"></i>Rekening Bank</h3>
                    <p class="text-muted mb-0">Kelola rekening bank untuk menerima pembayaran dari pelanggan</p>
                </div>
                <a href="{{ route('admin.bank-accounts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Rekening Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-building-columns"></i>
                </div>
                <div class="stat-value">{{ $bankAccounts->count() }}</div>
                <div class="stat-label">Total Rekening</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-layer-group me-1"></i>Semua rekening bank
                </small>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $bankAccounts->where('is_active', 1)->count() }}</div>
                <div class="stat-label">Rekening Aktif</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-toggle-on me-1"></i>Tersedia untuk pembayaran
                </small>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-value">{{ $bankAccounts->where('is_active', 0)->count() }}</div>
                <div class="stat-label">Rekening Nonaktif</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-toggle-off me-1"></i>Tidak tersedia
                </small>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Rekening Bank</h5>
            <span class="badge bg-primary">{{ $bankAccounts->count() }} Rekening</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableBank">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th>Bank</th>
                            <th>No. Rekening</th>
                            <th>Atas Nama</th>
                            <th width="120" class="text-center">Status</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bankAccounts as $item)
                        <tr>
                            <td><span class="badge bg-primary">#{{ $item->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 p-2" style="width: 48px; height: 48px; background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-building-columns text-white fs-5"></i>
                                    </div>
                                    <strong>{{ $item->bank_name }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-credit-card text-primary"></i>
                                    <code class="text-dark fs-6">{{ $item->account_number }}</code>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-user text-primary"></i>
                                    <strong>{{ $item->account_name }}</strong>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($item->is_active)
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.bank-accounts.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.bank-accounts.destroy', $item) }}" class="d-inline delete-form">
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
    $('#tableBank').DataTable({
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
            text: 'Apakah Anda yakin ingin menghapus rekening ini? Data yang sudah dihapus tidak dapat dikembalikan.',
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

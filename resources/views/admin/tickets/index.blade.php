@extends('layouts.admin')
@section('title', 'Manajemen Tiket')

@section('content')
<div class="container-fluid page-shell">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-1" style="font-weight: 700; font-size: 1.75rem;">Manajemen Tiket</h3>
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">Kelola tiket masuk pemandian</p>
                </div>
                <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Tiket
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="stat-value">{{ $tickets->count() }}</div>
                <div class="stat-label">Total Tiket</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $tickets->where('is_active', 1)->count() }}</div>
                <div class="stat-label">Tiket Aktif</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-value">{{ $tickets->where('is_active', 0)->count() }}</div>
                <div class="stat-label">Tiket Nonaktif</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon secondary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $tickets->sum('quota_per_day') }}</div>
                <div class="stat-label">Total Kuota/Hari</div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0" style="font-weight: 700;">Daftar Tiket</h6>
            <span class="badge bg-primary">{{ $tickets->count() }} Tiket</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableTickets">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Nama Tiket</th>
                            <th>Harga</th>
                            <th>Kuota/Hari</th>
                            <th width="100" class="text-center">Status</th>
                            <th width="180" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                            <td><span class="badge bg-primary">#{{ $ticket->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 36px; height: 36px; background: #0f766e; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block" style="font-size: 0.875rem;">{{ $ticket->name }}</strong>
                                        @if($ticket->description)
                                            <small class="text-muted" style="font-size: 0.75rem;">{{ Str::limit($ticket->description, 40) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong style="font-size: 0.875rem; color: #10b981;">Rp {{ number_format($ticket->price, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $ticket->quota_per_day }} tiket</span>
                            </td>
                            <td class="text-center">
                                @if($ticket->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}" class="d-inline delete-form">
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
    $('#tableTickets').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
        },
        order: [[0, 'desc']],
        pageLength: 10,
        responsive: true
    });

    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus tiket ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush

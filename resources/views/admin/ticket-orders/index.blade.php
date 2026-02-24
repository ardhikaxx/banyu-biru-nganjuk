@extends('layouts.admin')
@section('title', 'Penjualan Tiket')

@section('content')
<div class="container-fluid page-shell">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-2"><i class="fas fa-cart-shopping me-2 text-primary"></i>Penjualan Tiket</h3>
                    <p class="text-muted mb-0">Monitoring dan kelola seluruh transaksi pembelian tiket</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $orders->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Pending</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-hourglass-half me-1"></i>Menunggu verifikasi
                </small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $orders->where('status', 'confirmed')->count() }}</div>
                <div class="stat-label">Confirmed</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-check-double me-1"></i>Sudah diverifikasi
                </small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-value">{{ $orders->where('status', 'rejected')->count() }}</div>
                <div class="stat-label">Rejected</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-ban me-1"></i>Ditolak
                </small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="stat-value">{{ $orders->count() }}</div>
                <div class="stat-label">Total Transaksi</div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-list me-1"></i>Semua order
                </small>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Transaksi</h5>
            <span class="badge bg-primary">{{ $orders->count() }} Transaksi</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableTicketOrders">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th>Kode Order</th>
                            <th>Pembeli</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Total Harga</th>
                            <th width="130" class="text-center">Status</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><span class="badge bg-primary">#{{ $order->id }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-2 p-2" style="width: 40px; height: 40px; background: rgba(14, 165, 233, 0.1); display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-barcode text-primary"></i>
                                        </div>
                                        <strong>{{ $order->order_code }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle" style="width: 36px; height: 36px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9rem;">
                                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong class="d-block">{{ $order->user->name }}</strong>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-calendar-day text-primary me-2"></i>
                                    <strong>{{ $order->visit_date->format('d M Y') }}</strong>
                                </td>
                                <td>
                                    <strong class="text-success fs-6">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-center">
                                    @if($order->status === 'confirmed')
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>Confirmed
                                        </span>
                                    @elseif($order->status === 'rejected')
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="fas fa-times-circle me-1"></i>Rejected
                                        </span>
                                    @else
                                        <span class="badge bg-warning px-3 py-2">
                                            <i class="fas fa-clock me-1"></i>Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.ticket-orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
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
    $('#tableTicketOrders').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
        },
        order: [[0, 'desc']],
        pageLength: 10,
        responsive: true
    });
});
</script>
@endpush

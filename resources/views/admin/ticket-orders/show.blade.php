@extends('layouts.admin')
@section('title', 'Detail Order Tiket')

@section('content')
<div class="container-fluid page-shell">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.ticket-orders.index') }}">Order Tiket</a></li>
            <li class="breadcrumb-item active">Detail Order</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-1" style="font-weight: 700; font-size: 1.75rem; color: var(--teal-900);">
                        <i class="fas fa-receipt me-2" style="color: var(--teal-600);"></i>Detail Order Tiket
                    </h3>
                    <p class="text-muted mb-0" style="font-size: 0.9375rem;">Tinjau detail transaksi dan lakukan konfirmasi</p>
                </div>
                <a href="{{ route('admin.ticket-orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    @php
        $statusBadge = match($order->status) {
            'confirmed' => 'success',
            'rejected' => 'danger',
            default => 'warning',
        };
    @endphp

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Order Info Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-info-circle me-2"></i>Informasi Order
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: var(--teal-50); border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Kode Order</small>
                                <strong style="font-size: 1.125rem; color: var(--teal-900);">{{ $order->order_code }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: var(--teal-50); border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Status</small>
                                <span class="badge bg-{{ $statusBadge }}" style="font-size: 0.875rem;">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Pemesan</small>
                                <strong style="font-size: 1rem; color: var(--teal-900);">{{ $order->user->name }}</strong>
                                <br><small class="text-muted">{{ $order->user->email }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Tanggal Kunjungan</small>
                                <strong style="font-size: 1rem; color: var(--teal-900);">
                                    <i class="fas fa-calendar-day me-2" style="color: var(--teal-600);"></i>{{ $order->visit_date->format('d F Y') }}
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Total Tiket</small>
                                <strong style="font-size: 1.25rem; color: var(--teal-900);">{{ $order->total_qty }} Tiket</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Total Bayar</small>
                                <strong style="font-size: 1.25rem; color: var(--teal-900);">Rp {{ number_format($order->total_price,0,',','.') }}</strong>
                            </div>
                        </div>
                    </div>

                    @if($order->payment_proof)
                        @php($proofPath = str_starts_with($order->payment_proof, 'payment-proofs/') ? $order->payment_proof : 'payment-proofs/'.$order->payment_proof)
                        <hr class="my-4" style="border-color: var(--teal-100);">
                        <a href="{{ asset($proofPath) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-image me-2"></i>Lihat Bukti Pembayaran
                        </a>
                    @endif
                </div>
            </div>

            <!-- Ticket Items Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-ticket-alt me-2"></i>Daftar Tiket
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th width="60">#</th>
                                    <th>Nama Tiket</th>
                                    <th>Kode Tiket</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $index => $item)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $index + 1 }}</span></td>
                                    <td><strong>{{ $item->ticket->name }}</strong></td>
                                    <td><code style="background: var(--teal-50); padding: 0.25rem 0.5rem; border-radius: 6px; color: var(--teal-900); font-weight: 600;">{{ $item->ticket_code }}</code></td>
                                    <td><strong style="color: var(--teal-700);">Rp {{ number_format($item->price, 0, ',', '.') }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="col-lg-4">
            @if($order->status === 'pending')
            <div class="card mb-4" style="border-color: var(--teal-200);">
                <div class="card-header" style="background: linear-gradient(135deg, var(--teal-50), white);">
                    <h6 class="mb-0" style="font-weight: 700; color: var(--teal-900);">
                        <i class="fas fa-check-circle me-2"></i>Konfirmasi Order
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3" style="font-size: 0.875rem;">Setujui order ini jika pembayaran sudah sesuai</p>
                    <form action="{{ route('admin.ticket-orders.confirm',$order->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success w-100" type="submit">
                            <i class="fas fa-check-circle me-2"></i>Konfirmasi Order
                        </button>
                    </form>
                </div>
            </div>

            <div class="card" style="border-color: #fecaca;">
                <div class="card-header" style="background: linear-gradient(135deg, #fef2f2, white);">
                    <h6 class="mb-0" style="font-weight: 700; color: #991b1b;">
                        <i class="fas fa-times-circle me-2"></i>Tolak Order
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ticket-orders.reject',$order->id) }}" method="POST">
                        @csrf
                        <label class="form-label" style="font-weight: 600;">Alasan Penolakan</label>
                        <textarea class="form-control mb-3" name="rejection_note" rows="3" placeholder="Masukkan alasan penolakan" required></textarea>
                        <button class="btn btn-danger w-100" type="submit">
                            <i class="fas fa-times-circle me-2"></i>Tolak Order
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="card" style="border-color: var(--teal-200);">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        @if($order->status === 'confirmed')
                            <i class="fas fa-check-circle" style="font-size: 3rem; color: var(--success);"></i>
                        @else
                            <i class="fas fa-times-circle" style="font-size: 3rem; color: var(--danger);"></i>
                        @endif
                    </div>
                    <h5 style="font-weight: 700; color: var(--teal-900);">Order {{ ucfirst($order->status) }}</h5>
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">Status order sudah diproses</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

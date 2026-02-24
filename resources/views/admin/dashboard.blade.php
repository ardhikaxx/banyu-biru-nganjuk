@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid page-shell">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1" style="font-weight: 700; font-size: 1.75rem;">Dashboard</h3>
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">Selamat datang kembali, {{ auth()->user()->name }}</p>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block" style="font-size: 0.75rem;">{{ now()->format('l, d F Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    @unless($hasTransactionData)
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle me-2"></i>
            Belum ada transaksi. Data dashboard akan muncul setelah ada pesanan pertama.
        </div>
    @endunless

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="stat-value">{{ $totalTicketsSold }}</div>
                <div class="stat-label">Total Tiket Aktif</div>
                <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">
                    <i class="fas fa-arrow-up me-1"></i>Tiket terjual
                </small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon secondary">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-value">Rp {{ number_format($monthlyTicketSales, 0, ',', '.') }}</div>
                <div class="stat-label">Penjualan Bulan Ini</div>
                <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">
                    <i class="fas fa-calendar me-1"></i>{{ now()->format('F Y') }}
                </small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">{{ $monthlyBookings }}</div>
                <div class="stat-label">Booking Bulan Ini</div>
                <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">
                    <i class="fas fa-clock me-1"></i>Reservasi pendopo
                </small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-value">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pendapatan</div>
                <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">
                    <i class="fas fa-wallet me-1"></i>Potensi revenue
                </small>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-chart-area me-2 text-primary"></i>Grafik Penjualan Tiket
                    </h6>
                    <span class="badge bg-primary">12 Bulan</span>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="80"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>Status Transaksi
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background: #fffbeb;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 10px; height: 10px; background: #f59e0b; border-radius: 50%;"></div>
                                <span style="font-size: 0.875rem; font-weight: 600;">Pending</span>
                            </div>
                            <strong style="font-size: 0.875rem;">{{ $statusData[0] ?? 0 }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background: #f0fdf4;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 10px; height: 10px; background: #10b981; border-radius: 50%;"></div>
                                <span style="font-size: 0.875rem; font-weight: 600;">Confirmed</span>
                            </div>
                            <strong style="font-size: 0.875rem;">{{ $statusData[1] ?? 0 }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background: #fef2f2;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 10px; height: 10px; background: #ef4444; border-radius: 50%;"></div>
                                <span style="font-size: 0.875rem; font-weight: 600;">Rejected</span>
                            </div>
                            <strong style="font-size: 0.875rem;">{{ $statusData[2] ?? 0 }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Chart -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-chart-column me-2 text-primary"></i>Grafik Booking Pendopo
                    </h6>
                    <span class="badge bg-warning">12 Bulan</span>
                </div>
                <div class="card-body">
                    <canvas id="bookingChart" height="60"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Sales Chart
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'Tiket Terjual',
            data: @json($ticketData),
            borderColor: '#0f766e',
            backgroundColor: 'rgba(15, 118, 110, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 2,
            pointRadius: 4,
            pointBackgroundColor: '#0f766e',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 13, weight: '600' },
                bodyFont: { size: 12 },
                cornerRadius: 8
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: { font: { size: 11 } }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } }
            }
        }
    }
});

// Booking Chart
new Chart(document.getElementById('bookingChart'), {
    type: 'bar',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'Booking Aktif',
            data: @json($bookingData),
            backgroundColor: '#f59e0b',
            borderRadius: 6,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 13, weight: '600' },
                bodyFont: { size: 12 },
                cornerRadius: 8
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: { font: { size: 11 } }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } }
            }
        }
    }
});

// Status Chart
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Confirmed', 'Rejected'],
        datasets: [{
            data: @json($statusData),
            backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 13, weight: '600' },
                bodyFont: { size: 12 },
                cornerRadius: 8
            }
        }
    }
});
</script>
@endpush

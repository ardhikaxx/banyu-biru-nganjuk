<aside class="admin-sidebar shadow-lg" id="adminSidebar">
    <div class="sidebar-brand border-bottom border-white-10">
        <div class="sidebar-brand-main">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-link">
                <span class="sidebar-brand-mark"><i class="fas fa-water"></i></span>
                <span class="sidebar-brand-copy">
                    <strong>Banyu Biru</strong>
                    <small>Ops Console</small>
                </span>
            </a>
            <button type="button" class="btn btn-sm btn-outline-light d-lg-none" onclick="toggleSidebar()">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-menu flex-grow-1">
        <div class="menu-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" title="Dashboard" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-chart-line"></i></span>
            <span class="menu-label">Dashboard</span>
        </a>

        <div class="menu-section mt-2">Transaksi</div>
        <a href="{{ route('admin.tickets.index') }}" title="Master Tiket" class="menu-item {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-ticket-alt"></i></span>
            <span class="menu-label">Master Tiket</span>
        </a>
        <a href="{{ route('admin.ticket-orders.index') }}" title="Order Tiket" class="menu-item {{ request()->routeIs('admin.ticket-orders.*') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-cart-shopping"></i></span>
            <span class="menu-label">Order Tiket</span>
        </a>
        <a href="{{ route('admin.bookings.index') }}" title="Order Booking" class="menu-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-calendar-check"></i></span>
            <span class="menu-label">Order Booking</span>
        </a>

        <div class="menu-section mt-2">Verifikasi</div>
        <a href="{{ route('admin.check.ticket') }}" title="Scan Tiket" class="menu-item {{ request()->routeIs('admin.check.ticket') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-qrcode"></i></span>
            <span class="menu-label">Scan Tiket</span>
        </a>
        <a href="{{ route('admin.check.booking') }}" title="Validasi Booking" class="menu-item {{ request()->routeIs('admin.check.booking') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-clipboard-check"></i></span>
            <span class="menu-label">Validasi Booking</span>
        </a>

        <div class="menu-section mt-2">Konfigurasi</div>
        <a href="{{ route('admin.bank-accounts.index') }}" title="Rekening Bank" class="menu-item {{ request()->routeIs('admin.bank-accounts.*') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-building-columns"></i></span>
            <span class="menu-label">Rekening Bank</span>
        </a>
        <a href="{{ route('admin.admins.index') }}" title="Manajemen Admin" class="menu-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-user-shield"></i></span>
            <span class="menu-label">Manajemen Admin</span>
        </a>
    </div>

    <div class="sidebar-footer border-top border-white-10">
        <div class="sidebar-status">
            <span class="status-dot"></span>
            <div class="status-text">
                <small>Status Sistem</small>
                <strong>Semua layanan online</strong>
            </div>
        </div>
    </div>
</aside>

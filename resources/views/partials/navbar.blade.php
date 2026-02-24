<nav class="navbar navbar-expand-xl site-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="brand-mark"><i class="fas fa-water"></i></span>
            <span class="brand-wording">
                <span class="brand-main">Banyu Biru</span>
                <small class="brand-sub">Ticketing & Booking</small>
            </span>
        </a>

        <button class="navbar-toggler site-nav-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-xl-center gap-1 mt-3 mt-xl-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-house me-1"></i>Beranda
                    </a>
                </li>

                @auth
                    @if(auth()->user()->hasRole('user'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.tickets.*') ? 'active' : '' }}" href="{{ route('user.tickets.index') }}">
                                <i class="fas fa-ticket-alt me-1"></i>Tiket
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.bookings.*') ? 'active' : '' }}" href="{{ route('user.bookings.index') }}">
                                <i class="fas fa-calendar-check me-1"></i>Booking
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}" href="{{ route('user.profile.index') }}">
                                <i class="fas fa-user me-1"></i>Profil
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <div class="nav-auth-actions ms-xl-3 mt-3 mt-xl-0">
                @auth
                    @if(auth()->user()->hasRole('user'))
                        <div class="user-chip d-none d-xl-inline-flex">
                            <span class="chip-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <small>{{ auth()->user()->name }}</small>
                        </div>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-gauge-high me-1"></i>Dashboard Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-primary btn-sm" type="submit">
                            <i class="fas fa-right-from-bracket me-1"></i>Logout
                        </button>
                    </form>
                @else
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>Daftar
                    </a>
                    <a class="btn btn-primary btn-sm" href="{{ route('login') }}">
                        <i class="fas fa-right-to-bracket me-1"></i>Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

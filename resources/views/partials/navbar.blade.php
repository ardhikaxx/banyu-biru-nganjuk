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
                        <div class="dropdown d-none d-xl-inline-block">
                            <button class="user-chip dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="chip-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                <small>{{ auth()->user()->name }}</small>
                                <i class="fas fa-chevron-down ms-2" style="font-size: 0.75rem;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end user-dropdown">
                                <li class="dropdown-header">
                                    <div class="dropdown-user-info">
                                        <div class="dropdown-avatar">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="dropdown-user-name">{{ auth()->user()->name }}</div>
                                            <div class="dropdown-user-email">{{ auth()->user()->email }}</div>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.tickets.history') }}">
                                        <i class="fas fa-ticket-alt"></i>
                                        <span>Tiket Saya</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.bookings.history') }}">
                                        <i class="fas fa-calendar-check"></i>
                                        <span>Booking Saya</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.profile.index') }}">
                                        <i class="fas fa-user-circle"></i>
                                        <span>Profil Saya</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="fas fa-right-from-bracket"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-gauge-high me-1"></i>Dashboard Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="d-inline logout-form">
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

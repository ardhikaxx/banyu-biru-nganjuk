<header class="admin-topbar">
    <div class="topbar-container">
        <div class="topbar-left">
            <button class="topbar-menu-btn d-lg-none" type="button" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <button class="topbar-menu-btn d-none d-lg-flex" type="button" onclick="toggleSidebarCollapse()" aria-label="Collapse sidebar">
                <i class="fas fa-grip-lines-vertical"></i>
            </button>
            
            <div class="topbar-breadcrumb">
                <div class="breadcrumb-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="breadcrumb-content">
                    <span class="breadcrumb-label">Admin Panel</span>
                    <h1 class="breadcrumb-title">@yield('title', 'Dashboard')</h1>
                </div>
            </div>
        </div>

        <div class="topbar-right">
            <!-- Quick Actions -->
            <div class="topbar-quick-actions d-none d-lg-flex">
                <a href="{{ route('home') }}" class="quick-action-btn" title="Lihat Website">
                    <i class="fas fa-globe"></i>
                    <span>Website</span>
                </a>
            </div>

            <!-- User Profile Dropdown -->
            <div class="topbar-profile dropdown">
                <button class="profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-avatar">
                        <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <div class="profile-status"></div>
                    </div>
                    <div class="profile-info d-none d-md-block">
                        <span class="profile-name">{{ auth()->user()->name }}</span>
                        <span class="profile-role">Administrator</span>
                    </div>
                    <i class="fas fa-chevron-down profile-arrow d-none d-md-inline"></i>
                </button>
                
                <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
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
                        <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-gauge-high"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="fas fa-right-from-bracket"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

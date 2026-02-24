<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Banyu Biru')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin-teal.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-backdrop" aria-hidden="true">
        <span class="orb orb-b"></span>
        <span class="orb orb-c"></span>
    </div>

    @include('partials.admin.sidebar')
    <div class="admin-sidebar-overlay" id="adminSidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-wrapper">
        @include('partials.admin.topbar')
        <main class="admin-content fade-in">
            @yield('content')
        </main>
    </div>

    @include('partials.alerts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            language: { url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' },
            pageLength: 10,
            responsive: true
        });

        const COLLAPSE_KEY = 'admin_sidebar_collapsed_v1';

        function applySidebarPreference() {
            const collapsed = localStorage.getItem(COLLAPSE_KEY) === '1';
            if (window.innerWidth >= 992 && collapsed) {
                document.body.classList.add('admin-collapsed');
            } else {
                document.body.classList.remove('admin-collapsed');
            }
        }

        function toggleSidebar() {
            const sidebar = document.querySelector('.admin-sidebar');
            const overlay = document.getElementById('adminSidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        function toggleSidebarCollapse() {
            document.body.classList.toggle('admin-collapsed');
            localStorage.setItem(COLLAPSE_KEY, document.body.classList.contains('admin-collapsed') ? '1' : '0');
        }

        applySidebarPreference();

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                document.querySelector('.admin-sidebar')?.classList.remove('show');
                document.getElementById('adminSidebarOverlay')?.classList.remove('show');
                applySidebarPreference();
            } else {
                document.body.classList.remove('admin-collapsed');
            }
        });

        document.querySelectorAll('.admin-sidebar .menu-item').forEach((item) => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    document.querySelector('.admin-sidebar')?.classList.remove('show');
                    document.getElementById('adminSidebarOverlay')?.classList.remove('show');
                }
            });
        });

        // Smooth dropdown animation
        document.addEventListener('DOMContentLoaded', function() {
            // Disable Bootstrap's default dropdown animation
            const style = document.createElement('style');
            style.textContent = `
                .dropdown-menu { display: block !important; }
                .dropdown-menu:not(.show) { opacity: 0; pointer-events: none; }
            `;
            document.head.appendChild(style);
        });
    </script>
    @stack('scripts')
</body>
</html>

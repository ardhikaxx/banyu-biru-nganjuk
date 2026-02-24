<footer class="footer">
    <div class="container">
        <div class="row g-4 g-lg-5">
            <div class="col-lg-4">
                <h5 class="mb-3 d-flex align-items-center gap-2 fs-4 text-white">
                    <i class="fas fa-water text-brand-soft"></i>Banyu Biru
                </h5>
                <p class="mb-3 text-white-75 pe-lg-4">Platform resmi pemesanan tiket dan booking pendopo wisata air panas Banyu Biru dengan proses cepat, aman, dan terintegrasi.</p>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge px-3 py-2 fw-normal">Wisata Alam</span>
                    <span class="badge px-3 py-2 fw-normal">Tiket Online</span>
                    <span class="badge px-3 py-2 fw-normal">Booking Pendopo</span>
                </div>
            </div>

            <div class="col-lg-2 col-md-4">
                <h6 class="mb-3 fs-5 text-white">Navigasi</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="{{ route('home') }}" class="footer-link">Beranda</a></li>
                    @auth
                        @if(auth()->user()->hasRole('user'))
                            <li class="mb-2"><a href="{{ route('user.tickets.index') }}" class="footer-link">Tiket</a></li>
                            <li class="mb-2"><a href="{{ route('user.bookings.index') }}" class="footer-link">Booking</a></li>
                            <li class="mb-2"><a href="{{ route('user.profile.index') }}" class="footer-link">Profil</a></li>
                        @endif
                        @if(auth()->user()->hasRole('admin'))
                            <li class="mb-2"><a href="{{ route('admin.dashboard') }}" class="footer-link">Dashboard Admin</a></li>
                        @endif
                    @else
                        <li class="mb-2"><a href="{{ route('login') }}" class="footer-link">Login</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}" class="footer-link">Register</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h6 class="mb-3 fs-5 text-white">Kontak</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 text-white-75"><i class="fas fa-location-dot me-2 text-brand-soft"></i>Nganjuk, Jawa Timur</li>
                    <li class="mb-2 text-white-75"><i class="fas fa-phone me-2 text-brand-soft"></i>+62 8xx xxxx xxxx</li>
                    <li class="mb-2 text-white-75"><i class="fas fa-envelope me-2 text-brand-soft"></i>info@banyubiru.id</li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h6 class="mb-3 fs-5 text-white">Jam Operasional</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 text-white-75">Senin - Jumat: 08.00 - 17.00</li>
                    <li class="mb-2 text-white-75">Sabtu - Minggu: 07.00 - 18.00</li>
                    <li class="mb-2 text-white-75">Hari Libur: 07.00 - 18.00</li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-white-50">
        <div class="text-center text-white-50">
            <small>&copy; {{ date('Y') }} Banyu Biru Nganjuk. All rights reserved.</small>
        </div>
    </div>
</footer>

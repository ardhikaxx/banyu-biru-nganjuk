@extends('layouts.app')

@section('title', 'Profil User')

@section('content')
<div class="page-hero mb-4" data-aos="fade-down">
    <h3 class="mb-1"><i class="fas fa-user me-2"></i>Profil Saya</h3>
    <p class="mb-0">Kelola informasi akun Anda untuk pemesanan tiket dan booking.</p>
</div>

<div class="row g-4">
    <div class="col-lg-4" data-aos="fade-right">
        <div class="card">
            <div class="card-body text-center">
                <div class="user-avatar mx-auto mb-3" style="width: 96px; height: 96px; font-size: 2.3rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <span class="badge bg-primary"><i class="fas fa-user me-1"></i>Member</span>

                <hr>

                <div class="text-start">
                    <div class="mb-2"><small class="text-muted d-block">No. Handphone</small><strong>{{ $user->phone ?? '-' }}</strong></div>
                    <div class="mb-2"><small class="text-muted d-block">Alamat</small><strong>{{ $user->address ?? '-' }}</strong></div>
                    <div><small class="text-muted d-block">Bergabung Sejak</small><strong>{{ $user->created_at->format('d F Y') }}</strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8" data-aos="fade-left">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-user-pen me-2"></i>Edit Profil</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Handphone</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                            @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3"><i class="fas fa-lock me-2"></i>Ubah Password (opsional)</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="password" placeholder="Minimal 8 karakter">
                            @error('password')<small class="text-danger d-block">{{ $message }}</small>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk me-1"></i>Simpan</button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Profil Admin')

@section('content')
<div class="container-fluid page-shell">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-2"><i class="fas fa-user-circle me-2 text-primary"></i>Profil Admin</h3>
            <p class="text-muted mb-0">Kelola informasi akun administrator dan keamanan akses login sistem</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle mx-auto mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 3rem; box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h4 class="mb-2">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <span class="badge bg-primary px-3 py-2">
                        <i class="fas fa-shield-halved me-1"></i>Administrator
                    </span>
                    
                    <hr class="my-4">
                    
                    <div class="text-start">
                        <div class="mb-3 p-3 rounded" style="background: rgba(14, 165, 233, 0.05);">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-phone text-primary me-2"></i>No. Handphone
                            </small>
                            <strong>{{ $user->phone ?? 'Belum diisi' }}</strong>
                        </div>
                        <div class="mb-3 p-3 rounded" style="background: rgba(14, 165, 233, 0.05);">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat
                            </small>
                            <strong>{{ $user->address ?? 'Belum diisi' }}</strong>
                        </div>
                        <div class="p-3 rounded" style="background: rgba(14, 165, 233, 0.05);">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-calendar-check text-primary me-2"></i>Bergabung Sejak
                            </small>
                            <strong>{{ $user->created_at->format('d F Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-gear me-2"></i>Edit Profil</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf @method('PUT')
                        
                        <div class="mb-4">
                            <h6 class="mb-3"><i class="fas fa-user me-2 text-primary"></i>Informasi Pribadi</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">No. Handphone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                                    @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                                    <textarea class="form-control" name="address" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address) }}</textarea>
                                    @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4">
                            <h6 class="mb-3"><i class="fas fa-lock me-2 text-primary"></i>Ubah Password</h6>
                            <div class="alert alert-info d-flex align-items-start">
                                <i class="fas fa-info-circle me-2 mt-1"></i>
                                <small>Kosongkan jika tidak ingin mengubah password. Password minimal 8 karakter.</small>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Password Baru</label>
                                    <input type="password" class="form-control" name="password" placeholder="Minimal 8 karakter">
                                    @error('password')<small class="text-danger d-block">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

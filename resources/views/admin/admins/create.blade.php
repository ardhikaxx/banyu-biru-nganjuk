@extends('layouts.admin')
@section('title', 'Tambah Admin')

@section('content')
<div class="container-fluid page-shell">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Admin</a></li>
            <li class="breadcrumb-item active">Tambah Admin</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-1" style="font-weight: 700; font-size: 1.75rem; color: var(--teal-900);">
                        <i class="fas fa-user-plus me-2" style="color: var(--teal-600);"></i>Tambah Admin Baru
                    </h3>
                    <p class="text-muted mb-0" style="font-size: 0.9375rem;">Tambahkan akun administrator baru untuk akses panel manajemen</p>
                </div>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-user-plus me-2"></i>Form Tambah Admin
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.admins.store') }}">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong> Admin baru akan memiliki akses penuh ke panel manajemen.
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">No. Handphone</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control" name="password" placeholder="Minimal 8 karakter" required>
                                <small class="text-muted">Minimal 8 karakter</small>
                                @error('password')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password" required>
                            </div>
                        </div>
                        
                        <hr class="my-4" style="border-color: var(--teal-100);">
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Admin
                            </button>
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
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

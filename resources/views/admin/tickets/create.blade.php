@extends('layouts.admin')
@section('title', 'Tambah Tiket')

@section('content')
<div class="container-fluid page-shell">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Tiket</a></li>
            <li class="breadcrumb-item active">Tambah Tiket</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1" style="font-weight: 700; font-size: 1.75rem; color: var(--teal-900);">
                <i class="fas fa-plus-circle me-2" style="color: var(--teal-600);"></i>Tambah Tiket Baru
            </h3>
            <p class="text-muted mb-0" style="font-size: 0.9375rem;">Buat data tiket baru yang akan tersedia untuk pembelian</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-ticket-alt me-2"></i>Form Tambah Tiket
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tickets.store') }}">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong> Pastikan semua data diisi dengan benar sebelum menyimpan.
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    Nama Tiket <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Contoh: Tiket Dewasa" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    Harga <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="50000" required>
                                </div>
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    Kuota Per Hari <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="quota_per_day" value="{{ old('quota_per_day') }}" placeholder="100" required>
                                <small class="text-muted">Jumlah maksimal tiket yang dapat dijual per hari</small>
                                @error('quota_per_day')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked style="width: 3rem; height: 1.5rem;">
                                    <label class="form-check-label ms-2" for="isActive" style="font-weight: 600;">
                                        Aktifkan tiket ini
                                    </label>
                                </div>
                                <small class="text-muted">Tiket aktif akan ditampilkan untuk pembelian</small>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Deskripsi tiket (opsional)">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <hr class="my-4" style="border-color: var(--teal-100);">
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Tiket
                            </button>
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">
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

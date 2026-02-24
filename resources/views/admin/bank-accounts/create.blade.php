@extends('layouts.admin')
@section('title', 'Tambah Rekening')

@section('content')
<div class="container-fluid page-shell">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.bank-accounts.index') }}">Rekening Bank</a></li>
            <li class="breadcrumb-item active">Tambah Rekening</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-1" style="font-weight: 700; font-size: 1.75rem; color: var(--teal-900);">
                        <i class="fas fa-building-columns me-2" style="color: var(--teal-600);"></i>Tambah Rekening Bank
                    </h3>
                    <p class="text-muted mb-0" style="font-size: 0.9375rem;">Daftarkan rekening pembayaran baru untuk proses transfer</p>
                </div>
                <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-outline-secondary">
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
                        <i class="fas fa-building-columns me-2"></i>Form Tambah Rekening
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.bank-accounts.store') }}">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong> Rekening aktif akan ditampilkan sebagai opsi pembayaran untuk user.
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    Nama Bank <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="bank_name" required>
                                    <option value="">Pilih Bank</option>
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                    <option value="BTN">BTN</option>
                                    <option value="CIMB Niaga">CIMB Niaga</option>
                                    <option value="Danamon">Danamon</option>
                                    <option value="Permata">Permata</option>
                                    <option value="BSI">BSI (Bank Syariah Indonesia)</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('bank_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    Nomor Rekening <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="account_number" value="{{ old('account_number') }}" placeholder="1234567890" required>
                                @error('account_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    Atas Nama <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="account_name" value="{{ old('account_name') }}" placeholder="Nama pemilik rekening" required>
                                @error('account_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked style="width: 3rem; height: 1.5rem;">
                                    <label class="form-check-label ms-2" for="isActive" style="font-weight: 600;">
                                        Aktifkan rekening ini
                                    </label>
                                </div>
                                <small class="text-muted">Rekening aktif akan ditampilkan sebagai opsi pembayaran</small>
                            </div>
                        </div>
                        
                        <hr class="my-4" style="border-color: var(--teal-100);">
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Rekening
                            </button>
                            <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-outline-secondary">
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

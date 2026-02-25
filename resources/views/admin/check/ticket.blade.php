@extends('layouts.admin')
@section('title', 'Verifikasi Tiket')

@push('styles')
<style>
    .scan-methods {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .scan-method-btn {
        flex: 1;
        padding: 1rem;
        border: 2px solid var(--teal-200);
        border-radius: 12px;
        background: white;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }
    
    .scan-method-btn:hover {
        border-color: var(--teal-500);
        background: var(--teal-50);
    }
    
    .scan-method-btn.active {
        border-color: var(--teal-600);
        background: linear-gradient(135deg, var(--teal-50), white);
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15);
    }
    
    .scan-method-btn i {
        font-size: 2rem;
        color: var(--teal-600);
        margin-bottom: 0.5rem;
    }
    
    .scan-method-btn .method-title {
        font-weight: 700;
        color: var(--teal-900);
        margin-bottom: 0.25rem;
    }
    
    .scan-method-btn .method-desc {
        font-size: 0.875rem;
        color: var(--gray-600);
    }
    
    #qr-reader {
        border: 2px solid var(--teal-200);
        border-radius: 12px;
        overflow: hidden;
        max-width: 500px;
        margin: 0 auto;
    }
    
    #qr-reader__dashboard_section_swaplink {
        display: none !important;
    }
    
    .qr-scanner-container {
        position: relative;
    }
    
    .scanner-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 250px;
        height: 250px;
        border: 3px solid var(--teal-500);
        border-radius: 12px;
        pointer-events: none;
        z-index: 10;
    }
    
    .scanner-overlay::before,
    .scanner-overlay::after {
        content: '';
        position: absolute;
        width: 30px;
        height: 30px;
        border: 4px solid var(--teal-600);
    }
    
    .scanner-overlay::before {
        top: -4px;
        left: -4px;
        border-right: none;
        border-bottom: none;
        border-top-left-radius: 12px;
    }
    
    .scanner-overlay::after {
        bottom: -4px;
        right: -4px;
        border-left: none;
        border-top: none;
        border-bottom-right-radius: 12px;
    }
    
    .scanner-corners {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 30px;
        height: 30px;
        border: 4px solid var(--teal-600);
        border-left: none;
        border-bottom: none;
        border-top-right-radius: 12px;
    }
    
    .scanner-corners-bl {
        position: absolute;
        bottom: -4px;
        left: -4px;
        width: 30px;
        height: 30px;
        border: 4px solid var(--teal-600);
        border-right: none;
        border-top: none;
        border-bottom-left-radius: 12px;
    }
    
    .scan-instruction {
        text-align: center;
        padding: 1rem;
        background: var(--teal-50);
        border-radius: 12px;
        margin-top: 1rem;
    }
    
    .scan-instruction i {
        font-size: 1.5rem;
        color: var(--teal-600);
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid page-shell">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1" style="font-weight: 700; font-size: 1.75rem; color: var(--teal-900);">
                <i class="fas fa-qrcode me-2" style="color: var(--teal-600);"></i>Verifikasi Tiket
            </h3>
            <p class="text-muted mb-0" style="font-size: 0.9375rem;">Scan QR code atau masukkan kode tiket untuk verifikasi</p>
        </div>
    </div>

    <!-- Scan Methods -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="scan-methods">
                <div class="scan-method-btn active" id="qrScanBtn" onclick="switchMethod('qr')">
                    <i class="fas fa-qrcode d-block"></i>
                    <div class="method-title">Scan QR Code</div>
                    <div class="method-desc">Gunakan kamera untuk scan</div>
                </div>
                <div class="scan-method-btn" id="manualInputBtn" onclick="switchMethod('manual')">
                    <i class="fas fa-keyboard d-block"></i>
                    <div class="method-title">Input Manual</div>
                    <div class="method-desc">Ketik kode tiket</div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Scanner -->
    <div class="row" id="qrScannerSection">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-camera me-2"></i>Scanner QR Code
                    </h6>
                </div>
                <div class="card-body">
                    <div class="qr-scanner-container">
                        <div id="qr-reader"></div>
                    </div>
                    <div class="scan-instruction">
                        <i class="fas fa-info-circle d-block"></i>
                        <strong>Arahkan kamera ke QR code tiket</strong>
                        <p class="mb-0 mt-2 text-muted small">Pastikan QR code terlihat jelas dalam frame scanner</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manual Input -->
    <div class="row" id="manualInputSection" style="display: none;">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight: 700;">
                        <i class="fas fa-keyboard me-2"></i>Input Kode Tiket Manual
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.check.ticket.check') }}" id="manualCheckForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kode Tiket</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-ticket-alt"></i></span>
                                <input class="form-control" name="ticket_code" id="ticketCodeInput" placeholder="AT-XXXXX" required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-magnifying-glass me-2"></i>Cek Tiket
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Result -->
    @if(session('ticketItem'))
        @php($item = session('ticketItem'))
        <div class="row mt-4">
            <div class="col-lg-8 mx-auto">
                <div class="card" style="border-color: {{ $item->is_used ? '#fca5a5' : 'var(--teal-200)' }};">
                    <div class="card-header" style="background: {{ $item->is_used ? 'linear-gradient(135deg, #fef2f2, white)' : 'linear-gradient(135deg, var(--teal-50), white)' }};">
                        <h6 class="mb-0" style="font-weight: 700; color: {{ $item->is_used ? '#991b1b' : 'var(--teal-900)' }};">
                            <i class="fas fa-{{ $item->is_used ? 'times-circle' : 'check-circle' }} me-2"></i>
                            Hasil Verifikasi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="p-3 rounded" style="background: var(--teal-50); border: 2px solid var(--teal-100);">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Kode Tiket</small>
                                    <strong style="font-size: 1.125rem; color: var(--teal-900);">{{ $item->ticket_code }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Pemesan</small>
                                    <strong style="font-size: 1rem; color: var(--teal-900);">{{ $item->order->user->name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Status</small>
                                    @if($item->is_used)
                                        <span class="badge bg-danger" style="font-size: 0.875rem;">
                                            <i class="fas fa-times-circle me-1"></i>Sudah Dipakai
                                        </span>
                                    @else
                                        <span class="badge bg-success" style="font-size: 0.875rem;">
                                            <i class="fas fa-check-circle me-1"></i>Valid
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Jenis Tiket</small>
                                    <strong style="font-size: 1rem; color: var(--teal-900);">{{ $item->ticket->name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; border: 2px solid var(--teal-100);">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Tanggal Kunjungan</small>
                                    <strong style="font-size: 1rem; color: var(--teal-900);">
                                        <i class="fas fa-calendar-day me-2" style="color: var(--teal-600);"></i>
                                        {{ $item->order->visit_date->format('d F Y') }}
                                    </strong>
                                </div>
                            </div>
                        </div>

                        @if(!$item->is_used)
                            <hr class="my-4" style="border-color: var(--teal-100);">
                            <form method="POST" action="{{ route('admin.check.ticket.check') }}">
                                @csrf
                                <input type="hidden" name="ticket_code" value="{{ $item->ticket_code }}">
                                <input type="hidden" name="mark_used" value="1">
                                <button class="btn btn-warning" type="submit">
                                    <i class="fas fa-check-double me-2"></i>Tandai Sebagai Dipakai
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    let html5QrCode = null;
    let isScanning = false;

    function switchMethod(method) {
        const qrBtn = document.getElementById('qrScanBtn');
        const manualBtn = document.getElementById('manualInputBtn');
        const qrSection = document.getElementById('qrScannerSection');
        const manualSection = document.getElementById('manualInputSection');

        if (method === 'qr') {
            qrBtn.classList.add('active');
            manualBtn.classList.remove('active');
            qrSection.style.display = 'block';
            manualSection.style.display = 'none';
            startScanner();
        } else {
            qrBtn.classList.remove('active');
            manualBtn.classList.add('active');
            qrSection.style.display = 'none';
            manualSection.style.display = 'block';
            stopScanner();
            document.getElementById('ticketCodeInput').focus();
        }
    }

    function startScanner() {
        if (isScanning) return;

        // Show scanner, hide result if exists
        document.getElementById('qr-reader').style.display = 'block';
        document.querySelector('.scan-instruction').style.display = 'block';
        const scanAgainBtn = document.getElementById('scanAgainBtn');
        if (scanAgainBtn) {
            scanAgainBtn.style.display = 'none';
        }

        html5QrCode = new Html5Qrcode("qr-reader");
        
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            },
            (decodedText, decodedResult) => {
                // QR code berhasil di-scan
                console.log(`QR Code detected: ${decodedText}`);
                
                // Stop scanner dan hide kamera
                stopScanner();
                hideCameraShowResult();
                
                // Submit form dengan kode yang di-scan
                submitTicketCode(decodedText);
            },
            (errorMessage) => {
                // Error saat scanning (normal, tidak perlu ditampilkan)
            }
        ).then(() => {
            isScanning = true;
        }).catch((err) => {
            console.error('Error starting scanner:', err);
            alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
        });
    }

    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => {
                isScanning = false;
                html5QrCode = null;
            }).catch((err) => {
                console.error('Error stopping scanner:', err);
            });
        }
    }

    function hideCameraShowResult() {
        // Hide kamera dan instruksi
        document.getElementById('qr-reader').style.display = 'none';
        document.querySelector('.scan-instruction').style.display = 'none';
        
        // Show tombol scan lagi jika belum ada
        let scanAgainBtn = document.getElementById('scanAgainBtn');
        if (!scanAgainBtn) {
            scanAgainBtn = document.createElement('div');
            scanAgainBtn.id = 'scanAgainBtn';
            scanAgainBtn.className = 'text-center mt-3';
            scanAgainBtn.innerHTML = `
                <div class="alert alert-info mb-3">
                    <i class="fas fa-spinner fa-spin me-2"></i>Memproses QR Code...
                </div>
            `;
            document.querySelector('.qr-scanner-container').appendChild(scanAgainBtn);
        } else {
            scanAgainBtn.style.display = 'block';
        }
    }

    function submitTicketCode(ticketCode) {
        // Buat form dan submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('admin.check.ticket.check') }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const codeInput = document.createElement('input');
        codeInput.type = 'hidden';
        codeInput.name = 'ticket_code';
        codeInput.value = ticketCode;
        
        form.appendChild(csrfInput);
        form.appendChild(codeInput);
        document.body.appendChild(form);
        form.submit();
    }

    // Start scanner on page load
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('ticketItem'))
            // Jika ada hasil, tampilkan tombol scan lagi
            const qrReader = document.getElementById('qr-reader');
            const scanInstruction = document.querySelector('.scan-instruction');
            if (qrReader) qrReader.style.display = 'none';
            if (scanInstruction) scanInstruction.style.display = 'none';
            
            let scanAgainBtn = document.getElementById('scanAgainBtn');
            if (!scanAgainBtn) {
                scanAgainBtn = document.createElement('div');
                scanAgainBtn.id = 'scanAgainBtn';
                scanAgainBtn.className = 'text-center mt-3';
                scanAgainBtn.innerHTML = `
                    <button class="btn btn-primary btn-lg" onclick="startScanner()">
                        <i class="fas fa-qrcode me-2"></i>Scan Lagi
                    </button>
                `;
                document.querySelector('.qr-scanner-container').appendChild(scanAgainBtn);
            }
        @else
            startScanner();
        @endif
    });

    // Stop scanner when leaving page
    window.addEventListener('beforeunload', function() {
        stopScanner();
    });
</script>
@endpush



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: DejaVu Sans, sans-serif;
            background: #f0fdfa;
            padding: 20px;
        }
        
        .ticket-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }
        
        .ticket-box { 
            border: 3px solid #0f766e;
            border-radius: 16px;
            overflow: hidden;
            background: white;
            box-shadow: 0 10px 30px rgba(15, 118, 110, 0.2);
            position: relative;
        }
        
        .ticket-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.08;
            z-index: 0;
        }
        
        .ticket-content {
            position: relative;
            z-index: 1;
        }
        
        .header { 
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
            color: white;
            text-align: center;
            padding: 25px 20px;
            position: relative;
        }
        
        .header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 20px;
            background: white;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        }
        
        .header h1 {
            font-size: 32px;
            font-weight: bold;
            margin: 0 0 8px 0;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .header p {
            font-size: 14px;
            margin: 0;
            opacity: 0.95;
        }
        
        .ticket-body {
            padding: 30px 25px 25px 25px;
        }
        
        .qr-section { 
            text-align: center;
            margin: 0 0 25px 0;
            padding: 20px;
            background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
            border-radius: 12px;
            border: 2px dashed #14b8a6;
        }
        
        .qr-code-wrapper {
            background: white;
            padding: 15px;
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.15);
            margin-bottom: 12px;
        }
        
        .ticket-code { 
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #0f766e;
            margin-top: 8px;
            padding: 8px 16px;
            background: white;
            border-radius: 8px;
            display: inline-block;
        }
        
        .info-section {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .info-row { 
            display: table;
            width: 100%;
            margin: 12px 0;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .info-label {
            display: table-cell;
            width: 45%;
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
        }
        
        .info-value {
            display: table-cell;
            width: 55%;
            font-size: 14px;
            color: #111827;
            font-weight: bold;
            text-align: right;
        }
        
        .price-highlight {
            color: #0f766e;
            font-size: 16px;
        }
        
        .footer-note {
            text-align: center;
            color: #6b7280;
            font-size: 11px;
            margin-top: 20px;
            padding: 15px;
            background: #fef3c7;
            border-radius: 8px;
            border-left: 4px solid #f59e0b;
        }
        
        .footer-note strong {
            color: #92400e;
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .watermark { 
            position: fixed;
            opacity: 0.03;
            font-size: 80px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-weight: bold;
            color: #0f766e;
            z-index: 0;
            letter-spacing: 8px;
        }
        
        .ticket-corner {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 3px solid #14b8a6;
        }
        
        .corner-tl {
            top: -3px;
            left: -3px;
            border-right: none;
            border-bottom: none;
            border-radius: 16px 0 0 0;
        }
        
        .corner-tr {
            top: -3px;
            right: -3px;
            border-left: none;
            border-bottom: none;
            border-radius: 0 16px 0 0;
        }
        
        .corner-bl {
            bottom: -3px;
            left: -3px;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 16px;
        }
        
        .corner-br {
            bottom: -3px;
            right: -3px;
            border-left: none;
            border-top: none;
            border-radius: 0 0 16px 0;
        }
    </style>
</head>
<body>
    <div class="watermark">BANYU BIRU NGANJUK</div>
    
    <div class="ticket-container">
        <div class="ticket-box">
            <!-- Background Image -->
            @if(file_exists(public_path('images/background.jpg')))
                <img src="{{ public_path('images/background.jpg') }}" class="ticket-background" alt="Background">
            @endif
            
            <!-- Decorative Corners -->
            <div class="ticket-corner corner-tl"></div>
            <div class="ticket-corner corner-tr"></div>
            <div class="ticket-corner corner-bl"></div>
            <div class="ticket-corner corner-br"></div>
            
            <div class="ticket-content">
                <!-- Header -->
                <div class="header">
                    <h1>BANYU BIRU</h1>
                    <p>Pemandian Air Panas Nganjuk</p>
                </div>
                
                <!-- Body -->
                <div class="ticket-body">
                    <!-- QR Code Section -->
                    <div class="qr-section">
                        <div class="qr-code-wrapper">
                            @if(file_exists(public_path($item->qr_code_path)))
                                <img src="{{ public_path($item->qr_code_path) }}" style="height:140px; width:140px;" alt="QR Code">
                            @endif
                        </div>
                        <div class="ticket-code">{{ $item->ticket_code }}</div>
                    </div>
                    
                    <!-- Info Section -->
                    <div class="info-section">
                        <div class="info-row">
                            <span class="info-label">Nama Pemesan</span>
                            <span class="info-value">{{ $order->user->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Jenis Tiket</span>
                            <span class="info-value">{{ $item->ticket->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tanggal Kunjungan</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('dddd, D MMMM Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Harga Tiket</span>
                            <span class="info-value price-highlight">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <!-- Footer Note -->
                    <div class="footer-note">
                        <strong>⚠ PENTING</strong>
                        Tunjukkan tiket ini kepada petugas di pintu masuk. Tiket hanya berlaku untuk 1 (satu) kali kunjungan sesuai tanggal yang tertera. Simpan tiket ini sampai kunjungan selesai.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
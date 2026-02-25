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
            max-width: 850px;
            margin: 0 auto;
            position: relative;
        }
        
        .ticket-box { 
            border: 5px solid #0f766e;
            border-radius: 24px;
            overflow: hidden;
            background: white;
            box-shadow: 0 20px 60px rgba(15, 118, 110, 0.4);
            position: relative;
        }
        
        .ticket-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.03;
            z-index: 0;
        }
        
        .ticket-content {
            position: relative;
            z-index: 1;
        }
        
        /* Header dengan wave pattern */
        .header { 
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #115e59 100%);
            color: white;
            text-align: center;
            padding: 40px 30px 50px 30px;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -50%;
            width: 200%;
            height: 100%;
            background: radial-gradient(circle at 30% 50%, rgba(20, 184, 166, 0.3) 0%, transparent 50%);
            animation: wave 15s ease-in-out infinite;
        }
        
        .header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 40px;
            background: white;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        }
        
        @keyframes wave {
            0%, 100% { transform: translateX(0) translateY(0); }
            50% { transform: translateX(10%) translateY(-5%); }
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }
        
        .header-icon-inner {
            width: 35px;
            height: 35px;
            background: white;
            border-radius: 50%;
        }
        
        .header h1 {
            font-size: 48px;
            font-weight: 900;
            margin: 0 0 12px 0;
            letter-spacing: 6px;
            text-shadow: 4px 4px 8px rgba(0,0,0,0.4);
            color: #ffffff;
            text-transform: uppercase;
        }
        
        .header p {
            font-size: 18px;
            margin: 0;
            font-weight: 600;
            color: #ccfbf1;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .ticket-body {
            padding: 40px 35px 35px 35px;
        }
        
        /* QR Section dengan layout horizontal */
        .qr-section { 
            display: table;
            width: 100%;
            margin: 0 0 35px 0;
            padding: 30px;
            background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%);
            border-radius: 20px;
            border: 4px dashed #14b8a6;
            position: relative;
        }
        
        .qr-section::before {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
            border-radius: 20px;
            z-index: -1;
            opacity: 0.08;
        }
        
        .qr-left {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            text-align: center;
            padding-right: 20px;
        }
        
        .qr-right {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            text-align: center;
            padding-left: 20px;
            border-left: 3px solid #14b8a6;
        }
        
        .qr-code-wrapper {
            background: white;
            padding: 20px;
            border-radius: 16px;
            display: inline-block;
            box-shadow: 0 8px 25px rgba(15, 118, 110, 0.3);
            border: 4px solid #0f766e;
        }
        
        .qr-label {
            font-size: 13px;
            color: #0f766e;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .ticket-code { 
            font-size: 32px;
            font-weight: 900;
            letter-spacing: 5px;
            color: #0f766e;
            padding: 15px 25px;
            background: white;
            border-radius: 12px;
            display: inline-block;
            border: 3px solid #14b8a6;
            box-shadow: 0 6px 20px rgba(15, 118, 110, 0.2);
            margin-top: 10px;
        }
        
        .divider {
            height: 4px;
            background: linear-gradient(90deg, transparent 0%, #14b8a6 20%, #0f766e 50%, #14b8a6 80%, transparent 100%);
            margin: 30px 0;
            border-radius: 2px;
        }
        
        .info-section {
            background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            border: 3px solid #ccfbf1;
            box-shadow: 0 4px 15px rgba(15, 118, 110, 0.08);
        }
        
        .info-row { 
            display: table;
            width: 100%;
            margin: 18px 0;
            padding: 15px 0;
            border-bottom: 3px solid #e0f2fe;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .info-label {
            display: table-cell;
            width: 45%;
            font-size: 15px;
            color: #0f766e;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            display: table-cell;
            width: 55%;
            font-size: 16px;
            color: #111827;
            font-weight: 700;
            text-align: right;
        }
        
        .price-highlight {
            color: #0f766e;
            font-size: 20px;
            background: #ccfbf1;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 900;
            border: 2px solid #14b8a6;
        }
        
        .footer-note {
            text-align: center;
            color: #0f766e;
            font-size: 13px;
            margin-top: 30px;
            padding: 22px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 16px;
            border: 4px solid #fbbf24;
            font-weight: 600;
            line-height: 1.6;
        }
        
        .footer-note strong {
            color: #92400e;
            display: block;
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .watermark { 
            position: fixed;
            opacity: 0.015;
            font-size: 120px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-weight: 900;
            color: #0f766e;
            z-index: 0;
            letter-spacing: 15px;
        }
        
        .ticket-corner {
            position: absolute;
            width: 50px;
            height: 50px;
            border: 5px solid #14b8a6;
        }
        
        .corner-tl {
            top: -5px;
            left: -5px;
            border-right: none;
            border-bottom: none;
            border-radius: 24px 0 0 0;
        }
        
        .corner-tr {
            top: -5px;
            right: -5px;
            border-left: none;
            border-bottom: none;
            border-radius: 0 24px 0 0;
        }
        
        .corner-bl {
            bottom: -5px;
            left: -5px;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 24px;
        }
        
        .corner-br {
            bottom: -5px;
            right: -5px;
            border-left: none;
            border-top: none;
            border-radius: 0 0 24px 0;
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
                    <div class="header-content">
                        <div class="header-icon">
                            <div class="header-icon-inner"></div>
                        </div>
                        <h1>BANYU BIRU</h1>
                        <p>Pemandian Air Panas Nganjuk</p>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="ticket-body">
                    <!-- QR Code Section dengan layout horizontal -->
                    <div class="qr-section">
                        <div class="qr-left">
                            <div class="qr-label">Scan QR Code</div>
                            <div class="qr-code-wrapper">
                                @if(file_exists(public_path($item->qr_code_path)))
                                    <img src="{{ public_path($item->qr_code_path) }}" style="height:160px; width:160px; display:block;" alt="QR Code">
                                @endif
                            </div>
                        </div>
                        <div class="qr-right">
                            <div class="qr-label">Kode Tiket</div>
                            <div class="ticket-code">{{ $item->ticket_code }}</div>
                        </div>
                    </div>
                    
                    <div class="divider"></div>
                    
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
                        <strong>⚠ PENTING - HARAP DIBACA</strong>
                        Tunjukkan tiket ini kepada petugas di pintu masuk. Tiket hanya berlaku untuk 1 (satu) kali kunjungan sesuai tanggal yang tertera. Simpan tiket ini sampai kunjungan selesai.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
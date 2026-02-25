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
            border: 4px solid #0f766e;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            box-shadow: 0 15px 40px rgba(15, 118, 110, 0.3);
            position: relative;
        }
        
        .ticket-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.04;
            z-index: 0;
        }
        
        .ticket-content {
            position: relative;
            z-index: 1;
        }
        
        .header { 
            background: #0f766e;
            color: white;
            text-align: center;
            padding: 30px 20px;
            position: relative;
            border-bottom: 5px solid #14b8a6;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.2) 0%, transparent 100%);
            z-index: 0;
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header h1 {
            font-size: 40px;
            font-weight: bold;
            margin: 0 0 10px 0;
            letter-spacing: 4px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            color: #ffffff;
        }
        
        .header p {
            font-size: 16px;
            margin: 0;
            font-weight: 600;
            color: #ccfbf1;
            letter-spacing: 1px;
        }
        
        .ticket-body {
            padding: 35px 30px 30px 30px;
        }
        
        .qr-section { 
            text-align: center;
            margin: 0 0 30px 0;
            padding: 25px;
            background: #f0fdfa;
            border-radius: 16px;
            border: 3px solid #14b8a6;
            position: relative;
        }
        
        .qr-section::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
            border-radius: 16px;
            z-index: -1;
            opacity: 0.1;
        }
        
        .qr-code-wrapper {
            background: white;
            padding: 18px;
            border-radius: 12px;
            display: inline-block;
            box-shadow: 0 6px 20px rgba(15, 118, 110, 0.25);
            margin-bottom: 15px;
            border: 3px solid #0f766e;
        }
        
        .ticket-code { 
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #0f766e;
            margin-top: 10px;
            padding: 10px 20px;
            background: white;
            border-radius: 10px;
            display: inline-block;
            border: 2px solid #14b8a6;
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.15);
        }
        
        .info-section {
            background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            border: 2px solid #ccfbf1;
        }
        
        .info-row { 
            display: table;
            width: 100%;
            margin: 15px 0;
            padding: 12px 0;
            border-bottom: 2px solid #e0f2fe;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .info-label {
            display: table-cell;
            width: 45%;
            font-size: 14px;
            color: #0f766e;
            font-weight: 700;
        }
        
        .info-value {
            display: table-cell;
            width: 55%;
            font-size: 15px;
            color: #111827;
            font-weight: bold;
            text-align: right;
        }
        
        .price-highlight {
            color: #0f766e;
            font-size: 18px;
            background: #ccfbf1;
            padding: 5px 12px;
            border-radius: 8px;
        }
        
        .footer-note {
            text-align: center;
            color: #0f766e;
            font-size: 12px;
            margin-top: 25px;
            padding: 18px;
            background: #fef3c7;
            border-radius: 12px;
            border: 3px solid #fbbf24;
            font-weight: 600;
        }
        
        .footer-note strong {
            color: #92400e;
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 800;
        }
        
        .watermark { 
            position: fixed;
            opacity: 0.02;
            font-size: 100px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-weight: bold;
            color: #0f766e;
            z-index: 0;
            letter-spacing: 10px;
        }
        
        .ticket-corner {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 4px solid #14b8a6;
        }
        
        .corner-tl {
            top: -4px;
            left: -4px;
            border-right: none;
            border-bottom: none;
            border-radius: 20px 0 0 0;
        }
        
        .corner-tr {
            top: -4px;
            right: -4px;
            border-left: none;
            border-bottom: none;
            border-radius: 0 20px 0 0;
        }
        
        .corner-bl {
            bottom: -4px;
            left: -4px;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 20px;
        }
        
        .corner-br {
            bottom: -4px;
            right: -4px;
            border-left: none;
            border-top: none;
            border-radius: 0 0 20px 0;
        }
        
        .divider {
            height: 3px;
            background: linear-gradient(90deg, transparent 0%, #14b8a6 50%, transparent 100%);
            margin: 20px 0;
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
                        <h1>BANYU BIRU</h1>
                        <p>Pemandian Air Panas Nganjuk</p>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="ticket-body">
                    <!-- QR Code Section -->
                    <div class="qr-section">
                        <div class="qr-code-wrapper">
                            @if(file_exists(public_path($item->qr_code_path)))
                                <img src="{{ public_path($item->qr_code_path) }}" style="height:150px; width:150px;" alt="QR Code">
                            @endif
                        </div>
                        <div class="ticket-code">{{ $item->ticket_code }}</div>
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
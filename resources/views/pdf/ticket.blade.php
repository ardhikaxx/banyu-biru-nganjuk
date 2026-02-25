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
            background: #f0f9ff;
            padding: 30px 20px;
        }
        
        .ticket-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .ticket-box { 
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
            border-radius: 24px;
            padding: 40px 35px;
            box-shadow: 0 20px 60px rgba(15, 118, 110, 0.15);
            position: relative;
        }
        
        /* Header Section */
        .ticket-header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .header-left {
            display: table-cell;
            width: 60%;
            vertical-align: middle;
        }
        
        .header-right {
            display: table-cell;
            width: 40%;
            vertical-align: middle;
            text-align: right;
        }
        
        .brand-name {
            font-size: 32px;
            font-weight: 900;
            color: #0f766e;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        
        .brand-subtitle {
            font-size: 13px;
            color: #0f766e;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .ticket-type {
            font-size: 11px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }
        
        .ticket-name {
            font-size: 16px;
            color: #0f766e;
            font-weight: 800;
        }
        
        /* Destination Section */
        .destination-section {
            text-align: center;
            margin-bottom: 35px;
        }
        
        .destination-code {
            font-size: 48px;
            font-weight: 900;
            color: #0f766e;
            letter-spacing: 8px;
            margin-bottom: 8px;
        }
        
        .destination-detail {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
        }
        
        /* QR Section */
        .qr-section {
            text-align: center;
            margin-bottom: 35px;
            padding: 25px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(15, 118, 110, 0.1);
        }
        
        .qr-label {
            font-size: 10px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        
        .qr-code-wrapper {
            display: inline-block;
            padding: 15px;
            background: white;
            border: 3px solid #e0f2fe;
            border-radius: 12px;
        }
        
        .ticket-code-text {
            font-size: 16px;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 3px;
            margin-top: 15px;
        }
        
        /* Info Grid */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            padding: 18px 0;
            border-bottom: 2px solid #e0f2fe;
        }
        
        .info-cell:first-child {
            width: 50%;
            padding-right: 15px;
        }
        
        .info-cell:last-child {
            width: 50%;
            padding-left: 15px;
            text-align: right;
        }
        
        .info-label {
            font-size: 11px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            display: block;
        }
        
        .info-value {
            font-size: 18px;
            color: #0f766e;
            font-weight: 800;
        }
        
        .info-value-large {
            font-size: 22px;
            color: #0f766e;
            font-weight: 900;
        }
        
        /* Footer Note */
        .footer-note {
            text-align: center;
            font-size: 11px;
            color: #64748b;
            line-height: 1.6;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px dashed #cbd5e1;
        }
        
        .footer-note strong {
            color: #0f766e;
            font-weight: 800;
        }
        
        /* Decorative Elements */
        .ticket-corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid #0f766e;
        }
        
        .corner-tl {
            top: 15px;
            left: 15px;
            border-right: none;
            border-bottom: none;
        }
        
        .corner-tr {
            top: 15px;
            right: 15px;
            border-left: none;
            border-bottom: none;
        }
        
        .corner-bl {
            bottom: 15px;
            left: 15px;
            border-right: none;
            border-top: none;
        }
        
        .corner-br {
            bottom: 15px;
            right: 15px;
            border-left: none;
            border-top: none;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="ticket-box">
            <!-- Decorative Corners -->
            <div class="ticket-corner corner-tl"></div>
            <div class="ticket-corner corner-tr"></div>
            <div class="ticket-corner corner-bl"></div>
            <div class="ticket-corner corner-br"></div>
            
            <!-- Header -->
            <div class="ticket-header">
                <div class="header-left">
                    <div class="brand-name">BANYU BIRU</div>
                    <div class="brand-subtitle">Pemandian Air Panas Nganjuk</div>
                </div>
                <div class="header-right">
                    <div class="ticket-type">Tiket</div>
                    <div class="ticket-name">{{ $item->ticket->name }}</div>
                </div>
            </div>
            
            <!-- Destination Code -->
            <div class="destination-section">
                <div class="destination-code">WISATA</div>
                <div class="destination-detail">{{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('dddd, D MMMM Y') }}</div>
            </div>
            
            <!-- QR Code -->
            <div class="qr-section">
                <div class="qr-label">Scan untuk verifikasi</div>
                <div class="qr-code-wrapper">
                    @if(file_exists(public_path($item->qr_code_path)))
                        <img src="{{ public_path($item->qr_code_path) }}" style="width:180px; height:180px; display:block;" alt="QR Code">
                    @endif
                </div>
                <div class="ticket-code-text">{{ $item->ticket_code }}</div>
            </div>
            
            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <span class="info-label">Nama Pemesan</span>
                        <div class="info-value">{{ $order->user->name }}</div>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Harga</span>
                        <div class="info-value-large">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer-note">
                <strong>Tunjukkan tiket ini kepada petugas.</strong><br>
                Tiket berlaku 1x kunjungan sesuai tanggal tertera.
            </div>
        </div>
    </div>
</body>
</html>
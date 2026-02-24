<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .ticket-box { border: 2px dashed #1a6b4a; border-radius: 12px; padding: 20px; }
        .header { background: #1a6b4a; color: white; text-align: center; padding: 15px; }
        .qr-section { text-align: center; margin: 20px 0; }
        .ticket-code { font-size: 24px; font-weight: bold; letter-spacing: 4px; }
        .info-row { display: flex; justify-content: space-between; margin: 8px 0; }
        .watermark { position: fixed; opacity: 0.05; font-size: 60px; top: 40%; left: 20%; transform: rotate(-45deg); }
    </style>
</head>
<body>
    <div class="watermark">BANYU BIRU</div>
    <div class="ticket-box">
        <div class="header">
            <h2>BANYU BIRU</h2>
            <p>Pemandian Air Panas Nganjuk</p>
        </div>
        <div class="qr-section">
            @if(file_exists(public_path($item->qr_code_path)))
                <img src="{{ public_path($item->qr_code_path) }}" style="height:150px;" alt="QR Code">
            @endif
            <div class="ticket-code">{{ $item->ticket_code }}</div>
        </div>
        <div class="info-row"><span>Nama Pemesan</span><span>{{ $order->user->name }}</span></div>
        <div class="info-row"><span>Jenis Tiket</span><span>{{ $item->ticket->name }}</span></div>
        <div class="info-row"><span>Tanggal Kunjungan</span><span>{{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('dddd, D MMMM Y') }}</span></div>
        <div class="info-row"><span>Harga</span><span>Rp {{ number_format($item->price, 0, ',', '.') }}</span></div>
        <p style="text-align:center; color:#6c757d; font-size:12px; margin-top:14px;">Tunjukkan tiket ini kepada petugas. Tiket hanya berlaku 1x.</p>
    </div>
</body>
</html>
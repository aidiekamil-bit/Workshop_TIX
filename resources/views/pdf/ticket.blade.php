<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Tiket {{ $registration->ticket_code }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; margin: 0; padding: 20px; }
        .ticket-box { border: 2px dashed #0d9488; border-radius: 15px; padding: 30px; background: #fdfdfd; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #0d9488; letter-spacing: 1px; }
        .title { font-size: 20px; font-weight: bold; color: #1e293b; margin-top: 10px; }
        .info-row { margin-bottom: 12px; font-size: 14px; }
        .label { font-weight: bold; color: #64748b; display: inline-block; width: 130px; }
        .value { color: #0f172a; font-weight: 600; }
        .code-box { background: #0f172a; color: #fff; text-align: center; padding: 15px; border-radius: 10px; font-size: 22px; font-family: monospace; font-weight: bold; margin-top: 25px; letter-spacing: 2px; }
        .footer { text-align: center; font-size: 11px; color: #94a3b8; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="ticket-box">
        <div class="header">
            <div class="logo">WORKSHOPTIX</div>
            <div class="title">{{ $registration->workshop->title }}</div>
        </div>

        <div class="info-row">
            <span class="label">Nama Peserta:</span>
            <span class="value">{{ $registration->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Pemateri:</span>
            <span class="value">{{ $registration->workshop->speaker }}</span>
        </div>
        <div class="info-row">
            <span class="label">Tanggal:</span>
            <span class="value">{{ date('d M Y', strtotime($registration->workshop->date)) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Waktu:</span>
            <span class="value">{{ date('H:i', strtotime($registration->workshop->time)) }} WIB</span>
        </div>
        <div class="info-row">
            <span class="label">Status Bayar:</span>
            <span class="value" style="color: #059669;">{{ strtoupper($registration->payment_status) }}</span>
        </div>

        <div class="code-box">
            {{ $registration->ticket_code }}
        </div>

        <div class="footer">
            Harap tunjukkan e-tiket ini kepada panitia saat registrasi ulang di lokasi workshop.
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Электронный билет — {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #0A0A0B; color: #EFEDE8; margin: 0; padding: 20px; }
        .ticket { background: #1A1A1E; border: 1px solid rgba(255,255,255,0.16); border-radius: 8px; margin-bottom: 20px; display: table; width: 100%; box-sizing: border-box; }
        .ticket-left { display: table-cell; padding: 20px; vertical-align: top; }
        .ticket-right { display: table-cell; width: 160px; padding: 20px; border-left: 1px dashed rgba(255,255,255,0.16); text-align: center; vertical-align: middle; background: rgba(255,255,255,0.02); }
        .title { font-size: 20px; font-weight: bold; color: #C6A368; margin-bottom: 6px; }
        .meta { font-size: 13px; color: #8B8B91; margin-bottom: 16px; }
        .grid { display: table; width: 100%; margin-top: 10px; }
        .col { display: table-cell; font-size: 12px; }
        .col span { display: block; color: #5E5E64; text-transform: uppercase; font-size: 10px; margin-bottom: 2px; }
        .code { font-family: monospace; font-size: 11px; color: #8B8B91; margin-top: 8px; }
        @media print {
            body { background: #fff; color: #000; }
            .ticket { background: #fff; border: 1px solid #ccc; color: #000; }
            .title { color: #000; }
            .ticket-right { border-left-color: #ccc; }
        }
    </style>
</head>
<body>
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #C6A368;">БИЛЕТНЫЙ ПОРТАЛ · КОСТАНАЙ</h2>
        <p style="margin: 4px 0 0; font-size: 12px; color: #8B8B91;">Заказ № {{ $order->order_number }} · ФИО: {{ $order->customer_name }}</p>
    </div>

    @foreach($order->tickets as$ticket)
        @php
            $sign = strtoupper(substr(hash('sha256',$ticket->ticket_code . '|' . $secret), 0, 6));$qrPayload = $ticket->ticket_code . '\vert{}' .$sign;
        @endphp
        <div class="ticket">
            <div class="ticket-left">
                <div class="meta">{{ $order->event->hall->name }}</div>
                <div class="title">{{ $order->event->title }}</div>
                <div class="meta">📅 {{ $order->event->start_at->format('d.m.Y H:i') }}</div>

                <div class="grid">
                    <div class="col"><span>Ряд</span><b>{{ $ticket->seat->row_number }}</b></div>
                    <div class="col"><span>Место</span><b>{{ $ticket->seat->seat_number }}</b></div>
                    <div class="col"><span>Зона</span><b>{{ strtoupper($ticket->seat->zone) }}</b></div>
                    <div class="col"><span>Стоимость</span><b>{{ number_format($ticket->price, 0, '', ' ') }} ₸</b></div>
                </div>
            </div>
            <div class="ticket-right">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data={{ urlencode($qrPayload) }}" alt="QR" style="width: 110px; height: 110px; border-radius: 4px;">
                <div class="code">{{ $ticket->ticket_code }}</div>
            </div>
        </div>
    @endforeach
</body>
</html>
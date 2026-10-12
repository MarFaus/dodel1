<x-app-layout title="Мои заказы — Билетный Портал">
    <div class="wrap" style="padding-top: 30px;">
        <h2 style="font-family: var(--display); font-weight: 300; font-size: 24px; margin-bottom: 20px;">Мои заказы</h2>

        <x-panel title="Информация о бронировании">
            <p style="margin: 0; font-size: 13.5px; color: var(--mut);">
                Электронные билеты с уникальным QR-кодом отправляются на вашу почту и доступны для скачивания сразу после оплаты.
            </p>
        </x-panel>

        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif
        @if(session('warning'))
            <x-alert type="warning" :message="session('warning')" />
        @endif

        @if($orders->isEmpty())
            <x-alert type="info" message="У вас пока нет активных или завершённых заказов." />
        @else
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($orders as $order)
                    <x-order-card
                        :number="$order->order_number"
                        :eventTitle="$order->event->title"
                        :date="$order->event->start_at->format('d.m.Y H:i')"
                        :total="$order->total_amount"
                        :status="$order->status"
                    >
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <div>
                                <b>Билеты:</b>
                                @foreach($order->tickets as $ticket)
                                    Ряд {{ $ticket->seat->row_number }} м.{{ $ticket->seat->seat_number }} ({{ $ticket->ticket_code }})@if(!$loop->last), @endif
                                @endforeach
                            </div>
                            @if($order->status === 'paid')
                                <a href="{{ route('orders.pdf', $order->order_number) }}" class="btn ghost" style="font-size: 11.5px; padding: 4px 10px;">PDF Билет</a>
                            @endif
                        </div>
                    </x-order-card>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
<x-app-layout title="Аналитика продаж — Билетный Портал">
    <div class="wrap" style="padding-top: 30px;">
        <h2 style="font-family: var(--display); font-weight: 300; font-size: 24px; margin-bottom: 20px;">Аналитика продаж</h2>

        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px; background: var(--line); border: 1px solid var(--line); border-radius: 6px; overflow: hidden; margin-bottom: 28px;">
            <div style="background: var(--surface); padding: 20px;">
                <span style="font-size: 11px; letter-spacing: .14em; text-transform: uppercase; color: var(--dim);">Выручка</span>
                <b style="display: block; font-family: var(--display); font-weight: 300; font-size: 26px; margin-top: 6px; color: var(--gold);">{{ number_format($totalRevenue, 0, '', ' ') }} ₸</b>
            </div>
            <div style="background: var(--surface); padding: 20px;">
                <span style="font-size: 11px; letter-spacing: .14em; text-transform: uppercase; color: var(--dim);">Продано билетов</span>
                <b style="display: block; font-family: var(--display); font-weight: 300; font-size: 26px; margin-top: 6px;">{{ $totalSoldTickets }} шт.</b>
            </div>
        </div>

        <h3 style="font-family: var(--display); font-size: 18px; margin-bottom: 16px;">Транзакции и возвраты</h3>
        @if($paidOrders->isEmpty())
            <x-alert type="info" message="Оплаченных заказов пока нет." />
        @else
            <div style="display: flex; flex-direction: column; gap: 1px; background: var(--line); border: 1px solid var(--line); border-radius: 6px; overflow: hidden;">
                @foreach($paidOrders as $ord)
                    <div style="background: var(--surface); padding: 16px 18px; display: flex; align-items: center; justify-content: space-between; gap: 16px;">
                        <div>
                            <b style="font-size: 14.5px;">{{ $ord->order_number }} — {{ $ord->customer_name }}</b>
                            <span style="display: block; font-size: 12.5px; color: var(--mut);">{{ $ord->event->title }} · {{ $ord->customer_email }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <b style="font-family: var(--display); font-size: 16px; color: var(--gold);">{{ number_format($ord->total_amount, 0, '', ' ') }} ₸</b>
                            <form action="{{ route('analytics.refund', $ord->order_number) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn ghost" style="font-size: 11.5px; padding: 4px 10px;">Вернуть</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
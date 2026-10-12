@props(['orderNumber' => '', 'eventName' => '', 'price' => 0, 'status' => 'pending', 'seatsInfo' => ''])
@php
    $numericPrice = is_numeric($price) ? (float) $price : 0;
@endphp
<div id="order-card-{{ $orderNumber }}" style="background: var(--surface); border: 1px solid var(--line); border-radius: 8px; padding: 20px; margin-bottom: 16px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
        <span style="font-family: var(--display); font-size: 15px; color: var(--fg);">Заказ №{{ $orderNumber }}</span>
        <x-badge :status="$status" />
    </div>

    <div style="font-size: 14px; color: var(--mut); margin-bottom: 8px;">
        <strong style="color: var(--fg);">{{ $eventName }}</strong>
    </div>

    <div style="font-size: 13px; color: var(--dim); margin-bottom: 12px;">
        Выбранные места: <span style="color: var(--fg);">{{ $seatsInfo }}</span>
    </div>

    <div style="font-family: var(--display); font-size: 18px; color: var(--gold); margin-bottom: 16px;">
        {{ number_format($numericPrice, 0, '', ' ') }} ₸
    </div>

    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        @if($status === 'pending' || $status === 'Ожидает оплаты')
            <button onclick="payOrder('{{ $orderNumber }}')" style="background: var(--gold); color: #17120A; border: none; padding: 8px 16px; border-radius: 4px; font-weight: 600; font-size: 13px; cursor: pointer;">💳 Оплатить</button>
            <button onclick="cancelOrder('{{ $orderNumber }}')" style="background: transparent; color: var(--bad); border: 1px solid rgba(200,88,76,.4); padding: 8px 16px; border-radius: 4px; font-size: 13px; cursor: pointer;">❌ Отменить</button>
        @elseif($status === 'paid' || $status === 'Оплачен')
            <button onclick="downloadTicket('{{ $orderNumber }}')" style="background: rgba(111,185,139,.15); color: var(--ok); border: 1px solid rgba(111,185,139,.4); padding: 8px 16px; border-radius: 4px; font-size: 13px; cursor: pointer;">📥 Скачать PDF-билет</button>
        @endif

        <button onclick="deleteOrder('{{ $orderNumber }}')" style="background: transparent; color: var(--dim); border: 1px solid var(--line); padding: 8px 16px; border-radius: 4px; font-size: 13px; margin-left: auto; cursor: pointer;">🗑 Удалить заказ</button>
    </div>
</div>
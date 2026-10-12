@props(['status' => 'Ожидает оплаты'])
@php
    $style = match($status) {
        'Оплачен', 'paid' => 'color: #6FB98B; border-color: rgba(111,185,139,.4); background: rgba(111,185,139,.08);',
        'Ожидает оплаты', 'pending' => 'color: #D2A14B; border-color: rgba(210,161,75,.4); background: rgba(210,161,75,.08);',
        'Отменён', 'cancelled', 'refunded' => 'color: #C8584C; border-color: rgba(200,88,76,.4); background: rgba(200,88,76,.08);',
        default => 'color: var(--mut); border-color: var(--line-2); background: transparent;'
    };
@endphp
<span style="font-size: 11px; letter-spacing: .1em; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; border: 1px solid; {{ $style }}">
    {{ $status }}
</span>
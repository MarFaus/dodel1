@props([
    'status' => 'active'
])

@php
    $classes = match($status) {
        'paid', 'ok', 'active' => 'border: 1px solid rgba(111,185,139,0.4); color: #6FB98B; background: rgba(111,185,139,0.08);',
        'pending', 'wait', 'few' => 'border: 1px solid rgba(210,161,75,0.4); color: #D2A14B; background: rgba(210,161,75,0.08);',
        'cancelled', 'bad', 'refunded' => 'border: 1px solid rgba(200,88,76,0.4); color: #C8584C; background: rgba(200,88,76,0.08);',
        default => 'border: 1px solid rgba(255,255,255,0.16); color: #8B8B91;'
    };
    
    $labels = [
        'paid' => 'Оплачен',
        'pending' => 'Ожидает оплаты',
        'cancelled' => 'Отменён',
        'refunded' => 'Возврат',
        'active' => 'Доступен',
        'few' => 'Билеты заканчиваются',
        'completed' => 'Завершено'
    ];
    $label = $labels[$status] ?? $status;
@endphp

<span style="font-size: 10.5px; letter-spacing: 0.1em; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; font-weight: 500; display: inline-block; {{ $classes }}">
    {{ $label }}
</span>
@props([
    'number' => 'ORD-0000',
    'eventTitle' => 'Событие',
    'date' => 'Дата проведения',
    'total' => 0,
    'status' => 'pending'
])

<div style="background: #0E0E10; border: 1px solid rgba(255,255,255,0.085); border-radius: 6px; padding: 16px 18px; margin-bottom: 12px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px;">
    <div>
        <div style="font-size: 11px; letter-spacing: 0.12em; text-transform: uppercase; color: #5E5E64;">Заказ {{ $number }}</div>
        <div style="font-weight: 500; font-size: 15px; color: #EFEDE8; margin-top: 2px;">{{ $eventTitle }}</div>
        <div style="font-size: 12.5px; color: #8B8B91; margin-top: 2px;">{{ $date }}</div>
    </div>

    <div style="display: flex; align-items: center; gap: 16px;">
        <x-badge :status="$status" />
        <div style="font-family: 'Unbounded', sans-serif; font-size: 16px; color: #C6A368; font-variant-numeric: tabular-nums;">
            {{ number_format($total, 0, '', ' ') }} ₸
        </div>
    </div>

    @if($slot->isNotEmpty())
        <div style="width: 100%; padding-top: 12px; margin-top: 8px; border-top: 1px dashed rgba(255,255,255,0.085); font-size: 13px; color: #8B8B91;">
            {{ $slot }}
        </div>
    @endif
</div>
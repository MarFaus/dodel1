@props([
    'id' => null,
    'title' => 'Без названия',
    'date' => 'Дата не указана',
    'category' => 'Событие',
    'hall' => 'Главная арена',
    'price' => 0,
    'status' => 'active'
])

<div style="background: #0A0A0B; border: 1px solid rgba(255,255,255,0.085); padding: 18px; display: flex; flex-direction: column; gap: 12px; border-radius: 6px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
        <span style="font-size: 11px; letter-spacing: 0.14em; text-transform: uppercase; color: #8B8B91;">{{ $category }}</span>
        <x-badge :status="$status" />
    </div>

    <h3 style="font-family: 'Unbounded', sans-serif; font-size: 16px; font-weight: 300; margin: 0; color: #EFEDE8; line-height: 1.3;">
        {{ $title }}
    </h3>

    <div style="font-size: 12.5px; color: #8B8B91; display: flex; flex-direction: column; gap: 4px;">
        <div>📅 {{ $date }}</div>
        <div>📍 {{ $hall }}</div>
    </div>

    <div style="margin-top: auto; padding-top: 10px; display: flex; align-items: center; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.085);">
        <div>
            <span style="font-size: 10px; text-transform: uppercase; color: #5E5E64; letter-spacing: 0.1em;">от</span>
            <span style="font-family: 'Unbounded', sans-serif; font-size: 16px; color: #C6A368; font-weight: 300;">{{ number_format($price, 0, '', ' ') }} ₸</span>
        </div>
        @if($id)
            <a href="/events/{{ $id }}" style="background: #EFEDE8; color: #0A0A0B; text-decoration: none; padding: 8px 14px; border-radius: 4px; font-size: 12.5px; font-weight: 500; transition: 0.2s;">
                Выбрать место
            </a>
        @else
            <button type="button" style="background: #EFEDE8; color: #0A0A0B; border: 0; padding: 8px 14px; border-radius: 4px; font-size: 12.5px; font-weight: 500; cursor: pointer;">
                Купить билет
            </button>
        @endif
    </div>
</div>
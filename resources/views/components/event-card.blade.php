@props(['id' => 1, 'title' => '', 'category' => 'Концерт', 'date' => '', 'hall' => '', 'price' => 0, 'status' => 'active'])
<div class="card" style="background: var(--surface); border: 1px solid var(--line); border-radius: 8px; padding: 20px; display: flex; flex-direction: column; gap: 12px; transition: border-color 0.2s;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <span style="font-size: 11px; letter-spacing: .14em; text-transform: uppercase; color: var(--gold);">{{ $category }}</span>
        <x-badge :status="$status === 'active' ? 'Доступен' : 'Билеты заканчиваются'" />
    </div>

    <h3 style="font-family: var(--display); font-size: 17px; font-weight: 300; margin: 0; color: var(--fg);">{{ $title }}</h3>
    
    <div style="font-size: 13px; color: var(--mut);">
        <div>📅 {{ $date }}</div>
        <div>🏛 {{ $hall }}</div>
    </div>

    <div style="margin-top: auto; padding-top: 12px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <small style="font-size: 10px; color: var(--dim); text-transform: uppercase;">от</small>
            <strong style="font-family: var(--display); font-size: 18px; color: var(--gold); font-weight: 300;">{{ number_format($price, 0, '', ' ') }} ₸</strong>
        </div>

        <button type="button" onclick="openHallPicker('{{ $id }}', '{{ addslashes($title) }}', '{{ $date }}', {{ $price }})" style="background: var(--fg); color: var(--ink); border: none; padding: 9px 16px; border-radius: 4px; font-weight: 600; font-size: 13px; transition: opacity .18s;">
            Выбрать места
        </button>
    </div>
</div>